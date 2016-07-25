<?php

use TMciver\Functional\Maybe\MaybeT;
use TMciver\Functional\Maybe\Just;
use TMciver\Functional\Maybe\Nothing;
use TMciver\Functional\Either\Right;
use TMciver\Functional\Either\Left;

class MaybeTTest extends PHPUnit_Framework_TestCase {

    private $maybeT; // used to create MaybeT's using 'pure'

    public function __construct() {
        $this->maybeT = new MaybeT(new Left(''));
    }

    public function testMap() {

	// create a MaybeT that represents an `Either Maybe`
        $mt = $this->maybeT->pure("Hello");
	$newMt = $mt->map('strtolower');
	$expectedMt = new MaybeT(new Right(new Just("hello")));

	$this->assertEquals($newMt, $expectedMt);
    }

    public function testConcatMapForRightJust1() {

	// create a MaybeT that represents an `Either Maybe`
        $mt = $this->maybeT->pure("Hello");
	$expectedMt = new MaybeT(new Right(new Just("H")));

	$newMt = $mt->concatMap('firstLetter');

	$this->assertEquals($newMt, $expectedMt);
    }

    public function testConcatMapForRightJust2() {

	// create a MaybeT that represents an `Either Maybe`
        $mt = $this->maybeT->pure("");
	$expectedMt = new MaybeT(new Right(new Nothing()));

	$newMt = $mt->concatMap('firstLetter');

	$this->assertEquals($newMt, $expectedMt);
    }

    public function testConcatMapForRightNothing() {

	// create a MaybeT that represents an `Either Maybe`
	$mt = new MaybeT(new Right(new Nothing()));

	$newMt = $mt->concatMap('firstLetter');

	$this->assertEquals($newMt, $mt);
    }

    public function testConcatMapForLeft() {

	// create a MaybeT that represents an `Either Maybe`
	$mt = new MaybeT(new Left("I am Error!"));

	$newMt = $mt->concatMap('firstLetter');

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

