<?php

use TMciver\Functional\Maybe\Just;
use TMciver\Functional\Maybe\Nothing;
use TMciver\Functional\Maybe\MaybeArray;

class MaybeTraverserTest extends PHPUnit_Framework_TestCase {

    private $traverseFn;

    public function __construct() {
        $this->traverseFn = function ($maybe) {
            if ($maybe->isNothing()) {
                // no sense in creating another Nothing when we already have one
                $result = $maybe;
            } else {
                $result = new Just($maybe->get() + 1);
            }

            return $result;
        };
    }

    public function testSequenceForEmptyArray() {

        $arrayOfMaybe = new MaybeArray([]);
        $maybeOfArray = $arrayOfMaybe->sequence();
        $expected = new Just([]);

        $this->assertEquals($maybeOfArray, $expected);
    }

    public function testSequenceForAllJust() {

        $arrayOfMaybe = new MaybeArray([new Just(1), new Just(2), new Just(3)]);
        $maybeOfArray = $arrayOfMaybe->sequence($arrayOfMaybe);
        $expected = new Just([1, 2, 3]);

        $this->assertEquals($maybeOfArray, $expected);
    }

    public function testSequenceForSomeNothing() {

        $arrayOfMaybe = new MaybeArray([new Just(1), new Nothing(), new Just(3)]);
        $maybeOfArray = $arrayOfMaybe->sequence($arrayOfMaybe);
        $expected = new Nothing();

        $this->assertEquals($maybeOfArray, $expected);
    }

    public function testTraverseForEmptyArray() {

        $arrayOfMaybe = new MaybeArray([]);
        $maybeOfArray = $arrayOfMaybe->traverse($this->traverseFn, $arrayOfMaybe);
        $expected = new Just([]);

        $this->assertEquals($maybeOfArray, $expected);
    }

    public function testTraverseForAllJust() {

        $arrayOfMaybe = new MaybeArray([new Just(1), new Just(2), new Just(3)]);
        $maybeOfArray = $arrayOfMaybe->traverse($this->traverseFn, $arrayOfMaybe);
        $expected = new Just([2, 3, 4]);

        $this->assertEquals($maybeOfArray, $expected);
    }

    public function testTraverseForForSomeNothing() {

        $arrayOfMaybe = new MaybeArray([new Just(1), new Nothing(), new Just(3)]);
        $maybeOfArray = $arrayOfMaybe->traverse($this->traverseFn, $arrayOfMaybe);
        $expected = new Nothing();

        $this->assertEquals($maybeOfArray, $expected);
    }
}
