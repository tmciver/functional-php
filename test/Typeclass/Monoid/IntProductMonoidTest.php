<?php

namespace TMciver\Functional\Test\Typeclass\Monoid;

use TMciver\Functional\Int\IntProductMonoid;

class IntProductMonoidTest extends MonoidTest {

  public function setUp() {
    parent::setUp();
  }

  protected function getMonoid() {
    return new IntProductMonoid();
  }

  protected function getOne() {
    return 1;
  }

  protected function getTwo() {
    return 42;
  }

  protected function getThree() {
    return 6502;
  }

  public function testAppend() {
    $m = $this->getMonoid();
    $one = $this->getOne();
    $two = $this->getTwo();
    $sum = $m->append($one, $two);
    
    $this->assertEquals(42, $sum);
  }

}
