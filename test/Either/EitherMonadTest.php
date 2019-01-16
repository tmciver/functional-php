<?php

use PHPUnit\Framework\TestCase;
use PhatCats\Either\Either;
use PhatCats\Either\Monad\RightFavoringEitherMonad;

class EitherMonadTest extends TestCase {

    private $monad;

    protected function setUp() {
        $this->monad = new RightFavoringEitherMonad();
    }

    public function testPure() {

        // create a wrapped val
        $wrappedVal = $this->monad->pure("Hello!");

        $this->assertInstanceOf('PhatCats\Either\Right', $wrappedVal);
        $this->assertEquals($wrappedVal->get(), "Hello!");
    }

    public function testFlatMapForRight() {

        $eitherInt = Either::fromValue(1);
        $eitherIntPlusOne = $this->monad->flatMap($eitherInt, function ($i) {
            return Either::fromValue($i + 1);
        });

        $this->assertEquals($eitherIntPlusOne->get(), 2);
    }

    public function testFlatMapForLeft() {

        $eitherInt = Either::left("Error!");
        $eitherIntPlusOne = $this->monad->flatMap($eitherInt, function ($i) {
            return Either::fromValue($i + 1);
        });

        $this->assertInstanceOf('PhatCats\Either\Left', $eitherIntPlusOne);
    }

    public function testEitherGetOrElseForRight() {
        $either = Either::fromValue("Hello!");
        $val = $this->monad->getOrElse($either, "World!");

        $this->assertEquals("Hello!", $val);
    }

    public function testEitherGetOrElseForLeft() {
        $either = Either::left('');
        $val = $this->monad->getOrElse($either, "World!");

        $this->assertEquals("World!", $val);
    }
}
