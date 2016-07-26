<?php

use TMciver\Functional\Maybe\Maybe;

class MaybeFunctorTest extends PHPUnit_Framework_TestCase {

    public function testMapForJust() {

	$maybeInt = Maybe::fromValue(1);
	$maybeIntPlusOne = $maybeInt->map(function ($i) {
	    return addOne($i);
	});

	$this->assertEquals($maybeIntPlusOne->get(), 2);
    }

    public function testMapForNothing() {

	$maybeInt = Maybe::nothing();
	$maybeIntPlusOne = $maybeInt->map(function ($i) {
	    return addOne($i);
	});

	$this->assertInstanceOf('TMciver\Functional\Maybe\Nothing', $maybeIntPlusOne);
    }

    public function testMapExceptionHandling() {

	$maybeInt = Maybe::fromValue(1);
	$maybeIntPlusOne = $maybeInt->map(function ($i) {
	    return throwException($i);
	});

	$this->assertInstanceOf('TMciver\Functional\Maybe\Nothing', $maybeIntPlusOne);
    }

    public function testMapNullHandling() {

	$maybeInt = Maybe::fromValue(1);
	$maybeIntPlusOne = $maybeInt->map(function ($i) {
	    return returnNull($i);
	});

	$this->assertInstanceOf('TMciver\Functional\Maybe\Nothing', $maybeIntPlusOne);
    }
}

function addOne($i) {
    return $i + 1;
}

function throwException($i) {
    throw new \Exception("I'm totally freaking out!'");
}

function returnNull($i) {
    return null;
}
