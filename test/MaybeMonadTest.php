<?php

use TMciver\Functional\Maybe\Just;
use TMciver\Functional\Maybe\Nothing;

class MaybeMonadTest extends PHPUnit_Framework_TestCase {

    public function testPure() {

	// using `pure` in this lib requres having a reference to an object of
	// the desired type, so here, we'll just create a Nothing Maybe.
	$maybe = new Nothing();

	// create a wrapped val
	$wrappedVal = $maybe->pure("Hello!");

	$this->assertInstanceOf('TMciver\Functional\Maybe\Just', $wrappedVal);
	$this->assertEquals($wrappedVal->get(), "Hello!");
    }

    public function testBindForJust() {

	$maybeInt = new Just(1);
	$maybeIntPlusOne = $maybeInt->bind(function ($i) {
	    return maybeAddOne($i);
	});

	$this->assertEquals($maybeIntPlusOne->get(), 2);
    }

    public function testBindForNothing() {

	$maybeInt = new Nothing();
	$maybeIntPlusOne = $maybeInt->bind(function ($i) {
	    return maybeAddOne($i);
	});

	$this->assertInstanceOf('TMciver\Functional\Maybe\Nothing', $maybeIntPlusOne);
    }
}

function maybeAddOne($i) {
    return new Just($i + 1);
}
