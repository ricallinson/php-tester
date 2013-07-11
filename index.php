<?php
use php_require\php_tester\Tester;

$tester = $require(__DIR__ . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "tester");
$renderer = $require(__DIR__. DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "simple");

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

$tester->renderer($renderer);
$tester->run();
