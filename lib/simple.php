<?php
namespace php_require\php_tester;

class SimpleRenderer {

    public function begin() {
        print("\n\nRunning Tests\n\n");
    }

    public function finish($total, $time, $status) {
        print("\n\n" . ($status ? "Failed" : "Passed") . " - " . $total . " complete (" . round($time * 1000, 0) . "ms)\n\n");
    }

    public function success() {
        print(".");
    }

    public function failure() {
        print("|");
    }

    public function errors($errors) {

        foreach ($errors as $error) {
            print("\n\n");
            print($error[0] . ": " . $error[1]);
            print("\t" . $error[2]->getMessage() . "\n");
            print("\n");
            print($error[2]->getTraceAsString() . "\n");
        }
    }
}

$module->exports = new SimpleRenderer();
