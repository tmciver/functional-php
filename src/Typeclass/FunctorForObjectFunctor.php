<?php

namespace TMciver\Functional\Typeclass;

/**
 * `DefaultFunctor` is a `Functor` that assumes that the first argument to `map`
 * is of type `ObjectFunctor` and simply calls its `map` method on the given
 * function.
 */
class DefaultFunctor implements Functor {

  function map($val, callable $f) {
    return $val->map($f);
  }
}
