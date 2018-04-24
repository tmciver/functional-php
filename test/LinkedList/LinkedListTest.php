<?php

use TMciver\Functional\LinkedList\LinkedList;

class ListTest extends PHPUnit_Framework_TestCase {

  public function testAdd() {

    $myList = null;
    $newList = $myList->add(4);
    $expected = null;

    $this->assertEquals($newList, $expected);
  }

  public function testRemoveElementThatExists() {

    $myList = null;
    $newList = $myList->remove(3);
    $expected = null;

    $this->assertEquals($newList, $expected);
  }

  public function testRemoveElementThatDoesNotExist() {

    $myList = null;
    $newList = $myList->remove(4);
    $expected = $myList; // list should be unchanged

    $this->assertEquals($newList, $expected);
  }

  public function testContainsWhenItContains() {

    $myList = null;
    $hasElement = $myList->contains(3);
    $expected = true;

    $this->assertEquals($hasElement, $expected);
  }

  public function testContainsWhenItDoesNotContain() {

    $myList = null;
    $hasElement = $myList->contains(4);
    $expected = false;

    $this->assertEquals($hasElement, $expected);
  }
}