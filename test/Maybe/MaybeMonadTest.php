<?php

use PHPUnit\Framework\TestCase;
use TMciver\Functional\Maybe\Maybe;

class MaybeMonadTest extends TestCase {

    public function testPure() {

	// using `pure` in this lib requres having a reference to an object of
	// the desired type, so here, we'll just create a Nothing Maybe.
	$maybe = Maybe::nothing();

	// create a wrapped val
	$wrappedVal = $maybe->pure("Hello!");

	$this->assertInstanceOf('TMciver\Functional\Maybe\Just', $wrappedVal);
	$this->assertEquals($wrappedVal->get(), "Hello!");
    }

    public function testFlatMapForJust() {

	$maybeInt = Maybe::fromValue(1);
        $maybeIntPlusOne = $maybeInt->flatMap('maybeAddOne');

	$this->assertEquals($maybeIntPlusOne->get(), 2);
    }

    public function testFlatMapForNothing() {

	$maybeInt = Maybe::nothing();
	$maybeIntPlusOne = $maybeInt->flatMap('maybeAddOne');

	$this->assertInstanceOf('TMciver\Functional\Maybe\Nothing', $maybeIntPlusOne);
    }
}

function maybeAddOne($i) {
    return Maybe::fromValue($i + 1);
}
