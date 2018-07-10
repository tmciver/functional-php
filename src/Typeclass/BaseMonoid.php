<?php

namespace TMciver\Functional\Typeclass;

use TMciver\Functional\Typeclass\Monoid;

abstract class BaseMonoid implements Monoid {

  /**
   * Default implementation assumes that $left and $right are instances of
   * `ObjectMonoid`.
   */
  function append($left, $right) {
    return $left->append($right);
  }
}
