<?php

namespace TMciver\Functional\Test\Typeclass\Applicative;

use TMciver\Functional\Validation\ValidationApplicative;

class ValidationApplicativeTest extends ApplicativeTest {

  public function getApplicative() {
    return new ValidationApplicative();
  }
}

