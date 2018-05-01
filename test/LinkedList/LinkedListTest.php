<?php

use TMciver\Functional\LinkedList\LinkedListFactory;
use TMciver\Functional\Maybe\Maybe;

class ListTest extends PHPUnit_Framework_TestCase {

  private $listFactory;
  private $emptyList;

  public function __construct() {
    $this->listFactory = new LinkedListFactory();
    $this->emptyList = $this->listFactory->empty();
  }

  public function testAdd() {

    $myList = $this->listFactory->fromNativeArray([2, 3, 4]);
    $newList = $myList->cons(1);
    $expected = $this->listFactory->fromNativeArray([1, 2, 3, 4]);

    $this->assertEquals($expected, $newList);
  }

  public function testRemoveElementThatExists() {

    $myList = $this->listFactory->fromNativeArray([1, 2, 3]);
    $newList = $myList->remove(3);
    $expected = $this->listFactory->fromNativeArray([1, 2]);

    $this->assertEquals($expected, $expected);
  }

  public function testRemoveElementThatDoesNotExist() {

    $myList = $this->listFactory->fromNativeArray([1, 2, 3]);
    $newList = $myList->remove(4);
    $expected = $myList; // list should be unchanged

    $this->assertEquals($expected, $newList);
  }

  public function testRemoveOnlyFirstElement() {

    $myList = $this->listFactory->fromNativeArray([2, 1, 2, 3]);
    $newList = $myList->remove(2);
    $expected = $this->listFactory->fromNativeArray([1, 2, 3]);

    $this->assertEquals($expected, $newList);
  }

  public function testContainsWhenItContains() {

    $myList = $this->listFactory->fromNativeArray([1, 2, 3]);
    $hasElement = $myList->contains(3);
    $expected = true;

    $this->assertEquals($expected, $hasElement);
  }

  public function testContainsWhenItDoesNotContain() {

    $myList = $this->listFactory->fromNativeArray([1, 2, 3]);
    $hasElement = $myList->contains(4);
    $expected = false;

    $this->assertEquals($expected, $hasElement);
  }

  public function testHeadWhenNonEmpty() {
    $myList = $this->listFactory->fromNativeArray([1, 2, 3]);
    $headMaybe = $myList->head();
    $expected = Maybe::fromValue(1);

    $this->assertEquals($expected, $headMaybe);
  }

  public function testHeadWhenEmpty() {
    $myList = $this->emptyList;
    $headMaybe = $myList->head();
    $expected = Maybe::$nothing;

    $this->assertEquals($expected, $headMaybe);
  }

  public function testTailWhenNonEmpty() {
    $myList = $this->listFactory->fromNativeArray([1, 2, 3]);
    $tail = $myList->tail();
    $expected = $this->listFactory->fromNativeArray([2, 3]);

    $this->assertEquals($expected, $tail);
  }

  public function testTailWhenEmpty() {
    $myList = $this->emptyList;
    $tail = $myList->tail();
    $expected = $this->emptyList;

    $this->assertEquals($expected, $tail);
  }

  public function testSize() {
    $list1 = $this->listFactory->fromNativeArray([1, 2, 3]);
    $list2 = $this->emptyList;
    $expected1 = 3;
    $expected2 = 0;

    $this->assertEquals($expected1, $list1->size());
    $this->assertEquals($expected2, $list2->size());
  }

  public function testMap() {
    $list = $this->listFactory->fromNativeArray([1, 2, 3]);
    $listPlusOne = $list->map(function ($x) { return $x + 1;});
    $expected = $this->listFactory->fromNativeArray([2, 3, 4]);

    $this->assertEquals($expected, $listPlusOne);
  }
}
