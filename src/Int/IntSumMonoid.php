<?php

namespace TMciver\Functional\Int;

use TMciver\Functional\Typeclass\BaseMonoid;

class IntSumMonoid extends BaseMonoid {

  function identity() {
    return 0;
  }

  function append($left, $right) {
    return $left + $right;
  }
}
