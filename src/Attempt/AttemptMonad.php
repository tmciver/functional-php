<?php

namespace TMciver\Functional\Attempt;

use TMciver\Functional\Typeclass\BaseMonad;

class AttemptMonad extends BaseMonad {

  public function pure($v) {
    return is_null($v) ?
      new Failure("Error: called AttemptMonad::pure with a null value.") :
      new Success($v);
  }
}
