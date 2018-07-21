<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\Typeclass\BaseMonad;

class LinkedListMonad extends BaseMonad {

  private $factory;

  public function __construct() {
    $this->factory = new LinkedListFactory();
  }

  public function pure($v) {
    return $this->factory->pure($v);
  }
}
