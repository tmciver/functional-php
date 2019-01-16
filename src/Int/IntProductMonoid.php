<?php

namespace PhatCats\Int;

use PhatCats\Typeclass\Monoid;

class IntProductMonoid implements Monoid {

  function identity() {
    return 1;
  }

  function append($left, $right) {
    return $left * $right;
  }
}
