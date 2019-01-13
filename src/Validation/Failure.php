<?php

namespace TMciver\Functional\Validation;

use TMciver\Functional\Util;
use TMciver\Functional\Typeclass\SemiGroup;

class Failure extends Validation {

  public function __construct($val) {
    $this->val = $val;
  }

  public function map(callable $f) {
    return $this;
  }

  // TODO Validation can't be a Monad!
  // https://stackoverflow.com/questions/40539650/why-can-accvalidation-not-have-a-monad-instance
  public function flatMap(callable $f) {
    return $this;
  }

  protected function applyNoArg() {
    return $this;
  }

  protected function applyToArg($applicativeArgument, SemiGroup $semiGroup) {
    return $applicativeArgument->applyToFailure($this, $semiGroup);
  }

  protected function applyToSuccess($success) {
    return $this;
  }

  protected function applyToFailure($failure, SemiGroup $semiGroup) {
    // it's nice to be able to reuse this functionality!
    return $this->appendToFailure($failure, $semiGroup);
  }

  public function append($other, SemiGroup $innerSemigroup) {
    return $other->appendToFailure($this, $innerSemigroup);
  }

  protected function appendToSuccess($leftSuccess) {
    return $leftSuccess;
  }

  protected function appendToFailure($failure, SemiGroup $innerSemigroup) {
    $leftVal = $failure->val;
    $rightVal = $this->val;
    $appendedResult = $innerSemigroup->append($leftVal, $rightVal);

    return new Failure($appendedResult);
  }
}
