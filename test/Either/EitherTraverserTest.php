<?php

use TMciver\Functional\Either\Right;
use TMciver\Functional\Either\Left;
use TMciver\Functional\Either\EitherTraverser;

class EitherTraverserTest extends PHPUnit_Framework_TestCase {

    private $traverser;
    private $traverseFn;

    public function __construct() {
        $this->traverser = new EitherTraverser();
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

        $arrayOfEither = [];
        $eitherOfArray = $this->traverser->sequence($arrayOfEither);
        $expected = new Right([]);

        $this->assertEquals($eitherOfArray, $expected);
    }

    public function testSequenceForAllRight() {

        $arrayOfEither = [new Right(1), new Right(2), new Right(3)];
        $eitherOfArray = $this->traverser->sequence($arrayOfEither);
        $expected = new Right([1, 2, 3]);

        $this->assertEquals($eitherOfArray, $expected);
    }

    public function testSequenceForSomeLeft() {

        $arrayOfEither = [new Right(1), new Left(''), new Right(3)];
        $eitherOfArray = $this->traverser->sequence($arrayOfEither);
        $expected = new Left('');

        $this->assertEquals($eitherOfArray, $expected);
    }

    public function testTraverseForEmptyArray() {

        $arrayOfEither = [];
        $eitherOfArray = $this->traverser->traverse($this->traverseFn, $arrayOfEither);
        $expected = new Right([]);

        $this->assertEquals($eitherOfArray, $expected);
    }

    public function testTraverseForAllRight() {

        $arrayOfEither = [new Right(1), new Right(2), new Right(3)];
        $eitherOfArray = $this->traverser->traverse($this->traverseFn, $arrayOfEither);
        $expected = new Right([2, 3, 4]);

        $this->assertEquals($eitherOfArray, $expected);
    }

    public function testTraverseForForSomeLeft() {

        $arrayOfEither = [new Right(1), new Left(''), new Right(3)];
        $eitherOfArray = $this->traverser->traverse($this->traverseFn, $arrayOfEither);
        $expected = new Left('');

        $this->assertEquals($eitherOfArray, $expected);
    }
}
