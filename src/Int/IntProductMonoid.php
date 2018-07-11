<?php

namespace TMciver\Functional\Int;

use TMciver\Functional\Typeclass\BaseMonoid;

class IntProductMonoid extends BaseMonoid {

  function identity() {
    return 1;
  }

  function append($left, $right) {
    return $left * $right;
  }
}
