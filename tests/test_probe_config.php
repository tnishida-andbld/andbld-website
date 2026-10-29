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

// Synthetic path classification only: no filesystem or server writes.
foreach ([
    ['/SECRET/site/public_html', 'root_named_public_html', 0],
    ['/SECRET/site/public_html/dev-20260601.andbld.co.jp', 'root_below_public_html', 1],
    ['/SECRET/site/public_html/dev/wordpress', 'root_below_public_html', 2],
    ['/SECRET/site/custom', 'no_public_html_component', null],
    ['/SECRET/public_html/site/public_html', 'ambiguous', null]
] as [$path, $expected, $depth]) {
    $a = probe_storage($path, $stage);
    check($a['layout'] === $expected && $a['levels_below_public_html'] === $depth);
    check($a['candidate_inspection'] === 'not_performed');
    check($a['web_exposure'] === 'not_verified' && $a['ready_for_backup'] === false);
    check(strpos(json_encode($a), 'SECRET') === false);
}
echo "Layout classification tests passed.\n";
