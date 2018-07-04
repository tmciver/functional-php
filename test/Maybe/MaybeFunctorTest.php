<?php

use PHPUnit\Framework\TestCase;
use TMciver\Functional\Maybe\Maybe;

require_once __DIR__ . '/../util.php';

class MaybeFunctorTest extends TestCase {

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
