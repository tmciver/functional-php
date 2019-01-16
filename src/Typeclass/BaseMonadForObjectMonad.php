<?php

namespace PhatCats\Typeclass;

/**
 * Monad to be used as the basis for a Monad for a type that uses the
 * `ObjectMonad` trait or otherwise has implementations for the `flatMap` and
 * `join` methods.
 */
abstract class BaseMonadForObjectMonad extends BaseMonad {

  public function apply($ff, $fa = null) {
    return $ff->apply($fa);
  }

  public function map($ma, callable $f) {
    return $ma->map($f);
  }

  public function flatMap($ma, callable $f) {
    return $ma->flatMap($f);
  }
}
