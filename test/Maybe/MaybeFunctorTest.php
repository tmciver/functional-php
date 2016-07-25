<?php

use TMciver\Functional\Maybe\Just;
use TMciver\Functional\Maybe\Nothing;

class MaybeFunctorTest extends PHPUnit_Framework_TestCase {

    public function testMapForJust() {

	$maybeInt = new Just(1);
	$maybeIntPlusOne = $maybeInt->map(function ($i) {
	    return addOne($i);
	});

	$this->assertEquals($maybeIntPlusOne->get(), 2);
    }

    public function testMapForNothing() {

	$maybeInt = new Nothing();
	$maybeIntPlusOne = $maybeInt->map(function ($i) {
	    return addOne($i);
	});

	$this->assertInstanceOf('TMciver\Functional\Maybe\Nothing', $maybeIntPlusOne);
    }

    public function testMapExceptionHandling() {

	$maybeInt = new Just(1);
	$maybeIntPlusOne = $maybeInt->map(function ($i) {
	    return throwException($i);
	});

	$this->assertInstanceOf('TMciver\Functional\Maybe\Nothing', $maybeIntPlusOne);
    }

    public function testMapNullHandling() {

	$maybeInt = new Just(1);
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
