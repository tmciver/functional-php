<?php

namespace TMciver\Functional\Either;

use TMciver\Functional\Typeclass\BaseMonad;

class EitherMonad extends BaseMonad {

  public function pure($v) {
    return is_null($v) ?
      new Left("Error: called Either::pure with a null value. ") :
      new Right($v);
  }
}
