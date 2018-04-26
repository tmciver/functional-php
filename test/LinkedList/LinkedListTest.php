<?php

use TMciver\Functional\LinkedList\Nil;
use TMciver\Functional\Maybe\Maybe;

class ListTest extends PHPUnit_Framework_TestCase {

  private $empty;

  public function __construct() {
    $this->empty = new Nil();
  }

  public function testAdd() {

    $myList = $this->empty->add(3)->add(2)->add(1);
    $newList = $myList->add(4);
    $expected = $this->empty->add(3)->add(2)->add(1)->add(4);

    $this->assertEquals($expected, $newList);
  }

  public function testRemoveElementThatExists() {

    $myList = $this->empty->add(3)->add(2)->add(1);
    $newList = $myList->remove(3);
    $expected = $this->empty->add(2)->add(1);

    $this->assertEquals($expected, $expected);
  }

  public function testRemoveElementThatDoesNotExist() {

    $myList = $this->empty->add(3)->add(2)->add(1);
    $newList = $myList->remove(4);
    $expected = $myList; // list should be unchanged

    $this->assertEquals($expected, $newList);
  }

  public function testRemoveOnlyFirstElement() {

    $myList = $this->empty->add(3)->add(2)->add(1)->add(2); // [2, 1, 2, 3]
    $newList = $myList->remove(2);
    $expected = $this->empty->add(3)->add(2)->add(1);

    $this->assertEquals($expected, $newList);
  }

  public function testContainsWhenItContains() {

    $myList = $this->empty->add(3)->add(2)->add(1);
    $hasElement = $myList->contains(3);
    $expected = true;

    $this->assertEquals($expected, $hasElement);
  }

  public function testContainsWhenItDoesNotContain() {

    $myList = $this->empty->add(3)->add(2)->add(1);
    $hasElement = $myList->contains(4);
    $expected = false;

    $this->assertEquals($expected, $hasElement);
  }

  public function testHeadWhenNonEmpty() {
    $myList = $this->empty->add(3)->add(2)->add(1);
    $headMaybe = $myList->head();
    $expected = Maybe::fromValue(1);

    $this->assertEquals($expected, $headMaybe);
  }

  public function testHeadWhenEmpty() {
    $myList = $this->empty;
    $headMaybe = $myList->head();
    $expected = Maybe::$nothing;

    $this->assertEquals($expected, $headMaybe);
  }

  public function testTailWhenNonEmpty() {
    $myList = $this->empty->add(3)->add(2)->add(1);
    $tail = $myList->tail();
    $expected = $this->empty->add(3)->add(2);

    $this->assertEquals($expected, $tail);
  }

  public function testTailWhenEmpty() {
    $myList = $this->empty;
    $tail = $myList->tail();
    $expected = $this->empty;

    $this->assertEquals($expected, $tail);
  }

  public function testSize() {
    $list1 = $this->empty->add(3)->add(2)->add(1);
    $list2 = $this->empty;
    $expected1 = 3;
    $expected2 = 0;

    $this->assertEquals($expected1, $list1->size());
    $this->assertEquals($expected2, $list2->size());
  }
}