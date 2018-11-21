<?php

namespace TMciver\Functional\Maybe;

use TMciver\Functional\Typeclass\BaseMonadForObjectMonad;

class MaybeMonad extends BaseMonadForObjectMonad {

  public function pure($v) {
    return is_null($v) ?
      new Nothing() :
      new Just($v);
  }
}
