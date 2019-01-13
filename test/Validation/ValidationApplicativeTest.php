<?php

use PHPUnit\Framework\TestCase;
use TMciver\Functional\Validation\Validation;
use TMciver\Functional\String\StringMonoid;

class ValidationApplicativeTest extends TestCase {

  private $innerSemigroup;

  protected function setUp() {
    $this->innerSemigroup = new StringMonoid();
  }

  public function testApplicativeForNoArgs() {

    // The function
    $validationFn = Validation::fromValue(function() { return 42; });

    // Call the function
    $validationResult = $validationFn->apply(null, $this->innerSemigroup);

    $expectedResult = Validation::fromValue(42);

    $this->assertEquals($expectedResult, $validationResult);
  }

  public function testApplyForSuccessSuccess() {

    $validationFunction = Validation::fromValue('addOne');
    $validationArg = Validation::fromValue(1);
    $validationResult = $validationFunction->apply($validationArg, $this->innerSemigroup);
    $expected = Validation::fromValue(2);

    $this->assertEquals($expected, $validationResult);
  }

  public function testApplyForSuccessFailure() {

    $validationFunction = Validation::fromValue('addOne');
    $validationArg = Validation::failure("I am Error.");
    $validationResult = $validationFunction->apply($validationArg, $this->innerSemigroup);
    $expected = $validationArg;

    $this->assertEquals($expected, $validationResult);
  }

  public function testApplyForFailureSuccess() {

    $validationFunction = Validation::failure("Error!");
    $validationArg = Validation::fromValue(1);
    
    $validationResult = $validationFunction->apply($validationArg, $this->innerSemigroup);
    $expected = $validationFunction;

    $this->assertEquals($expected, $validationResult);
  }

  // public function testApplyForFailureFailure() {

  //   $errorMsg1 = "Error!";
  //   $errorMsg2 = "Another error!";
  //   $validationFunction = Validation::failure($errorMsg1);
  //   $validationArg = Validation::failure($errorMsg2);
    
  //   $validationResult = $validationFunction->apply($validationArg);
  //   $expected = Validation::failure($errorMsg1 . $errorMsg2);

  //   $this->assertEquals($expected, $validationResult);
  // }
}
