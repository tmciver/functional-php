<?php

use TMciver\Functional\Maybe\Just;
use TMciver\Functional\Maybe\Nothing;

class MaybeFunctorTest extends PHPUnit_Framework_TestCase {

    public function testFmapForJust() {

	$maybeInt = new Just(1);
	$maybeIntPlusOne = $maybeInt->fmap(function ($i) {
	    return addOne($i);
	});

	$this->assertEquals($maybeIntPlusOne->get(), 2);
    }

    public function testFmapForNothing() {

	$maybeInt = new Nothing();
	$maybeIntPlusOne = $maybeInt->fmap(function ($i) {
	    return addOne($i);
	});

	$this->assertInstanceOf('TMciver\Functional\Maybe\Nothing', $maybeIntPlusOne);
    }

    public function testFmapExceptionHandling() {

	$maybeInt = new Just(1);
	$maybeIntPlusOne = $maybeInt->fmap(function ($i) {
	    return throwException($i);
	});

	$this->assertInstanceOf('TMciver\Functional\Maybe\Nothing', $maybeIntPlusOne);
    }

    public function testFmapNullHandling() {

	$maybeInt = new Just(1);
	$maybeIntPlusOne = $maybeInt->fmap(function ($i) {
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
