<?php

use PHPUnit\Framework\TestCase;
use TMciver\Functional\Either\Either;

class EitherFunctorTest extends TestCase {

    public function testIdentityLaw() {

	$id = function ($val) { return $val; };
	$eitherVal = Either::fromValue("Hello");
	$mappedEitherVal = $eitherVal->map($id);

	$this->assertEquals($eitherVal, $mappedEitherVal);
    }

    public function testMapRight() {

	$toUpper = function ($str) { return strtoupper($str); };
	$eitherStr = Either::fromValue("hello");
	$mappedEitherStr = $eitherStr->map($toUpper);
	$expectedEitherStr = Either::fromValue("HELLO");

	$this->assertEquals($mappedEitherStr, $expectedEitherStr);
    }

    public function testMapLeft() {

	$toUpper = function ($str) { return strtoupper($str); };
	$eitherStr = Either::left("We have a problem!");
	$mappedEitherStr = $eitherStr->map($toUpper);

	$this->assertInstanceOf('TMciver\Functional\Either\Left', $mappedEitherStr);
    }
}
