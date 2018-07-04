<?php

use PHPUnit\Framework\TestCase;
use TMciver\Functional\LinkedList\LinkedListFactory;

class MonoidTest extends TestCase {

  private $monoidData;

  public function setUp() {
    $this->monoidData = [new ListMonoidTestData()];
  }

  public function testAssociativity() {

    foreach ($this->monoidData as $monoid) {
      $m1 = $monoid->getMonoid1();
      $m2 = $monoid->getMonoid2();
      $m3 = $monoid->getMonoid3();

      $m1m2 = $m1->append($m2);
      $m2m3 = $m2->append($m3);

      $first = $m1m2->append($m3);
      $second = $m1->append($m2m3);

      $this->assertEquals($first, $second);
    }
  }

  public function testLeftIdentity() {
    foreach ($this->monoidData as $monoid) {
      $m1 = $monoid->getMonoid1();
      $ident = $m1->identity();

      $result = $ident->append($m1);

      $this->assertEquals($m1, $result);
    }
  }

  public function testRightIdentity() {
    foreach ($this->monoidData as $monoid) {
      $m1 = $monoid->getMonoid1();
      $ident = $m1->identity();

      $result = $m1->append($ident);

      $this->assertEquals($m1, $result);
    }
  }
}

interface MonoidTestData {
  function getMonoid1();
  function getMonoid2();
  function getMonoid3();
}

class ListMonoidTestData implements MonoidTestData {
  private $listFactory;

  public function __construct() { $this->listFactory = new LinkedListFactory(); }

  function getMonoid1() { return $this->listFactory->fromNativeArray([1, 2]); }
  function getMonoid2() { return $this->listFactory->fromNativeArray([3, 4]); }
  function getMonoid3() { return $this->listFactory->fromNativeArray([5, 6]); }
}
