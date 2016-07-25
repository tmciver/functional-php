<?php

use TMciver\Functional\Either\Left;
use TMciver\Functional\Either\Right;

class EitherMonadTest extends PHPUnit_Framework_TestCase {

    public function testPure() {

	// using `pure` in this lib requres having a reference to an object of
	// the desired type, so here, we'll just create a Left Either.
	$either = new Left('');

	// create a wrapped val
	$wrappedVal = $either->pure("Hello!");

	$this->assertInstanceOf('TMciver\Functional\Either\Right', $wrappedVal);
	$this->assertEquals($wrappedVal->get(), "Hello!");
    }

    public function testConcatMapForRight() {

	$eitherInt = new Right(1);
	$eitherIntPlusOne = $eitherInt->concatMap(function ($i) {
	    return new Right($i + 1);
	});

	$this->assertEquals($eitherIntPlusOne->get(), 2);
    }

    public function testConcatMapForLeft() {

	$eitherInt = new Left("Error!");
	$eitherIntPlusOne = $eitherInt->concatMap(function ($i) {
	    return new Right($i + 1);
	});

	$this->assertInstanceOf('TMciver\Functional\Either\Left', $eitherIntPlusOne);
    }
}
