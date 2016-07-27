<?php

use TMciver\Functional\Either\Either;
use TMciver\Functional\Either\EitherArray;

class EitherTraverserTest extends PHPUnit_Framework_TestCase {

    private $traverseFn;

    public function __construct() {
        $this->traverseFn = function ($either) {
            if ($either->isLeft()) {
                // no sense in creating another Left when we already have one
                $result = $either;
            } else {
                $result = Either::fromValue($either->get() + 1);
            }

            return $result;
        };
    }

    public function testSequenceForEmptyArray() {

        $arrayOfEither = new EitherArray([]);
        $eitherOfArray = $arrayOfEither->sequence();
        $expected = Either::fromValue([]);

        $this->assertEquals($eitherOfArray, $expected);
    }

    public function testSequenceForAllRight() {

        $arrayOfEither = new EitherArray([Either::fromValue(1), Either::fromValue(2), Either::fromValue(3)]);
        $eitherOfArray = $arrayOfEither->sequence();
        $expected = Either::fromValue([1, 2, 3]);

        $this->assertEquals($eitherOfArray, $expected);
    }

    public function testSequenceForSomeLeft() {

        $arrayOfEither = new EitherArray([Either::fromValue(1), Either::left('Some Error'), Either::fromValue(3)]);
        $eitherOfArray = $arrayOfEither->sequence();
        $expected = Either::left('Some Error');

        $this->assertEquals($eitherOfArray, $expected);
    }

    public function testTraverseForEmptyArray() {

        $arrayOfEither = new EitherArray([]);
        $eitherOfArray = $arrayOfEither->traverse($this->traverseFn);
        $expected = Either::fromValue([]);

        $this->assertEquals($eitherOfArray, $expected);
    }

    public function testTraverseForAllRight() {

        $arrayOfEither = new EitherArray([Either::fromValue(1), Either::fromValue(2), Either::fromValue(3)]);
        $eitherOfArray = $arrayOfEither->traverse($this->traverseFn);
        $expected = Either::fromValue([2, 3, 4]);

        $this->assertEquals($eitherOfArray, $expected);
    }

    public function testTraverseForForSomeLeft() {

        $arrayOfEither = new EitherArray([Either::fromValue(1), Either::left('An error.'), Either::fromValue(3)]);
        $eitherOfArray = $arrayOfEither->traverse($this->traverseFn);
        $expected = Either::left('An error.');

        $this->assertEquals($eitherOfArray, $expected);
    }
}
