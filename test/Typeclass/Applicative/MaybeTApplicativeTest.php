<?php

namespace PhatCats\Test\Typeclass\Applicative;

use PhatCats\Maybe\MaybeTMonad;
use PhatCats\Either\Monad\RightFavoringEitherMonad;

class MaybeTApplicativeTest extends ApplicativeTest {

  private $maybeTMonad;

  public function setUp() {
    $this->maybeTMonad = new MaybeTMonad(new RightFavoringEitherMonad());
  }

  public function getApplicative() {
    return $this->maybeTMonad;
  }

  public function testApplicativeForNoArgs() {
    $maybetFn = $this->maybeTMonad->pure(function() { return 42; });
    $maybetResult = $this->maybeTMonad->apply($maybetFn);
    $expectedResult = $this->maybeTMonad->pure(42);

    $this->assertEquals($expectedResult, $maybetResult);
  }

  // TODO fix
  // public function testApplicativeForMultipleArgsNoNothings() {
  //   $maybetFn = $this->maybeTMonad->pure('substr');
  //   $maybetStr = $this->maybeTMonad->pure('Hello world!');
  //   $maybetStart = $this->maybeTMonad->pure(6);
  //   $maybetLength = $this->maybeTMonad->pure(5);

  //   // Apply the function applicatively
  //   $maybetResult = $maybetFn($maybetStr, $maybetStart, $maybetLength);

  //   $expectedResult = $this->maybet->pure('world');

  //   $this->assertEquals($expectedResult, $maybetResult);
  // }

  // public function testApplicativeForMultipleArgsSomeNothings() {

  //   // The function
  //   $maybetFn = $this->maybet->pure('substr');

  //   // The args
  //   $maybetStr = $this->maybet->pure('Hello world!');
  //   $maybetStart = $this->maybet->pure(null); 
  //   $maybetLength = $this->maybet->pure(5);

  //   // Apply the function applicatively
  //   $maybetResult = $maybetFn($maybetStr, $maybetStart, $maybetLength);

  //   $expectedResult = $maybetStart;

  //   $this->assertEquals($expectedResult, $maybetResult);
  // }

  // public function testApplicativeForNothing() {

  //   // The function
  //   $maybetFn = $this->maybet->pure(null); 

  //   // The args
  //   $maybetStr = $this->maybet->pure('Hello world!');
  //   $maybetStart = $this->maybet->pure(6);
  //   $maybetLength = $this->maybet->pure(5);

  //   // Apply the function applicatively
  //   $maybetResult = $maybetFn($maybetStr, $maybetStart, $maybetLength);

  //   $expectedResult = $maybetFn;

  //   $this->assertEquals($expectedResult, $maybetResult);
  // }
}

