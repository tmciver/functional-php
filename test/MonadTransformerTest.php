<?php

use TMciver\Functional\MonadTransformer;
use TMciver\Functional\Maybe\Just;
use TMciver\Functional\Maybe\Nothing;
use TMciver\Functional\Either\Right;
use TMciver\Functional\Either\Left;

class MonadTransformerTest extends PHPUnit_Framework_TestCase {

    public function testBindForRightJust1() {

	// create a MonadTransformer that represents an `Either Maybe`
	$mt = new MonadTransformer(new Right(new Just("Hello")));
	$expectedMt = new MonadTransformer(new Right(new Just("H")));

	$newMt = $mt->bind('firstLetter');

	$this->assertEquals($newMt, $expectedMt);
    }

    public function testBindForRightJust2() {

	// create a MonadTransformer that represents an `Either Maybe`
	$mt = new MonadTransformer(new Right(new Just("")));
	$expectedMt = new MonadTransformer(new Right(new Nothing()));

	$newMt = $mt->bind('firstLetter');

	$this->assertEquals($newMt, $expectedMt);
    }

    public function testBindForRightNothing() {

	// create a MonadTransformer that represents an `Either Maybe`
	$mt = new MonadTransformer(new Right(new Nothing()));

	$newMt = $mt->bind('firstLetter');

	$this->assertEquals($newMt, $mt);
    }

    public function testBindForLeft() {

	// create a MonadTransformer that represents an `Either Maybe`
	$mt = new MonadTransformer(new Left("I am Error!"));

	$newMt = $mt->bind('firstLetter');

	$this->assertEquals($newMt, $mt);
    }
}

function firstLetter($str) {
    if (empty($str)) {
	return new Nothing();
    } else {
	return new Just(substr($str, 0, 1));
    }
}

