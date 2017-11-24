<?php

namespace TMciver\Functional\Validation;

use TMciver\Functional\SemiGroup;
use TMciver\Functional\Monad;

abstract class Validation {
  use SemiGroup, Monad;

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

  protected abstract function appendToSuccess($success);

  protected abstract function appendToFailure($failure);

  public function pure($val) {
    return is_null($val) ?
      new Failure("Called 'Validation::pure' with a null value.") :
      new Success($val);
  }
}