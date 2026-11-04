<?php
// Metadata only. No directory listing, file contents, DB, or mutations.
declare(strict_types=1);

function placement_node(string $path, int $uid): array {
    clearstatcache(true, $path);
    $s = @lstat($path);
    if ($s === false) {
        return ['kind' => 'absent_or_unreadable'];
    }
    $type = $s['mode'] & 0170000;
    $kind = $type === 0120000 ? 'symlink' : ($type === 0040000 ? 'directory' : ($type === 0100000 ? 'file' : 'other'));
    return ['kind' => $kind, 'owner_matches' => $s['uid'] === $uid,
            'mode' => sprintf('%04o', $s['mode'] & 07777),
            'group_or_other_writable' => (bool)($s['mode'] & 0022)];
}

function placement_inventory(string $home, int $uid, ?callable $inspect = null): array {
    $inspect = $inspect ?? 'placement_node';
    // Production caller obtains home from the OS account record, not $HOME.
    $out = ['status' => 'metadata_only', 'home' => ['kind' => 'not_checked'],
            'candidate' => ['kind' => 'not_checked'], 'ssh_directory' => ['kind' => 'not_checked'],
            'authorized_keys' => ['kind' => 'not_checked'],
            'web_exposure' => 'not_verified', 'effective_key_sources' => 'not_verified',
            'recovery_access' => 'not_verified', 'ready_for_install' => false];
    if ($home === '' || @realpath($home) !== $home) {
        return $out;
    }
    $out['home'] = $inspect($home, $uid);
    $h = $out['home'];
    if ($h['kind'] !== 'directory' || !$h['owner_matches'] || $h['group_or_other_writable']) {
        return $out;
    }
    $out['candidate'] = $inspect($home . '/private-article-export', $uid);
    $out['ssh_directory'] = $inspect($home . '/.ssh', $uid);
    $s = $out['ssh_directory'];
    if ($s['kind'] === 'directory' && $s['owner_matches'] && !$s['group_or_other_writable']) {
        $out['authorized_keys'] = $inspect($home . '/.ssh/authorized_keys', $uid);
    }
    return $out;
}

function placement_main(): int {
    if (PHP_SAPI !== 'cli' || !function_exists('posix_geteuid') || !function_exists('posix_getpwuid')) {
        echo "{\"status\":\"inspection_unavailable\"}\n";
        return 1;
    }
    $uid = posix_geteuid();
    $account = posix_getpwuid($uid);
    if (!is_array($account) || !isset($account['dir']) || !is_string($account['dir'])) {
        echo "{\"status\":\"inspection_unavailable\"}\n";
        return 1;
    }
    echo json_encode(placement_inventory($account['dir'], $uid), JSON_UNESCAPED_SLASHES) . "\n";
    return 0;
}
// No auto-execution on include. Reviewed transport must explicitly call main.
