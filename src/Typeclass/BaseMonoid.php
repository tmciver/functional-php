<?php

namespace PhatCats\Typeclass;

use PhatCats\Typeclass\Monoid;

abstract class BaseMonoid implements Monoid {

  protected $innerMonoid;

  public function __construct(Monoid $innerMonoid) {
    $this->innerMonoid = $innerMonoid;
  }

  /**
   * Default implementation assumes that $left and $right are instances of
   * `ObjectMonoid`.
   */
  function append($left, $right) {
    return $left->append($right, $this->innerMonoid);
  }
}
