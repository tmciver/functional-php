<?php

namespace PhatCats\Validation;

use PhatCats\ObjectTypeclass\ObjectSemiGroup;
use PhatCats\ObjectTypeclass\ObjectApplicative;
use PhatCats\Typeclass\SemiGroup;

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

  public function apply($applicativeArgument, SemiGroup $semiGroup) {
    return is_null($applicativeArgument) ?
      $this->applyNoArg() :
      $this->applyToArg($applicativeArgument, $semiGroup);
  }

  /**
   * Calls the wrapped function with no arguments.
   */
  protected abstract function applyNoArg();

  /**
   * Calls the wrapped function on the value wrapped in the supplied argument.
   */
  protected abstract function applyToArg($applicativeArgument, SemiGroup $semiGroup);

  protected abstract function applyToSuccess($success);

  protected abstract function applyToFailure($failure, SemiGroup $semiGroup);

  protected abstract function appendToSuccess($success);

  protected abstract function appendToFailure($failure, SemiGroup $innerSemigroup);

  public function pure($val) {
    return is_null($val) ?
      new Failure("Called 'Validation::pure' with a null value.") :
      new Success($val);
  }
}
