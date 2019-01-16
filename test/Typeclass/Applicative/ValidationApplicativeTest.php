<?php

namespace PhatCats\Test\Typeclass\Applicative;

use PhatCats\Validation\ValidationApplicative;
use PhatCats\Validation\Validation;
use PhatCats\String\StringMonoid;

class ValidationApplicativeTest extends ApplicativeTest {

  private $applicative;

  protected function setUp() {
    $this->applicative = new ValidationApplicative(new StringMonoid());
  }

  public function getApplicative() {
    return $this->applicative;
  }

  public function testApplicativeForMultipleArgsNoFailures() {

    // The function
    $validationFn = Validation::fromValue('substr');

    // The args
    $validationStr = Validation::fromValue('Hello world!');
    $validationStart = Validation::fromValue(6);
    $validationLength = Validation::fromValue(5);

    // Apply the function applicatively
    $tmp1 = $this->applicative->apply($validationFn, $validationStr);
    $tmp2 = $this->applicative->apply($tmp1, $validationStart);
    $validationResult = $this->applicative->apply($tmp2, $validationLength);

    $expectedResult = Validation::fromValue('world');

    $this->assertEquals($expectedResult, $validationResult);
  }

  public function testApplicativeForMultipleArgsSomeFailures() {

    // The function
    $validationFn = Validation::fromValue('substr');

    // The args
    $validationStr = Validation::fromValue('Hello world!');
    $validationStart = Validation::failure('I am Error!');
    $validationLength = Validation::failure('I am another Error!');

    // Assign the applicative to a variable in order to call it as a function
    // (this is because it's an error to try to call it as
    // $this->applicative(...))
    $ap = $this->applicative;

    // Apply the function applicatively
    //$validationResult = $ap($validationFn, $validationStr, $validationStart, $validationLength);
    $tmp1 = $this->applicative->apply($validationFn, $validationStr);
    $tmp2 = $this->applicative->apply($tmp1, $validationStart);
    $validationResult = $this->applicative->apply($tmp2, $validationLength);

    $expectedResult = Validation::failure('I am Error!I am another Error!');

    $this->assertEquals($expectedResult, $validationResult);
  }
}

