<?php

namespace TMciver\Functional\Test\Typeclass\Applicative;

use TMciver\Functional\Either\EitherMonad;

class EitherApplicativeTest extends ApplicativeTest {

  public function getApplicative() {
    return new EitherMonad();
  }
}

