# Php-tester

[![Build Status](https://secure.travis-ci.org/ricallinson/php-tester.png?branch=master)](http://travis-ci.org/ricallinson/php-tester)

Simple test framework for PHP inspired by [Mocha](http://visionmedia.github.io/mocha/) for use with [php-require](https://github.com/ricallinson/php-require).

    ./test/test.php
    <?php
    describe("Array", function () {
        describe("array_search()", function () {
            it("should return false when the value is not present", function () {
                $array = array(1, 2, 3, 4, 5);
                assert(array_search(3, $array) === 3);
                assert(array_search(6, $array) === false);
            });
        });
    });

Then;

    ./bin/tester
