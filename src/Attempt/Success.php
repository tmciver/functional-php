<?php

namespace TMciver\Functional\Attempt;

use TMciver\Functional\Attempt\Failure;
use TMciver\Functional\AssociativeArray;
use TMciver\Functional\PartialFunction;
use TMciver\Functional\Util;
use TMciver\Functional\Typeclass\SemiGroup;

class Success extends Attempt {

  private $val;

    public function __construct($val) {
	$this->val = $val;
    }

    protected function applyNoArg() {
      return new Success(call_user_func($this->val));
    }

    protected function applyToArg($tryArg) {
      return $tryArg->applyToSuccess($this);
    }

    protected function applyToSuccess($success) {
      // Wrap the applicative value in a PartialFunction,
      // if it is not already.
      $pf = $success->val instanceof PartialFunction ?
	$success->val :
	new PartialFunction($success->val);

      return $this->map($pf);
    }

    public function getOrElse($default) {
        return $this->val;
    }

    public function map(callable $f) {

	// Since we don't know if $f will throw an exception, we wrap the call
	// in a try/catch. The result wiil be Failure if there's an exception.
	try {
	    $tryResult = Attempt::fromValue($f($this->val));
	} catch (\Exception $e) {
	    $tryResult = self::fail($e->getMessage());
	}

	return $tryResult;
    }

    public function flatMap(callable $f) {

	// Since we don't know if $f will throw an exception, we wrap the call
	// in a try/catch. The result wiil be Failure if there's an exception.
	try {
	    $tryResult = $f($this->val);

	    // If the result is null, we return Failure.
	    if (is_null($tryResult)) {
		$tryResult = self::fail("The result of calling a function using 'flatMap' was null.");
	    }
	} catch (\Exception $e) {
	    $tryResult = self::fail($e->getMessage());
	}

	return $tryResult;
    }

    public function accept($tryVisitor) {
	return $tryVisitor->visitSuccess($this);
    }

    public function get() {
	return $this->val;
    }

    public function orElse(callable $f, array $args) {
	return $this;
    }

    public function catch(callable $f) {
      return $this;
    }

    public function isFailure() {
	return false;
    }
}

