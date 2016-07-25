<?php

use TMciver\Functional\Either\Left;
use TMciver\Functional\Either\Right;

class EitherFunctorTest extends PHPUnit_Framework_TestCase {

    public function testIdentityLaw() {

	$id = function ($val) { return $val; };
	$eitherVal = new Right("Hello");
	$mappedEitherVal = $eitherVal->map($id);

	$this->assertEquals($eitherVal, $mappedEitherVal);
    }

    public function testMapRight() {

	$toUpper = function ($str) { return strtoupper($str); };
	$eitherStr = new Right("hello");
	$mappedEitherStr = $eitherStr->map($toUpper);
	$expectedEitherStr = new Right("HELLO");

	$this->assertEquals($mappedEitherStr, $expectedEitherStr);
    }

    public function testMapLeft() {

	$toUpper = function ($str) { return strtoupper($str); };
	$eitherStr = new Left("We have a problem!");
	$mappedEitherStr = $eitherStr->map($toUpper);

	$this->assertInstanceOf('TMciver\Functional\Either\Left', $mappedEitherStr);
    }
}
