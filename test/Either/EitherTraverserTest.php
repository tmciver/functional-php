<?php

use TMciver\Functional\Either\Right;
use TMciver\Functional\Either\Left;
use TMciver\Functional\Either\EitherArray;

class EitherTraverserTest extends PHPUnit_Framework_TestCase {

    private $traverseFn;

    public function __construct() {
        $this->traverseFn = function ($either) {
            if ($either->isLeft()) {
                // no sense in creating another Left when we already have one
                $result = $either;
            } else {
                $result = new Right($either->get() + 1);
            }

            return $result;
        };
    }

    public function testSequenceForEmptyArray() {

        $arrayOfEither = new EitherArray([]);
        $eitherOfArray = $arrayOfEither->sequence();
        $expected = new Right([]);

        $this->assertEquals($eitherOfArray, $expected);
    }

    public function testSequenceForAllRight() {

        $arrayOfEither = new EitherArray([new Right(1), new Right(2), new Right(3)]);
        $eitherOfArray = $arrayOfEither->sequence();
        $expected = new Right([1, 2, 3]);

        $this->assertEquals($eitherOfArray, $expected);
    }

    public function testSequenceForSomeLeft() {

        $arrayOfEither = new EitherArray([new Right(1), new Left('Some Error'), new Right(3)]);
        $eitherOfArray = $arrayOfEither->sequence();
        $expected = new Left('Some Error');

        $this->assertEquals($eitherOfArray, $expected);
    }

    public function testTraverseForEmptyArray() {

        $arrayOfEither = new EitherArray([]);
        $eitherOfArray = $arrayOfEither->traverse($this->traverseFn);
        $expected = new Right([]);

        $this->assertEquals($eitherOfArray, $expected);
    }

    public function testTraverseForAllRight() {

        $arrayOfEither = new EitherArray([new Right(1), new Right(2), new Right(3)]);
        $eitherOfArray = $arrayOfEither->traverse($this->traverseFn);
        $expected = new Right([2, 3, 4]);

        $this->assertEquals($eitherOfArray, $expected);
    }

    public function testTraverseForForSomeLeft() {

        $arrayOfEither = new EitherArray([new Right(1), new Left('An error.'), new Right(3)]);
        $eitherOfArray = $arrayOfEither->traverse($this->traverseFn);
        $expected = new Left('An error.');

        $this->assertEquals($eitherOfArray, $expected);
    }
}
