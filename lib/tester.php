<?php
namespace php_require\php_tester;

class Tester {

    static public $renderer = null;

    static private $suite = "";

    static private $total = 0;

    static private $suites = array();

    static private $errors = array();

    static private function log($suite, $text, $error) {
        array_push(self::$errors, array($suite, $text, $error));
    }

    static public function describe($suite, $fn) {
        array_push(self::$suites, array($suite, $fn));
    }

    static public function it($text, $fn) {
        try {
            $fn();
            self::$renderer->success();
        } catch (\Exception $error) {
            self::log(self::$suite, $text, $error);
            self::$renderer->failure();
        }
        self::$total = self::$total + 1;
    }

    private function load($dir) {
        if ($handle = opendir($dir)) {
            while (false !== ($entry = readdir($handle))) {
                if (strpos($entry, ".php") !== false) {
                    include($dir . "/" . $entry);
                }
            }
            closedir($handle);
        }
    }

    public function renderer($renderer) {
        self::$renderer = $renderer;
    }

    public function run($dir = null) {

        self::$suite = "";
        self::$total = 0;
        self::$suites = array();
        self::$errors = array();

        $start = microtime(true);

        if (!$dir) {
            $dir = getcwd() . DIRECTORY_SEPARATOR . "test";
        }

        $this->load($dir);

        self::$renderer->begin();

        while (count(self::$suites) > 0) {
            $parts = array_pop(self::$suites);
            self::$suite = $parts[0];
            $fn = $parts[1];
            try {
                $fn();
            } catch (\Exception $error) {
                self::log(self::$suite, "", $error);
            }
        }

        $end = microtime(true) - $start;

        self::$renderer->errors(self::$errors);
        self::$renderer->finish(self::$total, $end, self::$errors);

        return count(self::$errors);
    }
}

$module->exports = new Tester();
