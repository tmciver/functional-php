<?php

namespace TMciver\Functional\Test\Typeclass\Functor;

use TMciver\Functional\Either\Monad\RightFavoringEitherMonad;
use TMciver\Functional\Either\Either;

class RightFavoringEitherFunctorTest extends FunctorTest {

  function getFunctorInstance() {
    return new RightFavoringEitherMonad();
  }

  function getValue() {
    return Either::fromValue(5);
  }

  function getF() {
    return function (int $x) : int { return $x + 1; };
  }

  function getG() {
    return function (int $x) : string { return (string)$x; };
  }
}
