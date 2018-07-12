<?php

namespace TMciver\Functional\Either;

use TMciver\Functional\Typeclass\SemiGroup;

class Left extends Either {

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

    public function applyToRight($right) {
      // The argument $right contains the function but since the argument
      // is a Left (this object), we return $this.
      return $this;
    }

    public function append($either, SemiGroup $semiGroup = null) {
        return $either;
    }

    public function appendRight($right) {
        return $right;
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

    public function accept($eitherVisitor) {
	return $eitherVisitor->visitLeft($this);
    }

    public function orElse(callable $f, array $args) {

        // Since we don't know if $f will throw an exception, we wrap the call
	// in a try/catch. The result wiil be Left if there's an exception.
	try {
	    $eitherResult = call_user_func_array($f, $args);
	} catch (\Exception $e) {
	    $eitherResult = Either::left($e->getMessage());
	}

	return $eitherResult;
    }

    public function get() {
	return $this->val;
    }

    public function isLeft() {
	return true;
    }
}
