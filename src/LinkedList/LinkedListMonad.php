<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\Typeclass\BaseObjectMonad;

class LinkedListMonad extends BaseObjectMonad {

  private $factory;

  public function __construct() {
    $this->factory = new LinkedListFactory();
  }

  public function pure($v) {
    return $this->factory->pure($v);
  }
}
