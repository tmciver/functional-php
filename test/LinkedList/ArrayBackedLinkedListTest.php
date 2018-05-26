<?php

namespace TMciver\Functional\Test\LinkedList;

use TMciver\Functional\Test\LinkedList\LinkedListTest;
use TMciver\Functional\LinkedList\ArrayBackedLinkedList;

/**
 * This class exists to implement the Template Pattern
 * (https://en.wikipedia.org/wiki/Template_method_pattern) for creating a
 * ArrayBackedLinkedList LinkedList.
 */
class ArrayBackedLinkedListTest extends LinkedListTest {

  public function __construct() {
    parent::__construct();
  }

  protected function makeListFromArray(array $array) {
    return new ArrayBackedLinkedList($array);
  }
}
