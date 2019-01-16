<?php

namespace PhatCats\Test\Typeclass\Applicative;

use PhatCats\Attempt\AttemptMonad;
use PhatCats\Attempt\Attempt;

class AttemptApplicativeTest extends ApplicativeTest {

  private $applicative;

  protected function setUp() {
    $this->applicative = new AttemptMonad();
  }

  public function getApplicative() {
    return $this->applicative;
  }

  public function testApplicativeForNoArgs() {

    // The function
    $attemptFn = Attempt::fromValue(function() { return 42; });

    // Call the function
    $attemptResult = $this->applicative->apply($attemptFn);

    $expectedResult = Attempt::fromValue(42);

    $this->assertEquals($expectedResult, $attemptResult);
  }

  public function testApplicativeForMultipleArgsNoFailures() {

    // The function
    $attemptFn = Attempt::fromValue('substr');

    // The args
    $attemptStr = Attempt::fromValue('Hello world!');
    $attemptStart = Attempt::fromValue(6);
    $attemptLength = Attempt::fromValue(5);

    // Apply the function applicatively
    $tmp1 = $this->applicative->apply($attemptFn, $attemptStr);
    $tmp2 = $this->applicative->apply($tmp1, $attemptStart);
    $attemptResult = $this->applicative->apply($tmp2, $attemptLength);

    $expectedResult = Attempt::fromValue('world');

    $this->assertEquals($expectedResult, $attemptResult);
  }

  public function testApplicativeForMultipleArgsSomeFailures() {

    // The function
    $attemptFn = Attempt::fromValue('substr');

    // The args
    $attemptStr = Attempt::fromValue('Hello world!');
    $attemptStart = Attempt::failure('I am Error!');
    $attemptLength = Attempt::fromValue(5);

    // Assign the applicative to a variable in order to call it as a function
    // (this is because it's an error to try to call it as
    // $this->applicative(...))
    $ap = $this->applicative;

    // Apply the function applicatively
    $attemptResult = $ap($attemptFn, $attemptStr, $attemptStart, $attemptLength);

    $expectedResult = $attemptStart;

    $this->assertEquals($expectedResult, $attemptResult);
  }

  public function testApplicativeForFailure() {

    // The function
    $attemptFn = Attempt::failure('There is no function!');

    // The args
    $attemptStr = Attempt::fromValue('Hello world!');
    $attemptStart = Attempt::fromValue(6);
    $attemptLength = Attempt::fromValue(5);

    // Assign the applicative to a variable in order to call it as a function
    // (this is because it's an error to try to call it as
    // $this->applicative(...))
    $ap = $this->applicative;

    // Apply the function applicatively
    $attemptResult = $ap($attemptFn, $attemptStr, $attemptStart, $attemptLength);

    $expectedResult = $attemptFn;

    $this->assertEquals($expectedResult, $attemptResult);
  }
}

