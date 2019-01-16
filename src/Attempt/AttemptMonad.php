<?php

namespace PhatCats\Attempt;

use PhatCats\Typeclass\BaseMonadForObjectMonad;

class AttemptMonad extends BaseMonadForObjectMonad {

  public function pure($v) {
    return is_null($v) ?
      new Failure("Error: called AttemptMonad::pure with a null value.") :
      new Success($v);
  }
}
