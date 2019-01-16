<?php

namespace PhatCats\Int;

use PhatCats\Typeclass\Monoid;

class IntSumMonoid implements Monoid {

  function identity() {
    return 0;
  }

  function append($left, $right) {
    return $left + $right;
  }
}
