<?php

namespace TMciver\Functional\Maybe;

use TMciver\Functional\Typeclass\BaseMonoid;
use TMciver\Functional\Maybe\Maybe;

class MaybeMonoid extends BaseMonoid {

  function identity() {
    return Maybe::nothing();
  }
}
