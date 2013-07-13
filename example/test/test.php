<?php
describe("Array", function () {

    describe("array_search()", function () {

        it("should return false when the value is not present", function () {
            $array = array(1, 2, 3, 4, 5);
            assert(array_search(3, $array) === 2);
            assert(array_search(6, $array) === false);
        });
    });
});
