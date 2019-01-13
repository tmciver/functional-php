<?php

namespace TMciver\Functional\Test\Typeclass\Applicative;

use TMciver\Functional\LinkedList\LinkedListMonad;

class LinkedListApplicativeTest extends ApplicativeTest {

  public function getApplicative() {
    return new LinkedListMonad();
  }
}

