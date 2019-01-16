<?php

use PHPUnit\Framework\TestCase;
use PhatCats\Either\Either;
use PhatCats\Either\EitherToMaybe;
use PhatCats\Maybe\Maybe;

class EitherVisitorTest extends TestCase {

    public function testEitherToMaybeForRight() {

        $right = Either::fromValue("Hello");
        $conversionVisitor = new EitherToMaybe();
        $actualMaybe = $right->accept($conversionVisitor);
        $expectedMaybe = Maybe::fromValue("Hello");

        $this->assertEquals($expectedMaybe, $actualMaybe);
    }

    public function testEitherToMaybeForLeft() {

        $left = Either::left("I am Error!");
        $conversionVisitor = new EitherToMaybe();
        $actualMaybe = $left->accept($conversionVisitor);
        $expectedMaybe = Maybe::nothing();

        $this->assertEquals($expectedMaybe, $actualMaybe);
    }
}
