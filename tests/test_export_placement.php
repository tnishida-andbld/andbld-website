<?php
declare(strict_types=1);
require __DIR__ . '/../scripts/inspect-export-placement.php';
function check(bool $ok, string $case): void {
    if (!$ok) { throw new RuntimeException($case); }
    echo "PASS " . $case . "\n";
}
$root = sys_get_temp_dir() . '/andbld-placement-' . bin2hex(random_bytes(8));
mkdir($root, 0700);
$root = realpath($root);
$uid = (int)fileowner($root);
// Windows lacks Unix permission semantics. Normalize only the fixture metadata;
// production main always uses the real node inspector with no override.
$fixtureInspect = function (string $path, int $owner): array {
    $node = placement_node($path, $owner);
    if (PHP_OS_FAMILY === 'Windows' && isset($node['mode'])) {
        $node['mode'] = $node['kind'] === 'directory' ? '0700' : '0600';
        $node['group_or_other_writable'] = false;
    }
    return $node;
};
try {
    $r = placement_inventory($root, $uid, $fixtureInspect);
    check($r['candidate']['kind'] === 'absent_or_unreadable' && !$r['ready_for_install'], 'missing candidate never approved');
    file_put_contents($root . '/private-article-export', 'PRIVATE-CONTENT');
    $r = placement_inventory($root, $uid, $fixtureInspect);
    check($r['candidate']['kind'] === 'file', 'existing file classified without reading');
    check(!str_contains(json_encode($r), $root) && !str_contains(json_encode($r), 'PRIVATE-CONTENT'), 'paths and contents suppressed');
    unlink($root . '/private-article-export');
    mkdir($root . '/private-article-export', 0700);
    mkdir($root . '/.ssh', 0700);
    file_put_contents($root . '/.ssh/authorized_keys', 'FAKE-KEY-CONTENT');
    $r = placement_inventory($root, $uid, $fixtureInspect);
    check($r['candidate']['kind'] === 'directory' && $r['authorized_keys']['kind'] === 'file', 'fixed metadata targets');
    check(!str_contains(json_encode($r), 'FAKE-KEY-CONTENT') && $r['effective_key_sources'] === 'not_verified', 'no key contents or effective source claim');
    $r = placement_inventory($root, $uid + 1, $fixtureInspect);
    check($r['candidate']['kind'] === 'not_checked', 'owner mismatch stops traversal');
    $calls = [];
    $r = placement_inventory($root, $uid, function ($path, $owner) use ($root, &$calls, $fixtureInspect) {
        $calls[] = $path;
        if ($path === $root . '/.ssh') { return ['kind' => 'symlink']; }
        return $fixtureInspect($path, $owner);
    });
    check($r['authorized_keys']['kind'] === 'not_checked' && count($calls) === 3, 'simulated symlink blocks child stat');
    $r = placement_inventory($root, $uid, function ($path, $owner) {
        return ['kind' => 'directory', 'owner_matches' => true, 'mode' => '0777', 'group_or_other_writable' => true];
    });
    check($r['candidate']['kind'] === 'not_checked', 'simulated writable home stops traversal');
    if (PHP_OS_FAMILY !== 'Windows') {
        chmod($root, 0777);
        check(placement_inventory($root, $uid)['candidate']['kind'] === 'not_checked', 'unsafe home stops traversal');
        chmod($root, 0700);
        unlink($root . '/.ssh/authorized_keys');
        rmdir($root . '/.ssh');
        symlink($root . '/private-article-export', $root . '/.ssh');
        $r = placement_inventory($root, $uid);
        check($r['ssh_directory']['kind'] === 'symlink' && $r['authorized_keys']['kind'] === 'not_checked', 'ssh link not traversed');
    } else {
        echo "SKIP Unix permission and symlink fixtures on Windows\n";
    }
} finally {
    // Only known fixture paths; never recurse or follow a directory link.
    if (is_link($root . '/.ssh')) { unlink($root . '/.ssh'); }
    else {
        if (is_file($root . '/.ssh/authorized_keys')) { unlink($root . '/.ssh/authorized_keys'); }
        if (is_dir($root . '/.ssh')) { rmdir($root . '/.ssh'); }
    }
    if (is_file($root . '/private-article-export')) { unlink($root . '/private-article-export'); }
    if (is_dir($root . '/private-article-export')) { rmdir($root . '/private-article-export'); }
    rmdir($root);
}
