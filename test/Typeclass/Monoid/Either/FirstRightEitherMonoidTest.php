<?php

namespace PhatCats\Test\Typeclass\Monoid\Either;

use PhatCats\Either\Either;
use PhatCats\Either\Monoid\FirstRightEitherMonoid;
use PhatCats\String\StringMonoid;
use PhatCats\Test\Typeclass\Monoid\MonoidTest;

class FirstRightEitherMonoidTest extends MonoidTest {

  public function setUp() {
    parent::setUp();
  }

  protected function getMonoid() {
    return new FirstRightEitherMonoid(new StringMonoid());
  }

  protected function getOne() {
    return Either::fromValue("Hey");
  }

  protected function getTwo() {
    return Either::fromValue(" you");
  }

  protected function getThree() {
    return Either::fromValue(" guys!");
  }

  public function testAppendLeftLeft() {
    $left1 = Either::left("hi");
    $left2 = Either::left("bye");
    $appended = $this->monoid->append($left1, $left2);

    $this->assertEquals($left2, $appended);
  }

  public function testAppendLeftRight() {
    $left = Either::left("hi");
    $right = Either::fromValue(1);
    $appended = $this->monoid->append($left, $right);

    $this->assertEquals($right, $appended);
  }

  public function testAppendRightRight() {
    $right1 = Either::fromValue(0);
    $right2 = Either::fromValue(1);
    $appended = $this->monoid->append($right1, $right2);

    $this->assertEquals($right1, $appended);
  }

  public function testAppendRightLeft() {
    $right = Either::fromValue(0);
    $left = Either::left("hi");
    $appended = $this->monoid->append($right, $left);

    $this->assertEquals($right, $appended);
  }
}
