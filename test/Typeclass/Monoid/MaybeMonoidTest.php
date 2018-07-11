<?php

namespace TMciver\Functional\Test\Typeclass\Monoid;

use TMciver\Functional\Maybe\MaybeMonoid;
use TMciver\Functional\Maybe\Maybe;

class MaybeMonoidTest extends MonoidTest {

  public function setUp() {
    parent::setUp();
  }

  protected function getMonoid() {
    return new MaybeMonoid();
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

}
