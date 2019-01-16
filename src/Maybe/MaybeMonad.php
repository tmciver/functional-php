<?php

namespace PhatCats\Maybe;

use PhatCats\Typeclass\BaseMonadForObjectMonad;

class MaybeMonad extends BaseMonadForObjectMonad {

  public function pure($v) {
    return is_null($v) ?
      new Nothing() :
      new Just($v);
  }
}
