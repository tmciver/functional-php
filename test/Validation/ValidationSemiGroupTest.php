<?php

use PHPUnit\Framework\TestCase;
use PhatCats\Validation\Validation;
use PhatCats\Maybe\Maybe;
use PhatCats\Maybe\MaybeMonoid;
use PhatCats\Int\IntSumMonoid;
use PhatCats\Int\IntProductMonoid;
use PhatCats\String\StringMonoid;

class ValidationSemiGroupTest extends TestCase {

  private $innerSemigroup;

  protected function setUp() {
    $this->innerSemigroup = new StringMonoid();
  }

  public function testAppendForSuccessSuccess() {

    $success5 = Validation::fromValue(5);
    $success6 = Validation::fromValue(6);
    $appended = $success5->append($success6, $this->innerSemigroup);
    $expected = Validation::fromValue(5);

    $this->assertEquals($expected, $appended);
  }

  public function testAppendForSuccessFailure() {

    $success = Validation::fromValue(5);
    $failure = Validation::failure("hi");
    $appended = $success->append($failure, $this->innerSemigroup);
    $expected = $success;

    $this->assertEquals($appended, $expected);
  }

  public function testAppendForFailureSuccess() {
    $monoid = new StringMonoid();
    $success = Validation::fromValue(5);
    $failure = Validation::failure("hi");
    $appended = $failure->append($success, $monoid);
    $expected = $success;

    $this->assertEquals($appended, $expected);
  }

  public function testAppendForFailureFailureOfString() {
    $monoid = new StringMonoid();
    $failure1 = Validation::failure("hi");
    $failure2 = Validation::failure(" there");
    $appended = $failure1->append($failure2, $monoid);
    $expected = Validation::failure("hi there");

    $this->assertEquals($appended, $expected);
  }

  public function testAppendForFailureFailureOfInts() {
    $monoid = new IntProductMonoid();
    $failure1 = Validation::failure(1);
    $failure2 = Validation::failure(2);
    $appended = $failure1->append($failure2, $monoid);
    $expected = Validation::failure(2);

    $this->assertEquals($appended, $expected);
  }

  public function testAppendForFailureFailureOfMonoid() {
    $innerMonoid = new MaybeMonoid(new IntSumMonoid());
    $failure1 = Validation::failure(Maybe::fromValue(1));
    $failure2 = Validation::failure(Maybe::fromValue(2));
    $appended = $failure1->append($failure2, $innerMonoid);
    $expected = Validation::failure(Maybe::fromValue(3));

    $this->assertEquals($appended, $expected);
  }

  public function testAssociativity() {

    // we'll combine four values in two different ways and make sure the
    // results are the same.
    $success1 = Validation::fromValue(1);
    $success2 = Validation::fromValue(2);
    $success3 = Validation::fromValue(3);

    // First, combine the first two, then that result with the third one
    $firstTwo = $success1->append($success2, $this->innerSemigroup);
    $result1 = $firstTwo->append($success3, $this->innerSemigroup);

    // Next, combine the first one with the result of combining the last two.
    $lastTwo = $success2->append($success3, $this->innerSemigroup);
    $result2 = $success1->append($lastTwo, $this->innerSemigroup);

    $this->assertEquals($result1, $result2);
  }
}
