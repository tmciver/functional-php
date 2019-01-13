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

  /**
   * The `__invoke` magic method.  Allows one to call an `Applicative` as if it
   * were a function as in the following:
   *
   * ```php
   * $fResult = $applicativeInstance($ff, $fa, $fb, $fc);
   * ```
   *
   * where `$ff` is a function in a context; `$fa`, `$fb`, `$fc` are arguents in
   * a context and `$fResult` is the result of calling the function on the
   * arguments - in a context.
   */
  // TODO Implement or remove. The Semigroup requirement makes this more awkward
  //  than with other types.
  //function __invoke();
}
