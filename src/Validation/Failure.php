<?php

namespace TMciver\Functional\Validation;

use TMciver\Functional\Util;

class Failure extends Validation {

  private $val;

  protected function __construct($val) {
    $this->val = $val;
  }

  public function map(callable $f) {
    return $this;
  }

  public function append($other) {
    return $other->appendToFailure($this);
  }

  protected function appendToSuccess($leftSuccess) {
    return $leftSuccess;
  }

  protected function appendToFailure($failure) {
    // Here we account for several possibilities for the types of values
    // contained by the two Failures.
    $leftVal = $failure->val;
    $rightVal = $this->val;
    if (is_string($leftVal) && is_string($rightVal)) {
      $appendedResult = $leftVal . $rightVal;
    } else if (Util::is_monoid($leftVal) && Util::is_monoid($rightVal)) {
      $appendedResult = $leftVal->append($rightVal);
    } else if (!is_array($leftVal) && !is_array($rightVal)) {
      $appendedResult = [$leftVal, $rightVal];
    } else if (is_array($leftVal) && !is_array($rightVal)) {
      $leftVal[] = $rightVal;
      $appendedResult = $leftVal;
    } else if (!is_array($leftVal) && is_array($rightVal)) {
      array_unshift($rightVal, $leftVal);
      $appendedResult = $rightVal;
    } else {
      // both values are arrays
      $appendedResult = array_merge($leftVal, $rightVal);
    }

    return new Failure($appendedResult);
  }
}