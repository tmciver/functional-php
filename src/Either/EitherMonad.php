<?php

namespace TMciver\Functional\Either;

use TMciver\Functional\Typeclass\BaseMonad;

class EitherMonad extends BaseMonad {

  public function pure($v) {
    return new Right($v);
  }
}
