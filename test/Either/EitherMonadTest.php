<?php

use TMciver\Functional\Either\Either;

class EitherMonadTest extends PHPUnit_Framework_TestCase {

    public function testPure() {

	// using `pure` in this lib requres having a reference to an object of
	// the desired type, so here, we'll just create a Left Either.
	$either = Either::left('');

	// create a wrapped val
	$wrappedVal = $either->pure("Hello!");

	$this->assertInstanceOf('TMciver\Functional\Either\Right', $wrappedVal);
	$this->assertEquals($wrappedVal->get(), "Hello!");
    }

    public function testConcatMapForRight() {

	$eitherInt = Either::fromValue(1);
	$eitherIntPlusOne = $eitherInt->concatMap(function ($i) {
	    return Either::fromValue($i + 1);
	});

	$this->assertEquals($eitherIntPlusOne->get(), 2);
    }

    public function testConcatMapForLeft() {

	$eitherInt = Either::left("Error!");
	$eitherIntPlusOne = $eitherInt->concatMap(function ($i) {
	    return Either::fromValue($i + 1);
	});

	$this->assertInstanceOf('TMciver\Functional\Either\Left', $eitherIntPlusOne);
    }
}
