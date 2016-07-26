<?php

use TMciver\Functional\Maybe\Maybe;
use TMciver\Functional\Maybe\MaybeArray;

class MaybeTraverserTest extends PHPUnit_Framework_TestCase {

    private $traverseFn;

    public function __construct() {
        $this->traverseFn = function ($maybe) {
            if ($maybe->isNothing()) {
                // no sense in creating another Nothing when we already have one
                $result = $maybe;
            } else {
                $result = Maybe::fromValue($maybe->get() + 1);
            }

            return $result;
        };
    }

    public function testSequenceForEmptyArray() {

        $arrayOfMaybe = new MaybeArray([]);
        $maybeOfArray = $arrayOfMaybe->sequence();
        $expected = Maybe::fromValue([]);

        $this->assertEquals($maybeOfArray, $expected);
    }

    public function testSequenceForAllJust() {

        $arrayOfMaybe = new MaybeArray([Maybe::fromValue(1), Maybe::fromValue(2), Maybe::fromValue(3)]);
        $maybeOfArray = $arrayOfMaybe->sequence($arrayOfMaybe);
        $expected = Maybe::fromValue([1, 2, 3]);

        $this->assertEquals($maybeOfArray, $expected);
    }

    public function testSequenceForSomeNothing() {

        $arrayOfMaybe = new MaybeArray([Maybe::fromValue(1), Maybe::nothing(), Maybe::fromValue(3)]);
        $maybeOfArray = $arrayOfMaybe->sequence($arrayOfMaybe);
        $expected = Maybe::nothing();

        $this->assertEquals($maybeOfArray, $expected);
    }

    public function testTraverseForEmptyArray() {

        $arrayOfMaybe = new MaybeArray([]);
        $maybeOfArray = $arrayOfMaybe->traverse($this->traverseFn, $arrayOfMaybe);
        $expected = Maybe::fromValue([]);

        $this->assertEquals($maybeOfArray, $expected);
    }

    public function testTraverseForAllJust() {

        $arrayOfMaybe = new MaybeArray([Maybe::fromValue(1), Maybe::fromValue(2), Maybe::fromValue(3)]);
        $maybeOfArray = $arrayOfMaybe->traverse($this->traverseFn, $arrayOfMaybe);
        $expected = Maybe::fromValue([2, 3, 4]);

        $this->assertEquals($maybeOfArray, $expected);
    }

    public function testTraverseForForSomeNothing() {

        $arrayOfMaybe = new MaybeArray([Maybe::fromValue(1), Maybe::nothing(), Maybe::fromValue(3)]);
        $maybeOfArray = $arrayOfMaybe->traverse($this->traverseFn, $arrayOfMaybe);
        $expected = Maybe::nothing();

        $this->assertEquals($maybeOfArray, $expected);
    }
}
