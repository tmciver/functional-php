<?php

namespace PhatCats\Maybe;

use PhatCats\Typeclass\BaseMonadForObjectMonad;
use PhatCats\Typeclass\Monad;

class MaybeTMonad extends BaseMonadForObjectMonad {

  private $m;
  private $maybeMonad;

  public function __construct(Monad $m) {
    $this->m = $m;
    $this->maybeMonad = new MaybeMonad();
  }

  public function pure($v) {
    return new MaybeT($this->m->pure($this->maybeMonad->pure($v)));
  }

  public function flatMap($maybeT, callable $f) {
    return $maybeT->flatMap($this->m, $f);
  }

  public function apply($maybeT, $fa = null) {
    return $maybeT->apply($this->m, $fa);
  }
}
