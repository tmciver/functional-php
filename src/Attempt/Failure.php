<?php

namespace TMciver\Functional\Attempt;

use TMciver\Functional\Typeclass\SemiGroup;

class Failure extends Attempt {

  private $val;

    protected function __construct($val) {
	$this->val = $val;
    }

    protected function applyNoArg() {
      return $this;
    }

    protected function applyToArg($ignore) {
      return $this;
    }

    public function applyToSuccess($success) {
      // The argument $success contains the function but since the argument
      // is a Failure (this object), we return $this.
      return $this;
    }

    public function getOrElse($default) {
        return $default;
    }

    public function map(Callable $f) {
	return $this;
    }

    public function flatMap(callable $f) {
	return $this;
    }

    public function accept($tryVisitor) {
	return $tryVisitor->visitFailure($this);
    }

    public function orElse(callable $f, array $args) {

        // Since we don't know if $f will throw an exception, we wrap the call
	// in a try/catch. The result wiil be Failure if there's an exception.
	try {
	    $tryResult = call_user_func_array($f, $args);
	} catch (\Exception $e) {
	    $tryResult = Attempt::failure($e->getMessage());
	}

	return $tryResult;
    }

    public function get() {
	return $this->val;
    }

    public function isFailure() {
	return true;
    }
}
