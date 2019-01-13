<?php

namespace TMciver\Functional\Test\Typeclass\Applicative;

use TMciver\Functional\Maybe\MaybeMonad;

class MaybeApplicativeTest extends ApplicativeTest {

  public function getApplicative() {
    return new MaybeMonad();
  }
}

