<?php

namespace TMciver\Functional\Typeclass;

interface Applicative extends Functor {

  /**
   * @param A value to be put into a minimal context.
   * @return The given value in a context.
   */
  function pure($val);

  /**
   * Applies the function contained in context `ff` to the value in context
   * `fa`.
   *
   * @param $ff: A function in some context.
   * @param $fa | null: A value in some context. The context must be of the same
   * type as that of `$ff`.
   * @return A value in some context. The context must be of the same type as
   * that of `$ff` and `$fa`.  The contained value is that returned by applying
   * the function in $ff to the value in $fa.
   */
  function apply($ff, $fa = null);
}

