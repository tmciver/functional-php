<?php

namespace TMciver\Functional\Maybe;

use TMciver\Functional\Typeclass\BaseMonad;

class MaybeMonad extends BaseMonad {

  public function pure($v) {
    return is_null($v) ?
      new Nothing() :
      new Just($v);
  }
}
