<?php

namespace TMciver\Functional\Maybe;

use TMciver\Functional\Typeclass\BaseMonoid;
use TMciver\Functional\Typeclass\Monoid;
use TMciver\Functional\Maybe\Maybe;

class MaybeMonoid extends BaseMonoid {

  public function __construct(Monoid $innerMonoid) {
    parent::__construct($innerMonoid);
  }

  function identity() {
    return Maybe::nothing();
  }
}
