<?php

namespace PhatCats\Either;

use PhatCats\Either\Left;
use PhatCats\AssociativeArray;
use PhatCats\PartialFunction;
use PhatCats\Util;
use PhatCats\Typeclass\SemiGroup;

class Right extends Either {

  private $val;

    public function __construct($val) {
	$this->val = $val;
    }

    protected function applyNoArg() {
      return new Right(call_user_func($this->val));
    }

    protected function applyToArg($eitherArg) {
      return $eitherArg->applyToRight($this);
    }

    protected function applyToRight($right) {
      // Wrap the applicative value in a PartialFunction,
      // if it is not already.
      $pf = $right->val instanceof PartialFunction ?
	$right->val :
	new PartialFunction($right->val);

      return $this->map($pf);
    }

    public function getOrElse($default) {
        return $this->val;
    }

    public function map(callable $f) {

	// Since we don't know if $f will throw an exception, we wrap the call
	// in a try/catch. The result wiil be Left if there's an exception.
	try {
	    $eitherResult = Either::fromValue($f($this->val));
	} catch (\Exception $e) {
	    $eitherResult = self::fail($e->getMessage());
	}

	return $eitherResult;
    }

    public function flatMap(callable $f) {

	// Since we don't know if $f will throw an exception, we wrap the call
	// in a try/catch. The result wiil be Left if there's an exception.
	try {
	    $eitherResult = $f($this->val);

	    // If the result is null, we return Left.
	    if (is_null($eitherResult)) {
		$eitherResult = self::fail("The result of calling a function using 'flatMap' was null.");
	    }
	} catch (\Exception $e) {
	    $eitherResult = self::fail($e->getMessage());
	}

	return $eitherResult;
    }

    public function accept($eitherVisitor) {
	return $eitherVisitor->visitRight($this);
    }

    public function get() {
	return $this->val;
    }

    public function orElse(callable $f, array $args) {
	return $this;
    }

    public function isLeft() {
	return false;
    }
}

