<?php

namespace TMciver\Functional\Test\Typeclass\Monoid;

use PHPUnit\Framework\TestCase;

abstract class MonoidTest extends TestCase {

  protected $monoid;
  protected $m1, $m2, $m3;

  protected abstract function getMonoid();
  protected abstract function getOne();
  protected abstract function getTwo();
  protected abstract function getThree();

  public function setUp() {
    $this->monoid = $this->getMonoid();
    $this->m1 = $this->getOne();
    $this->m2 = $this->getTwo();
    $this->m3 = $this->getThree();
  }

  public function testAssociativity() {

    $m1m2 = $this->monoid->append($this->m1, $this->m2);
    $m2m3 = $this->monoid->append($this->m2, $this->m3);

    $first = $this->monoid->append($m1m2, $this->m3);
    $second = $this->monoid->append($this->m1, $m2m3);

    $this->assertEquals($first, $second);
  }

  public function testLeftIdentity() {
    $ident = $this->monoid->identity();
    $result = $this->monoid->append($ident, $this->m1);

    $this->assertEquals($this->m1, $result);
  }

  public function testRightIdentity() {
    $ident = $this->monoid->identity();
    $result = $this->monoid->append($this->m1, $ident);

    $this->assertEquals($this->m1, $result);
  }
}
