<?php

use TMciver\Functional\Either\Left;
use TMciver\Functional\Either\Right;

class EitherFunctorTest extends PHPUnit_Framework_TestCase {

    public function testIdentityLaw() {

	$id = function ($val) { return $val; };
	$eitherVal = new Right("Hello");
	$mappedEitherVal = $eitherVal->fmap($id);

	$this->assertEquals($eitherVal, $mappedEitherVal);
    }

    public function testFmapRight() {

	$toUpper = function ($str) { return strtoupper($str); };
	$eitherStr = new Right("hello");
	$mappedEitherStr = $eitherStr->fmap($toUpper);
	$expectedEitherStr = new Right("HELLO");

	$this->assertEquals($mappedEitherStr, $expectedEitherStr);
    }

    public function testFmapLeft() {

	$toUpper = function ($str) { return strtoupper($str); };
	$eitherStr = new Left("We have a problem!");
	$mappedEitherStr = $eitherStr->fmap($toUpper);

	$this->assertInstanceOf('TMciver\Functional\Either\Left', $mappedEitherStr);
    }
}
