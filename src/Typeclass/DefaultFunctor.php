<?php

namespace TMciver\Functional\Typeclass;

/**
 * The implementation of the `Functor::map` method assumes that the value $val,
 * for which this a functor instance, itself has a `map` method and simple
 * delegates to that.  This is done since it is likely that any such types will
 * implement their own `map` method.
 */
class DefaultFunctor implements Functor {

  function map($val, callable $f) {
    return $val->map($f);
  }
}
