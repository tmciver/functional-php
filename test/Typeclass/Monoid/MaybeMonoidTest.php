<?php

namespace PhatCats\Test\Typeclass\Monoid;

use PhatCats\Maybe\MaybeMonoid;
use PhatCats\String\StringMonoid;
use PhatCats\Maybe\Maybe;

class MaybeMonoidTest extends MonoidTest {

  public function setUp() {
    parent::setUp();
  }

  protected function getMonoid() {
    return new MaybeMonoid(new StringMonoid());
  }

  protected function getOne() {
    return Maybe::fromValue(1);
  }

  protected function getTwo() {
    return Maybe::fromValue(2);
  }

  protected function getThree() {
    return Maybe::fromValue(3);
  }

  public function testAppendNothingNothing() {
    $nothing1 = Maybe::nothing();
    $nothing2 = Maybe::nothing();
    $appended = $this->monoid->append($nothing1, $nothing2);

    $this->assertEquals($nothing1, $appended);
  }

  public function testAppendJustJust() {
    $just1 = Maybe::fromValue("hello");
    $just2 = Maybe::fromValue(" world!");
    $appended = $this->monoid->append($just1, $just2);
    $expexted = Maybe::fromValue("hello world!");

    $this->assertEquals($expexted, $appended);
  }
}
