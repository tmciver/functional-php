<?php

use TMciver\Functional\Validation\Validation;
use TMciver\Functional\Maybe\Maybe;

class ValidationSemiGroupTest extends PHPUnit_Framework_TestCase {

  public function testAppendForSuccessSuccess() {

    $success5 = Validation::fromValue(5);
    $success6 = Validation::fromValue(6);
    $appended = $success5->append($success6);
    $expected = Validation::fromValue(5);

    $this->assertEquals($expected, $appended);
  }

  public function testAppendForSuccessFailure() {

    $success = Validation::fromValue(5);
    $failure = Validation::failure("hi");
    $appended = $success->append($failure);
    $expected = $success;

    $this->assertEquals($appended, $expected);
  }

  public function testAppendForFailureSuccess() {

    $success = Validation::fromValue(5);
    $failure = Validation::failure("hi");
    $appended = $failure->append($success);
    $expected = $success;

    $this->assertEquals($appended, $expected);
  }

  public function testAppendForFailureFailureOfString() {

    $failure1 = Validation::failure("hi");
    $failure2 = Validation::failure(" there");
    $appended = $failure1->append($failure2);
    $expected = Validation::failure("hi there");

    $this->assertEquals($appended, $expected);
  }

  public function testAppendForFailureFailureOfInts() {

    $failure1 = Validation::failure(1);
    $failure2 = Validation::failure(2);
    $appended = $failure1->append($failure2);
    $expected = Validation::failure([1, 2]);

    $this->assertEquals($appended, $expected);
  }

  public function testAppendForFailureFailureOfMonoid() {

    $failure1 = Validation::failure(Maybe::fromValue(1));
    $failure2 = Validation::failure(Maybe::fromValue(2));
    $appended = $failure1->append($failure2);
    $expected = Validation::failure(Maybe::fromValue([1, 2]));

    $this->assertEquals($appended, $expected);
  }

  public function testAssociativity() {

    // we'll combine four values in two different ways and make sure the
    // results are the same.
    $success1 = Validation::fromValue(1);
    $success2 = Validation::fromValue(2);
    $success3 = Validation::fromValue(3);

    // First, combine the first two, then that result with the third one
    $firstTwo = $success1->append($success2);
    $result1 = $firstTwo->append($success3);

    // Next, combine the first one with the result of combining the last two.
    $lastTwo = $success2->append($success3);
    $result2 = $success1->append($lastTwo);

    $this->assertEquals($result1, $result2);
  }
}