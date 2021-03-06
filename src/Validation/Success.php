<?php

namespace PhatCats\Validation;

use PhatCats\PartialFunction;
use PhatCats\Typeclass\SemiGroup;

class Success extends Validation {

  private $val;

  public function __construct($val) {
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

  // TODO Validation can't be a Monad!
  // https://stackoverflow.com/questions/40539650/why-can-accvalidation-not-have-a-monad-instance
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
    // Since we don't know if the wrapped function will throw an exception, we
	// wrap the call in a try/catch. The result wiil be Failure if there's an
	// exception or if the result is null.
    $validationResult = null;
	try {
      $result = call_user_func($this->val);

      // If the result is null, we return Nothing.
      if (is_null($result)) {
        $validationResult = self::failure("The result of calling the wrapped function was null.");
      }
	} catch (\Exception $e) {
      $validationResult = self::failure("There was an exception when calling the wrapped function: " . $e->getMessage());
	}

	return is_null($validationResult) ?
      new Success($result) :
      $validationResult;
  }

  protected function applyToArg($applicativeArgument, SemiGroup $semiGroup) {
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

  protected function applyToFailure($failure, SemiGroup $semiGroup) {
    return $failure;
  }

  /**
   * Append two 'Validation's together.
   *
   * @param $other the 'Validation' append to this one.
   * @param $innerSemigroup A 'Semigroup' instance to use to append two
   * 'Failure's together.
   */
  public function append($other, SemiGroup $innerSemigroup) {
    return $other->appendToSuccess($this);
  }

  protected function appendToSuccess($leftSuccess) {
    return $leftSuccess;
  }

  protected function appendToFailure($leftFailure, SemiGroup $semiGroup) {
    return $this;
  }
}
