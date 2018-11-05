<?php

namespace TMciver\Functional\Typeclass;

interface Monad extends Applicative {

  /**
   * @param $ma: A value of type `a` in a context `m`.
   * @param $f :: a -> m b: a function that takes a value of type `a` and
   *        returns a value of type `b` in a context `m`.
   * @return A value of type `b` in a context `m`.
   */
  function flatMap($ma, callable $f);

  /**
   * Flattens a nested context.
   * @param $mma :: m (m a) A value in a context m which itself is in a context
   *        m.
   * @return a value of type `a` in a context `m`.
   */
  function join($mma);

  //function fail($messag);
}
