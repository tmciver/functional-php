<?php

use TMciver\Functional\LinkedList\LinkedListFactory;
use TMciver\Functional\LinkedList\ArrayBackedLinkedList;

class LinkedListFactoryTest extends PHPUnit_Framework_TestCase {

  private $listFactory;
  private $emptyList;

  public function __construct() {
    $this->listFactory = new LinkedListFactory();
    $this->emptyList = $this->listFactory->empty();
  }

  protected function assertLinkedListsEqual($l1, $l2) {
    $this->assertEquals($l1->toNativeArray(), $l2->toNativeArray());
  }

  public function testFromNativeArrayNonEmpty() {
    $ll = $this->listFactory->fromNativeArray([1, 2, 3]);
    $expectedArray = $this->listFactory->empty()->cons(3)->cons(2)->cons(1)->toNativeArray();
    $expected = new ArrayBackedLinkedList($expectedArray);

    $this->assertEquals($expected, $ll);
  }

  public function testFromNativeArrayEmpty() {
    $ll = $this->listFactory->fromNativeArray([]);
    $expected = $this->emptyList;

    $this->assertEquals($expected, $ll);
  }

  public function testRange() {
    $list = $this->listFactory->range(2, 11, 2);
    $expected = $this->listFactory->fromNativeArray([2, 4, 6, 8, 10]);

    $this->assertEquals($expected, $list);
  }

  public function testCycleNonEmpty() {
    $l = $this->listFactory->fromNativeArray([1, 2, 3]);
    $c = $this->listFactory->cycle($l);
    $result = $c->take(7);
    $expected = $this->listFactory->fromNativeArray([1, 2, 3, 1, 2, 3, 1]);

    $this->assertLinkedListsEqual($expected, $result);
  }

  public function testCycleEmpty() {
    $l = $this->listFactory->empty();
    $c = $this->listFactory->cycle($l);
    $result = $c->take(7);
    $expected = $this->listFactory->empty();

    $this->assertLinkedListsEqual($expected, $result);
  }
}
