<?php

use TMciver\Functional\Maybe\MaybeT;
use TMciver\Functional\Maybe\Just;
use TMciver\Functional\Maybe\Nothing;
use TMciver\Functional\Either\Right;
use TMciver\Functional\Either\Left;

class MaybeTTest extends PHPUnit_Framework_TestCase {

    public function testFmap() {

	// create a MaybeT that represents an `Either Maybe`
	$mt = new MaybeT(new Right(new Just("Hello")));
	$newMt = $mt->fmap('strtolower');
	$expectedMt = new MaybeT(new Right(new Just("hello")));

	$this->assertEquals($newMt, $expectedMt);
    }

    public function testBindForRightJust1() {

	// create a MaybeT that represents an `Either Maybe`
	$mt = new MaybeT(new Right(new Just("Hello")));
	$expectedMt = new MaybeT(new Right(new Just("H")));

	$newMt = $mt->bind('firstLetter');

	$this->assertEquals($newMt, $expectedMt);
    }

    public function testBindForRightJust2() {

	// create a MaybeT that represents an `Either Maybe`
	$mt = new MaybeT(new Right(new Just("")));
	$expectedMt = new MaybeT(new Right(new Nothing()));

	$newMt = $mt->bind('firstLetter');

	$this->assertEquals($newMt, $expectedMt);
    }

    public function testBindForRightNothing() {

	// create a MaybeT that represents an `Either Maybe`
	$mt = new MaybeT(new Right(new Nothing()));

	$newMt = $mt->bind('firstLetter');

	$this->assertEquals($newMt, $mt);
    }

    public function testBindForLeft() {

	// create a MaybeT that represents an `Either Maybe`
	$mt = new MaybeT(new Left("I am Error!"));

	$newMt = $mt->bind('firstLetter');

	$this->assertEquals($newMt, $mt);
    }

    public function testPure() {

	// create a MaybeT that represents an `Either Maybe`
	$mt = new MaybeT(new Left("I am Error."));

	// create a pure value
	$newMt = $mt->pure("Hello!");

	$expectedMt = new MaybeT(new Right(new Just("Hello!")));

	$this->assertEquals($newMt, $expectedMt);
    }
}

/**
 * @param $str Some string. Can be empty.
 * @return an instance MaybeT (Either Maybe)
 */
function firstLetter($str) {
    if (is_string($str)) {
	if (empty($str)) {
	    $maybeLetter = new Nothing();
	} else {
	    $maybeLetter = new Just(substr($str, 0, 1));
	}
	$either = new Right($maybeLetter);
    } else {
	$either = new Left("Argument to 'firstLetter' not a string.");
    }

    return new MaybeT($either);
}

