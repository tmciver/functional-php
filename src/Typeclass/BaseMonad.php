<?php

namespace TMciver\Functional\Typeclass;

/**
 * BaseMonad contains default implementations for both `flatMap` and `join`.
 * Note that one of these methods *must* be implemented when extending this
 * class since these methods are defined in terms of each other.
 *
 * If you would like to implement a Monad for a custom type and that type has an
 * implementation of the `ObjectMonad` trait, please extend the
 * `BaseMonadForObjectMonad` abstract class instead of this one.
 */
abstract class BaseMonad extends BaseApplicative implements Monad {

  public function flatMap($ma, callable $f) {
    return $this->map($ma, $f)->join();
  }

  public function join($mma) {
    return $this->flatMap($mma, $identity);
  }
}
