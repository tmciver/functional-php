<?php

namespace PhatCats\LinkedList;

use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\Typeclass\BaseMonoid;

class ListMonoid extends BaseMonoid {

  private $listFactory;

  public function __construct() {
    $this->listFactory = new LinkedListFactory();
  }

  function identity() {
    return $this->listFactory->empty();
  }
}
