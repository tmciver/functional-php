<?php

use TMciver\Functional\Maybe\Just;
use TMciver\Functional\Maybe\Nothing;

class MaybeMonadTest extends PHPUnit_Framework_TestCase {

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
