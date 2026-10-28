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
