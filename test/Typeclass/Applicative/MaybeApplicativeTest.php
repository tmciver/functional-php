<?php

namespace PhatCats\Test\Typeclass\Applicative;

use PhatCats\Maybe\MaybeMonad;

class MaybeApplicativeTest extends ApplicativeTest {

  public function getApplicative() {
    return new MaybeMonad();
  }
}

