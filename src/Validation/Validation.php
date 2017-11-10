<?php

namespace TMciver\Functional\Validation;

use TMciver\Functional\SemiGroup;

abstract class Validation {
  use SemiGroup;

  public static function fromValue($val) {
    if (is_null($val)) {
      $validation = new Failure("Attempted to create a Validation with a null value.");
    } else {
      $validation = new Success($val);
    }

    return $validation;
  }

  public static function failure($val) {
    return is_null($val) ?
      new Failure("Attempted to create a Validation with a null value.") :
      new Failure($val);
  }

  protected abstract function appendToSuccess($success);

  protected abstract function appendToFailure($failure);
}