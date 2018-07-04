<?php

namespace TMciver\Functional\Test\LinkedList;

use TMciver\Functional\Test\LinkedList\LinkedListTest;
use TMciver\Functional\LinkedList\Cons;

/**
 * This class exists to implement the Template Pattern
 * (https://en.wikipedia.org/wiki/Template_method_pattern) for creating a
 * LinkedList made up of Cons cells.
 */
class ConsListTest extends LinkedListTest {

  protected function makeListFromArray(array $array) {
    $init = $this->listFactory->empty();
    $reversed = array_reverse($array);
    $f = function ($l, $v) {
      return new Cons($v, $l, $this->listFactory);
    };

    return array_reduce($reversed, $f, $init);
  }
}
