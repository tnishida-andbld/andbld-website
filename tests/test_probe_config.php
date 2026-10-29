<?php
require __DIR__.'/../scripts/probe-development.php';
function check($condition) { if (!$condition) throw new RuntimeException('Test failed'); }
$fixture = <<<'CONFIG'
<?php
// Configuration must be parsed as data, never executed.
define('DB_NAME', 'andbld_i0006s1');
define('DB_USER', 'fixture');
define('DB_PASSWORD', 'a\'b\\c');
define('DB_HOST', 'localhost');
$table_prefix = 'ab_';
throw new Exception('MUST NOT EXECUTE');
CONFIG;
$parsed = probe_config($fixture);
check($parsed['DB_PASSWORD'] === "a'b\\c");
foreach ([
    str_replace('andbld_i0006s1','production',$fixture),
    str_replace("'localhost'", "getenv('HOST')", $fixture),
    str_replace("'ab_'", "'ab_; DROP TABLE posts'", $fixture),
    $fixture."\ndefine('DB_NAME', 'andbld_i0006s1');",
    str_replace("'fixture'", "'fix'.'ture'", $fixture),
] as $invalid) {
    $rejected = false;
    try { probe_config($invalid); } catch (RuntimeException $e) { $rejected = true; }
    check($rejected);
}
$rejected = false;
try { probe_root('/not/a/development/theme'); } catch (RuntimeException $e) { $rejected = true; }
check($rejected);
echo "Config/path guard tests passed.\n";

// Layout mismatch must stop before inspecting the candidate or its parent.
$stage = null;
$rejected = false;
try { probe_storage('/fixture/SECRET/nonstandard-root', $stage); }
catch (RuntimeException $e) { $rejected = true; }
check($rejected && $stage === 'storage_layout');
check(strpos($stage, 'SECRET') === false);

// Local fixture only. No remote directories are created by the probe.
$tmp = sys_get_temp_dir().'/andbld-storage-'.bin2hex(random_bytes(8));
mkdir($tmp); mkdir($tmp.'/public_html');
try {
    $a = probe_storage($tmp.'/public_html', $stage);
    check($stage === 'storage_capacity');
    check($a['container']['kind'] === 'absent_or_unreadable');
    check($a['post_directory']['kind'] === 'not_checked');
    check(!file_exists($tmp.'/private-article-backups'));
    file_put_contents($tmp.'/private-article-backups', 'fixture');
    $a = probe_storage($tmp.'/public_html');
    check($a['container']['kind'] === 'other' && $a['post_directory']['kind'] === 'not_checked');
    unlink($tmp.'/private-article-backups');
    mkdir($tmp.'/private-article-backups');
    mkdir($tmp.'/private-article-backups/post-318');
    $a = probe_storage($tmp.'/public_html');
    check($a['container']['kind'] === 'directory');
    check($a['ready_for_backup'] === false && $a['web_exposure'] === 'not_verified');
    check(strpos(json_encode($a), $tmp) === false);
    rmdir($tmp.'/private-article-backups/post-318');
    rmdir($tmp.'/private-article-backups');
    if (PHP_OS_FAMILY !== 'Windows') {
        symlink($tmp.'/public_html', $tmp.'/private-article-backups');
        $a = probe_storage($tmp.'/public_html');
        check($a['container']['kind'] === 'symlink' && $a['post_directory']['kind'] === 'not_checked');
        unlink($tmp.'/private-article-backups');
    } else { echo "Symlink fixture skipped on Windows.\n"; }
} finally {
    if (is_link($tmp.'/private-article-backups') || is_file($tmp.'/private-article-backups')) unlink($tmp.'/private-article-backups');
    if (is_dir($tmp.'/private-article-backups/post-318')) rmdir($tmp.'/private-article-backups/post-318');
    if (is_dir($tmp.'/private-article-backups')) rmdir($tmp.'/private-article-backups');
    rmdir($tmp.'/public_html'); rmdir($tmp);
}
echo "Storage inventory fixture tests passed.\n";
