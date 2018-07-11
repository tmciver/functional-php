<?php

namespace TMciver\Functional\String;

use TMciver\Functional\Typeclass\Monoid;

class StringMonoid implements Monoid {

  function identity() {
    return "";
  }

  function append($left, $right) {
    return $left . $right;
  }
}
