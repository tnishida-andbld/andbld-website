<?php
// Deliberately do not include wp-config.php or bootstrap WordPress.
function probe_literal($token) {
    if (!is_array($token) || $token[0] !== T_CONSTANT_ENCAPSED_STRING) {
        throw new RuntimeException('Unsupported config expression');
    }
    $s = $token[1];
    $v = substr($s, 1, -1);
    if ($s[0] === "'") {
        return str_replace(["\\'", "\\\\"], ["'", "\\"], $v);
    }
    if (strpbrk($v, "\\$") !== false) {
        throw new RuntimeException('Unsupported quoted value');
    }
    return $v;
}

function probe_config($source) {
    $ts = array_values(array_filter(token_get_all($source), function ($t) {
        return !is_array($t) || !in_array($t[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true);
    }));
    $values = [];
    for ($i = 0; $i < count($ts); $i++) {
        $t = $ts[$i];
        if (is_array($t) && $t[0] === T_STRING && strtolower($t[1]) === 'define' && ($ts[$i+1] ?? null) === '(') {
            $keyToken = $ts[$i+2] ?? null;
            if (!is_array($keyToken) || $keyToken[0] !== T_CONSTANT_ENCAPSED_STRING) continue;
            $key = probe_literal($keyToken);
            if (!in_array($key, ['DB_NAME', 'DB_HOST', 'DB_USER', 'DB_PASSWORD'], true)) continue;
            if (isset($values[$key]) || ($ts[$i+3] ?? null) !== ',' || ($ts[$i+5] ?? null) !== ')' || ($ts[$i+6] ?? null) !== ';') {
                throw new RuntimeException('Ambiguous config');
            }
            $values[$key] = probe_literal($ts[$i+4] ?? null);
        }
        if (is_array($t) && $t[0] === T_VARIABLE && $t[1] === '$table_prefix') {
            if (isset($values['prefix']) || ($ts[$i+1] ?? null) !== '=' || ($ts[$i+3] ?? null) !== ';') {
                throw new RuntimeException('Ambiguous prefix');
            }
            $values['prefix'] = probe_literal($ts[$i+2] ?? null);
        }
    }
    foreach (['DB_NAME', 'DB_HOST', 'DB_USER', 'DB_PASSWORD', 'prefix'] as $key) {
        if (!array_key_exists($key, $values)) throw new RuntimeException('Missing config');
    }
    if ($values['DB_NAME'] !== 'andbld_i0006s1' || !preg_match('/^[a-zA-Z0-9_]+$/D', $values['prefix']) || !preg_match('/^[a-zA-Z0-9.-]+$/D', $values['DB_HOST'])) {
        throw new RuntimeException('Unexpected database configuration');
    }
    return $values;
}

function probe_root($theme) {
    $real = realpath($theme);
    $suffix = '/wp-content/themes/andbld';
    if ($real === false || substr($real, -strlen($suffix)) !== $suffix) throw new RuntimeException('Invalid theme path');
    $root = substr($real, 0, -strlen($suffix));
    if (!in_array('dev-20260601.andbld.co.jp', explode('/', $root), true) || !is_file($root.'/wp-load.php') || !is_file($root.'/wp-config.php')) {
        throw new RuntimeException('Unexpected installation');
    }
    // Refuse config symlinks outside the confirmed Development root.
    if (realpath($root.'/wp-config.php') !== $root.'/wp-config.php') throw new RuntimeException('Config symlink');
    return $root;
}

function probe_storage_node($path) {
    $s = @lstat($path);
    if ($s === false) return ['kind'=>'absent_or_unreadable', 'owner_matches_process'=>null, 'mode'=>null];
    $type = $s['mode'] & 0170000;
    return ['kind'=>$type === 0120000 ? 'symlink' : ($type === 0040000 ? 'directory' : 'other'),
        'owner_matches_process'=>function_exists('posix_geteuid') ? $s['uid'] === posix_geteuid() : null,
        'mode'=>sprintf('%04o', $s['mode'] & 07777)];
}

function probe_storage($root, &$stage = null) {
    $stage = 'storage_layout';
    if (basename($root) !== 'public_html') throw new RuntimeException('Unexpected public root');
    $parent = dirname($root);
    $container = $parent.'/private-article-backups';
    $stage = 'storage_parent';
    $p = probe_storage_node($parent);
    $stage = 'storage_container';
    $c = probe_storage_node($container);
    // Never traverse a candidate symlink, file, or inaccessible directory.
    $child = ['kind'=>'not_checked', 'owner_matches_process'=>null, 'mode'=>null];
    $stage = 'storage_child';
    if ($c['kind'] === 'directory' && is_readable($container) && is_executable($container)) {
        $child = probe_storage_node($container.'/post-318');
    }
    $stage = 'storage_capacity';
    $free = @disk_free_space($parent);
    return ['parent'=>$p, 'container'=>$c, 'post_directory'=>$child,
        'free_bytes'=>$free === false ? null : (int)$free,
        'outside_confirmed_wp_root'=>true, 'web_exposure'=>'not_verified', 'ready_for_backup'=>false];
}

function probe_main($theme, $wpAvailable) {
    ini_set('display_errors', '0');
    ini_set('log_errors', '0');
    $stage = 'installation';
    try {
        $root = probe_root($theme);
        $stage = 'config';
        $v = probe_config(file_get_contents($root.'/wp-config.php'));
        $stage = 'database';
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $db = mysqli_init();
        $db->options(MYSQLI_OPT_CONNECT_TIMEOUT, 10);
        $db->real_connect($v['DB_HOST'], $v['DB_USER'], $v['DB_PASSWORD'], $v['DB_NAME']);
        unset($v['DB_PASSWORD']);
        $db->set_charset('utf8mb4');
        $db->query('SET TRANSACTION READ ONLY');
        $db->query('START TRANSACTION');
        $prefix = $v['prefix'];
        $stage = 'site_identity';
        $result = $db->query("SELECT option_name, option_value FROM `{$prefix}options` WHERE option_name IN ('home','siteurl')");
        $urls = [];
        while ($row = $result->fetch_assoc()) $urls[$row['option_name']] = $row['option_value'];
        foreach (['home','siteurl'] as $key) {
            if (!isset($urls[$key]) || rtrim($urls[$key], '/') !== 'https://dev-20260601.andbld.co.jp') throw new RuntimeException('Wrong site');
        }
        $stage = 'article_identity';
        $r = $db->query("SELECT ID, post_type, post_name, post_status, OCTET_LENGTH(post_content) AS content_bytes, SHA2(post_content,256) AS content_sha256 FROM `{$prefix}posts` WHERE ID=318")->fetch_assoc();
        if (!$r || $r['post_type'] !== 'blog' || $r['post_name'] !== 'claude-code-github-ai-development-workflow' || $r['post_status'] !== 'publish' || !preg_match('/^[a-f0-9]{64}$/D', $r['content_sha256'] ?? '')) {
            throw new RuntimeException('Wrong article');
        }
        $db->rollback();
        $db->close();
        $stage = 'storage';
        $storage = probe_storage($root, $stage);
        $stage = 'response_encoding';
        echo json_encode([
            'status'=>'OK', 'post_id'=>318, 'site_identity'=>'development_verified',
            'wp_cli_on_path'=>$wpAvailable === 'yes', 'wp_cli_execution'=>'not_tested',
            'php_version'=>PHP_VERSION, 'content_bytes'=>(int)$r['content_bytes'],
            'content_sha256'=>$r['content_sha256'],
            'backup_parent_writable'=>is_writable(dirname($root)),
            'storage'=>$storage,
            'backup_create_restore'=>'not_tested', 'ssh_scope'=>'not_verified',
            'wordpress_bootstrap'=>false
        ], JSON_THROW_ON_ERROR)."\n";
    } catch (Throwable $e) {
        // Exception text may contain paths or credentials; never expose it.
        echo json_encode(['status'=>'ERROR', 'stage'=>$stage])."\n";
        exit(1);
    }
}
