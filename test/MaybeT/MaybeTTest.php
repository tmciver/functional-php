<?php

use PHPUnit\Framework\TestCase;
use TMciver\Functional\Maybe\Maybe;
use TMciver\Functional\Maybe\MaybeT;
use TMciver\Functional\Either\Either;

class MaybeTTest extends TestCase {

    private $maybeT; // used to create MaybeT's using 'pure'

    public function setUp() {
        $this->maybeT = new MaybeT(Either::left(''));
    }

    public function testMap() {

	// create a MaybeT that represents an `Either Maybe`
        $mt = $this->maybeT->pure("Hello");
	$newMt = $mt->map('strtolower');
	$expectedMt = new MaybeT(Either::fromValue(Maybe::fromValue("hello")));

	$this->assertEquals($newMt, $expectedMt);
    }

    public function testFlatMapForRightJust1() {

	// create a MaybeT that represents an `Either Maybe`
        $mt = $this->maybeT->pure("Hello");
	$expectedMt = new MaybeT(Either::fromValue(Maybe::fromValue("H")));

	$newMt = $mt->flatMap('firstLetter');

	$this->assertEquals($newMt, $expectedMt);
    }

    public function testFlatMapForRightJust2() {

	// create a MaybeT that represents an `Either Maybe`
        $mt = $this->maybeT->pure("");
	$expectedMt = new MaybeT(Either::fromValue(Maybe::nothing()));

	$newMt = $mt->flatMap('firstLetter');

	$this->assertEquals($newMt, $expectedMt);
    }

    public function testFlatMapForRightNothing() {

	// create a MaybeT that represents an `Either Maybe`
	$mt = new MaybeT(Either::fromValue(Maybe::nothing()));

	$newMt = $mt->flatMap('firstLetter');

	$this->assertEquals($newMt, $mt);
    }

    public function testFlatMapForLeft() {

	// create a MaybeT that represents an `Either Maybe`
	$mt = new MaybeT(Either::left("I am Error!"));

	$newMt = $mt->flatMap('firstLetter');

	$this->assertEquals($newMt, $mt);
    }

    public function testPure() {

	// create a MaybeT that represents an `Either Maybe`
	$mt = new MaybeT(Either::left("I am Error."));

	// create a pure value
	$newMt = $mt->pure("Hello!");

	$expectedMt = new MaybeT(Either::fromValue(Maybe::fromValue("Hello!")));

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
	    $maybeLetter = Maybe::nothing();
	} else {
	    $maybeLetter = Maybe::fromValue(substr($str, 0, 1));
	}
	$either = Either::fromValue($maybeLetter);
    } else {
	$either = Either::left("Argument to 'firstLetter' not a string.");
    }

    return new MaybeT($either);
}

