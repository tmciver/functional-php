<?php

namespace TMciver\Functional\Validation;

use TMciver\Functional\ObjectTypeclasses\ObjectSemiGroup;
use TMciver\Functional\ObjectTypeclasses\ObjectApplicative;

abstract class Validation {
  use ObjectSemiGroup, ObjectApplicative;

  public static function fromValue($val) {
    return is_null($val) ?
      new Failure("Attempted to create a Validation with a null value.") :
      new Success($val);
  }

  public static function failure($val) {
    return is_null($val) ?
      new Failure("Attempted to create a Validation with a null value.") :
      new Failure($val);
  }

  public function fail($msg = "An unknown error occurred when using a 'Validation'.") {
    return self::failure($msg);
  }

  protected abstract function applyToSuccess($success);

  protected abstract function applyToFailure($failure);

  protected abstract function appendToSuccess($success);

  protected abstract function appendToFailure($failure);

  public function pure($val) {
    return is_null($val) ?
      new Failure("Called 'Validation::pure' with a null value.") :
      new Success($val);
  }
}
