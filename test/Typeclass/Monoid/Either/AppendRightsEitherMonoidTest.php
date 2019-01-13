<?php

namespace TMciver\Functional\Test\Typeclass\Monoid\Either;

use TMciver\Functional\Either\Either;
use TMciver\Functional\Either\Monoid\AppendRightsEitherMonoid;
use TMciver\Functional\String\StringMonoid;
use TMciver\Functional\Int\IntSumMonoid;
use TMciver\Functional\Test\Typeclass\Monoid\MonoidTest;

class AppendRightsEitherMonoidTest extends MonoidTest {

  private $eitherRightsAppendMonoid;

  public function setUp() {
    parent::setUp();

    $this->eitherRightsAppendMonoid = new AppendRightsEitherMonoid(new IntSumMonoid());
  }

  protected function getMonoid() {
    return new AppendRightsEitherMonoid(new StringMonoid());
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
    $appended = $this->eitherRightsAppendMonoid->append($left1, $left2);

    $this->assertEquals($left2, $appended);
  }

  public function testAppendLeftRight() {
    $left = Either::left("hi");
    $right = Either::fromValue(1);
    $appended = $this->eitherRightsAppendMonoid->append($left, $right);

    $this->assertEquals($right, $appended);
  }

  public function testAppendRightRight() {
    $right1 = Either::fromValue(1);
    $right2 = Either::fromValue(2);
    $appended = $this->eitherRightsAppendMonoid->append($right1, $right2);
    $expected = Either::fromValue(3);

    $this->assertEquals($expected, $appended);
  }

  public function testAppendRightLeft() {
    $right = Either::fromValue(0);
    $left = Either::left("hi");
    $appended = $this->eitherRightsAppendMonoid->append($right, $left);

    $this->assertEquals($right, $appended);
  }
}
