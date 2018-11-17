<?php

namespace TMciver\Functional\Test\Typeclass\Monad;

use TMciver\Functional\Either\Monad\RightFavoringEitherMonad;

/**
 * Class for testing `RightFavoringEitherMonad`.
 * @see TMciver\Functional\Test\Typeclass\Monad\MonadTest;
 */
class RightFavoringEitherMonadTest extends MonadTest {

  private $eitherMonad;

  public function setUp() {
    $this->eitherMonad = new RightFavoringEitherMonad();
  }

  protected function getMonad() {
    return $this->eitherMonad;
  }

  protected function getValue() {
    return 1;
  }

  protected function getMonadicFunctionF() {
    return function($i) { return $this->eitherMonad->pure($i + 1); };
  }

  protected function getMonadicFunctionG() {
    return function($i) { return $this->eitherMonad->pure($i . ''); };
  }
}
