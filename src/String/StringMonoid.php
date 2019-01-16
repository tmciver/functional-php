<?php

namespace PhatCats\String;

use PhatCats\Typeclass\Monoid;

class StringMonoid implements Monoid {

  function identity() {
    return "";
  }

  function append($left, $right) {
    return $left . $right;
  }
}
