<?php

namespace PhatCats\Test\Typeclass\Applicative;

use PhatCats\LinkedList\LinkedListMonad;

class LinkedListApplicativeTest extends ApplicativeTest {

  public function getApplicative() {
    return new LinkedListMonad();
  }
}

