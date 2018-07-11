<?php

namespace TMciver\Functional\Test\Typeclass\Monoid;

use TMciver\Functional\String\StringMonoid;

class StringMonoidTest extends MonoidTest {

  public function setUp() {
    parent::setUp();
  }

  protected function getMonoid() {
    return new StringMonoid();
  }

  protected function getOne() {
    return "Hello";
  }

  protected function getTwo() {
    return "world!";
  }

  protected function getThree() {
    return "foo";
  }

}
