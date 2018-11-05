<?php

namespace TMciver\Functional\Typeclass;

interface Applicative extends Functor {

  /**
   * @param A value to be put into a minimal context.
   * @return The given value in a context.
   */
  function pure($val);

  /**
   * Applies the function contained in context `f` to the value also in context
   * `f`.
   *
   * @param $ff: A function in a context `f`.
   * @param $fa | null: A value in a context `f`.
   * @return A value in a context `f`. The contained value is that returned by
   * applying the function in $ff to the value in $fa.
   */
  function apply($ff, $fa = null);
}

