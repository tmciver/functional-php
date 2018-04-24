<?php

use TMciver\Functional\LinkedList\EmptyList;

class ListTest extends PHPUnit_Framework_TestCase {

  private $empty;

  public function __construct() {
    $this->empty = new EmptyList();
  }

  public function testAdd() {

    $myList = $this->empty->add(3)->add(2)->add(1);
    $newList = $myList->add(4);
    $expected = $this->empty->add(3)->add(2)->add(1)->add(4);

    $this->assertEquals($newList, $expected);
  }

  public function testRemoveElementThatExists() {

    $myList = $this->empty->add(3)->add(2)->add(1);
    $newList = $myList->remove(3);
    $expected = $this->empty->add(2)->add(1);

    $this->assertEquals($newList, $expected);
  }

  public function testRemoveElementThatDoesNotExist() {

    $myList = $this->empty->add(3)->add(2)->add(1);
    $newList = $myList->remove(4);
    $expected = $myList; // list should be unchanged

    $this->assertEquals($newList, $expected);
  }

  public function testRemoveOnlyFirstElement() {

    $myList = $this->empty->add(3)->add(2)->add(1)->add(2); // [2, 1, 2, 3]
    $newList = $myList->remove(2);
    $expected = $this->empty->add(3)->add(2)->add(1);

    $this->assertEquals($newList, $expected);
  }

  public function testContainsWhenItContains() {

    $myList = $this->empty->add(3)->add(2)->add(1);
    $hasElement = $myList->contains(3);
    $expected = true;

    $this->assertEquals($hasElement, $expected);
  }

  public function testContainsWhenItDoesNotContain() {

    $myList = $this->empty->add(3)->add(2)->add(1);
    $hasElement = $myList->contains(4);
    $expected = false;

    $this->assertEquals($hasElement, $expected);
  }
}