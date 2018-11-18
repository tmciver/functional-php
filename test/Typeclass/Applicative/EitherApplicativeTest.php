<?php

namespace TMciver\Functional\Test\Typeclass\Applicative;

use TMciver\Functional\Either\Monad\RightFavoringEitherMonad;
use TMciver\Functional\Either\Either;

class EitherApplicativeTest extends ApplicativeTest {

  private $applicative;

  protected function setUp() {
    $this->applicative = new RightFavoringEitherMonad();
  }

  public function getApplicative() {
    return $this->applicative;
  }

  public function testApplicativeForNoArgs() {

    // The function
    $eitherFn = Either::fromValue(function() { return 42; });

    // Call the function
    $eitherResult = $this->applicative->apply($eitherFn);

    $expectedResult = Either::fromValue(42);

    $this->assertEquals($expectedResult, $eitherResult);
  }

  public function testApplicativeForMultipleArgsNoLefts() {

    // The function
    $eitherFn = Either::fromValue('substr');

    // The args
    $eitherStr = Either::fromValue('Hello world!');
    $eitherStart = Either::fromValue(6);
    $eitherLength = Either::fromValue(5);

    // Apply the function applicatively
    $tmp1 = $this->applicative->apply($eitherFn, $eitherStr);
    $tmp2 = $this->applicative->apply($tmp1, $eitherStart);
    $eitherResult = $this->applicative->apply($tmp2, $eitherLength);

    $expectedResult = Either::fromValue('world');

    $this->assertEquals($expectedResult, $eitherResult);
  }

  // public function testApplicativeForMultipleArgsSomeLefts() {

  //   // The function
  //   $eitherFn = Either::fromValue('substr');

  //   // The args
  //   $eitherStr = Either::fromValue('Hello world!');
  //   $eitherStart = Either::left('I am Error!');
  //   $eitherLength = Either::fromValue(5);

  //   // Apply the function applicatively
  //   $eitherResult = $this->applicative->apply($eitherFn, $eitherStr, $eitherStart, $eitherLength);

  //   $expectedResult = $eitherStart;

  //   $this->assertEquals($expectedResult, $eitherResult);
  // }

  // public function testApplicativeForLeft() {

  //   // The function
  //   $eitherFn = Either::left('There is no function!');

  //   // The args
  //   $eitherStr = Either::fromValue('Hello world!');
  //   $eitherStart = Either::fromValue(6);
  //   $eitherLength = Either::fromValue(5);

  //   // Apply the function applicatively
  //   $eitherResult = $this->applicative->apply($eitherFn, $eitherStr, $eitherStart, $eitherLength);

  //   $expectedResult = $eitherFn;

  //   $this->assertEquals($expectedResult, $eitherResult);
  // }
}

