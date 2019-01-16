<?php

namespace PhatCats\Test\LinkedList;

use PhatCats\Test\LinkedList\LinkedListTest;
use PhatCats\LinkedList\ArrayBackedLinkedList;

/**
 * This class exists to implement the Template Pattern
 * (https://en.wikipedia.org/wiki/Template_method_pattern) for creating a
 * ArrayBackedLinkedList LinkedList.
 */
class ArrayBackedLinkedListTest extends LinkedListTest {

  protected function makeListFromArray(array $array) {
    return new ArrayBackedLinkedList($array, $this->listFactory);
  }
}
