<?php

namespace TMciver\Functional\Either;

use TMciver\Functional\Either\Left;
use TMciver\Functional\AssociativeArray;
use TMciver\Functional\PartialFunction;
use TMciver\Functional\Util;
use TMciver\Functional\Typeclass\SemiGroup;

class Right extends Either {

  private $val;

    protected function __construct($val) {
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

    public function append($appendee, SemiGroup $semiGroup = null) {
        return $appendee->appendRight($this);
    }

    public function appendRight($right) {
        // this is where the real work of appending two Right's is done.

        // Since we can't know if the value contained in an Either is itself a
        // monoid, we're just going to put the values in an array. But there are
        // four cases that we have to account for to create the proper result
        // array so that associativity is maintained.
        $firstVal = $right->val;
        $secondVal = $this->val;
	if (is_string($firstVal) && is_string($secondVal)) {
	  $appendedResult = $firstVal . $secondVal;
	} else if (Util::is_monoid($firstVal) && Util::is_monoid($secondVal)) {
	  $appendedResult = $firstVal->append($secondVal);
	} else if (!is_array($firstVal) && !is_array($secondVal)) {
            $appendedResult = [$firstVal, $secondVal];
        } else if (is_array($firstVal) && !is_array($secondVal)) {
            $firstVal[] = $secondVal;
            $appendedResult = $firstVal;
        } else if (!is_array($firstVal) && is_array($secondVal)) {
            array_unshift($secondVal, $firstVal);
            $appendedResult = $secondVal;
        } else {
            // both values are arrays
            $appendedResult = array_merge($firstVal, $secondVal);
        }

        return new Right($appendedResult);
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

