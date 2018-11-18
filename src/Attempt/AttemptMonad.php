<?php

namespace TMciver\Functional\Attempt;

use TMciver\Functional\Typeclass\BaseObjectMonad;

class AttemptMonad extends BaseObjectMonad {

  public function pure($v) {
    return is_null($v) ?
      new Failure("Error: called AttemptMonad::pure with a null value.") :
      new Success($v);
  }
}
