<?php

use TMciver\Functional\Just;
use TMciver\Functional\Nothing;

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

	$this->assertInstanceOf('TMciver\Functional\Nothing', $maybeIntPlusOne);
    }
}

function maybeAddOne($i) {
    return new Just($i + 1);
}
