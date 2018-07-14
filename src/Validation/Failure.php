<?php

namespace TMciver\Functional\Validation;

use TMciver\Functional\Util;
use TMciver\Functional\Typeclass\SemiGroup;

class Failure extends Validation {

  protected function __construct($val) {
    $this->val = $val;
  }

  public function map(callable $f) {
    return $this;
  }

  public function flatMap(callable $f) {
    return $this;
  }

  protected function applyNoArg() {
    return $this;
  }

  protected function applyToArg($applicativeArgument) {
    return $applicativeArgument->applyToFailure($this);
  }

  protected function applyToSuccess($success) {
    return $this;
  }

  protected function applyToFailure($failure) {
    // it's nice to be able to reuse this functionality!
    return $this->appendToFailure($failure);
  }

  public function append($other, SemiGroup $semiGroup = null) {
    return $other->appendToFailure($this, $semiGroup);
  }

  protected function appendToSuccess($leftSuccess) {
    return $leftSuccess;
  }

  protected function appendToFailure($failure, SemiGroup $semiGroup) {
    $leftVal = $failure->val;
    $rightVal = $this->val;
    $appendedResult = $semiGroup->append($leftVal, $rightVal);

    return new Failure($appendedResult);
  }
}
