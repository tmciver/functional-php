<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\LinkedList\LinkedListFactory;
use TMciver\Functional\Typeclass\BaseMonoid;

class ListMonoid extends BaseMonoid {

  private $listFactory;

  public function __construct() {
    $this->listFactory = new LinkedListFactory();
  }

  function identity() {
    return $this->listFactory->empty();
  }
}
