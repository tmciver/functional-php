<?php

namespace TMciver\Functional\Validation;

use TMciver\Functional\PartialFunction;

class Success extends Validation {

  private $val;

  protected function __construct($val) {
    $this->val = $val;
  }

  function map(callable $f) {

    // Since we don't know if $f will throw an exception, we wrap the call
    // in a try/catch. The result wiil be Nothing if there's an exception.
    try {
      $ret = call_user_func($f, $this->val);
      $validationResult = Validation::fromValue($ret);
    } catch (\Exception $e) {
      $validationResult = self::fail("An exception was thrown when attempting map a function over a 'Success' Validation.");
    }

    return $validationResult;
  }

  public function flatMap(callable $f) {

    // Since we don't know if $f will throw an exception, we wrap the call
    // in a try/catch. The result wiil be Nothing if there's an exception.
    try {
      $validationResult = $f($this->val);

      // If the result is null, we return Nothing.
      if (is_null($validationResult)) {
	$validationResult = self::fail();
      }
    } catch (\Exception $e) {
      $validationResult = self::fail();
    }

    return $validationResult;
  }

  protected function applyNoArg() {
    return call_user_func($this->val);
  }

  protected function applyToArg($applicativeArgument) {
    return $applicativeArgument->applyToSuccess($this);
  }

  protected function applyToSuccess($success) {
    // Wrap the applicative value in a PartialFunction,
    // if it is not already.
    $pf = $success->val instanceof PartialFunction ?
      $success->val :
      new PartialFunction($success->val);

    return $this->map($pf);
  }

  protected function applyToFailure($failure) {
    return $failure;
  }

  public function append($other) {
    return $other->appendToSuccess($this);
  }

  protected function appendToSuccess($leftSuccess) {
    return $leftSuccess;
  }

  protected function appendToFailure($leftFailure) {
    return $this;
  }
}