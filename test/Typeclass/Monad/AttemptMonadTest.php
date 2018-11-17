<?php

namespace TMciver\Functional\Test\Typeclass\Monad;

use TMciver\Functional\Attempt\AttemptMonad;
use TMciver\Functional\Attempt\Attempt;

/**
 * Class for testing `AttemptMonad`.
 * @see TMciver\Functional\Test\Typeclass\Monad\MonadTest;
 */
class AttemptMonadTest extends MonadTest {

  private $attemptMonad;

  public function setUp() {
    $this->attemptMonad = new AttemptMonad();
  }

  protected function getMonad() {
    return $this->attemptMonad;
  }

  protected function getValue() {
    return 1;
  }

  protected function getMonadicFunctionF() {
    return function($i) { return $this->attemptMonad->pure($i + 1); };
  }

  protected function getMonadicFunctionG() {
    return function($i) { return $this->attemptMonad->pure($i . ''); };
  }
}
