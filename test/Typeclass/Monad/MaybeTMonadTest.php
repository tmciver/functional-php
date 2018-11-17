<?php

namespace TMciver\Functional\Test\Typeclass\Monad;

use TMciver\Functional\Maybe\MaybeTMonad;
use TMciver\Functional\Either\Monad\RightFavoringEitherMonad;

/**
 * Class for testing `MaybeTMonad`.
 * @see TMciver\Functional\Test\Typeclass\Monad\MonadTest;
 */
class MaybeTMonadTest extends MonadTest {

  private $maybeTMonad;

  public function setUp() {
    $this->maybeTMonad = new MaybeTMonad(new RightFavoringEitherMonad());
  }

  protected function getMonad() {
    return $this->maybeTMonad;
  }

  protected function getValue() {
    return 1;
  }

  protected function getMonadicFunctionF() {
    return function($i) { return $this->maybeTMonad->pure($i + 1); };
  }

  protected function getMonadicFunctionG() {
    return function($i) { return $this->maybeTMonad->pure($i . ''); };
  }
}
