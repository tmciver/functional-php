<?php

use TMciver\Functional\Validation\Validation;
use TMciver\Functional\Maybe\Maybe;

class ValidationApplicativeTest extends PHPUnit_Framework_TestCase {

  public function testApplicativeForNoArgs() {

    // The function
    $maybeFn = Maybe::fromValue(function() { return 42; });

    // Call the function
    $maybeResult = $maybeFn();

    $expectedResult = Maybe::fromValue(42);

    $this->assertEquals($expectedResult, $maybeResult);
  }

  public function testApplyForSuccessSuccess() {

    $validationFunction = Validation::fromValue(addOne);
    $validationArg = Validation::fromValue(1);
    $validationResult = $validationFunction->apply($validationArg);
    $expected = Validation::fromValue(2);

    $this->assertEquals($expected, $validationResult);
  }

  public function testApplyForSuccessFailure() {

    $validationFunction = Validation::fromValue(addOne);
    $validationArg = Validation::failure("I am Error.");
    $validationResult = $validationFunction->apply($validationArg);
    $expected = $validationArg;

    $this->assertEquals($expected, $validationResult);
  }

  public function testApplyForFailureSuccess() {

    $validationFunction = Validation::failure("Error!");
    $validationArg = Validation::fromValue(1);
    
    $validationResult = $validationFunction->apply($validationArg);
    $expected = $validationFunction;

    $this->assertEquals($expected, $validationResult);
  }

  public function testApplyForFailureFailure() {

    $errorMsg1 = "Error!";
    $errorMsg2 = "Another error!";
    $validationFunction = Validation::failure($errorMsg1);
    $validationArg = Validation::failure($errorMsg2);
    
    $validationResult = $validationFunction->apply($validationArg);
    $expected = Validation::failure($errorMsg1 . $errorMsg2);

    $this->assertEquals($expected, $validationResult);
  }
}