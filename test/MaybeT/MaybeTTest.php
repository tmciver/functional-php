<?php

use PHPUnit\Framework\TestCase;
use PhatCats\Maybe\Maybe;
use PhatCats\Either\Either;
use PhatCats\Maybe\MaybeT;
use PhatCats\Maybe\MaybeTMonad;
use PhatCats\Either\Monad\RightFavoringEitherMonad;

class MaybeTTest extends TestCase {

  private $maybeTMonad;
  private $wrapperMonad;

  public function setUp() {
    $this->wrapperMonad = new RightFavoringEitherMonad();
    $this->maybeTMonad = new MaybeTMonad($this->wrapperMonad);
  }

  public function testMap() {
    $mt = $this->maybeTMonad->pure("Hello");
	$newMt = $mt->map('strtolower');
    $expectedMt = $this->maybeTMonad->pure("hello");

	$this->assertEquals($newMt, $expectedMt);
  }

  public function testFlatMapForRightJust1() {
    $mt = $this->maybeTMonad->pure("Hello");
	$newMt = $mt->flatMap($this->wrapperMonad, 'firstLetter');
    $expectedMt = $this->maybeTMonad->pure("H");

	$this->assertEquals($newMt, $expectedMt);
  }

  public function testFlatMapForRightJust2() {
    $mt = $this->maybeTMonad->pure("");
	$expectedMt = new MaybeT(Either::fromValue(Maybe::nothing()));
	$newMt = $mt->flatMap($this->wrapperMonad, 'firstLetter');

	$this->assertEquals($newMt, $expectedMt);
  }

  public function testFlatMapForRightNothing() {
	$mt = new MaybeT(Either::fromValue(Maybe::nothing()));
	$newMt = $mt->flatMap($this->wrapperMonad, 'firstLetter');

	$this->assertEquals($newMt, $mt);
  }

  public function testFlatMapForLeft() {
	$mt = new MaybeT(Either::left("I am Error!"));
	$newMt = $mt->flatMap($this->wrapperMonad, 'firstLetter');

	$this->assertEquals($newMt, $mt);
  }

  public function testPure() {
	$mt = new MaybeT($this->wrapperMonad);
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

