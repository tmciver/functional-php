<?php

namespace PhatCats\Maybe;

use PhatCats\Typeclass\BaseMonoid;
use PhatCats\Typeclass\Monoid;
use PhatCats\Maybe\Maybe;

class MaybeMonoid extends BaseMonoid {

  public function __construct(Monoid $innerMonoid) {
    parent::__construct($innerMonoid);
  }

  function identity() {
    return Maybe::nothing();
  }
}
