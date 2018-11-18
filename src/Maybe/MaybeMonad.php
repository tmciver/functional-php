<?php

namespace TMciver\Functional\Maybe;

use TMciver\Functional\Typeclass\BaseObjectMonad;

class MaybeMonad extends BaseObjectMonad {

  public function pure($v) {
    return is_null($v) ?
      new Nothing() :
      new Just($v);
  }
}
