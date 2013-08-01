<?php
use php_require\php_tester\Tester;

$tester = $require(__DIR__ . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "tester");

// Active assert and make it quiet
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 0);
assert_options(ASSERT_QUIET_EVAL, 1);
assert_options(ASSERT_CALLBACK, function ($file, $line, $code) {
    throw new Exception();
});

function describe($text, $fn) {
    Tester::describe($text, $fn);
}

function it($text, $fn) {
    Tester::it($text, $fn);
}

/*
    Get params from the CLI
*/

$dir = getcwd() . DIRECTORY_SEPARATOR . "test";
$renderer = "simple";

/*
    Load the renderer to use.
*/

$renderer = $require(__DIR__. DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . $renderer);
$tester->renderer($renderer);

/*
    If xdebug is NOT installed.
*/

if (!function_exists("xdebug_start_code_coverage")) {
    $errors = $tester->run($dir);
    exit($errors);
}

/*
    If xdebug IS installed.
*/

xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);

$errors = $tester->run($dir);

$files = xdebug_get_code_coverage();

$checked = array();
$total = 0;
$called = 0;
$missed = 0;
$unused = 0;

foreach ($files as $file => $lines) {
    // Only report files in the package folder && not files in the test directory.
    if (strpos($file, dirname($dir)) !== false && strpos($file, $dir) === false) {
        // echo $file . "\n";
        array_push($checked, $file);
        foreach ($lines as $num => $line) {
            // echo $num . ": " . $line . "\n";
            if ($line === 1) {
                $total++;
                $called++;
            } else if ($line === -1) {
                $total++;
                $missed++;
            } else if ($line === -2) {
                $unused++;
            }
        }
    }
}

xdebug_stop_code_coverage(true);

echo("Checking covergae of files:\n\n");

array_walk($checked, function ($item) {
    echo($item. "\n");
});

echo("\nTotal code covergae: " . round(($called / $total) * 100) . "%\n\n");

exit($errors);
