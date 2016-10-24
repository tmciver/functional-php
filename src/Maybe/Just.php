<?php

namespace TMciver\Functional\Maybe;

use TMciver\Functional\Maybe\Maybe;
use TMciver\Functional\Maybe\Nothing;
use TMciver\Functional\AssociativeArray;

class Just extends Maybe {

    private $val;

    protected function __construct($val) {
	$this->val = $val;
    }

    public function getOrElse($default) {
        return $this->val;
    }

    public function map(callable $f) {

	// Since we don't know if $f will throw an exception, we wrap the call
	// in a try/catch. The result wiil be Nothing if there's an exception.
	try {
            $ret = call_user_func($f, $this->val);
	    $maybeResult = Maybe::fromValue($ret);
	} catch (\Exception $e) {
	    $maybeResult = self::fail();
	}

	return $maybeResult;
    }

    public function flatMap(callable $f) {

	// Since we don't know if $f will throw an exception, we wrap the call
	// in a try/catch. The result wiil be Nothing if there's an exception.
	try {
	    $maybeResult = $f($this->val);

	    // If the result is null, we return Nothing.
	    if (is_null($maybeResult)) {
		$maybeResult = self::fail();
	    }
	} catch (\Exception $e) {
	    $maybeResult = self::fail();
	}

	return $maybeResult;
    }

    public function __invoke() {

        // Get the arguments the function was called with. This ought to be an
        // array or Maybes.
        $args = func_get_args();

        // Convert the array of Maybes to a Maybe of array by sequencing.
        $maybeArgs = (new AssociativeArray($args))->sequence($this);

        // Call the callable wrapped by this context ($this->val) with the
        // wrapped args, wrap it back up in a Maybe and return it.
        return $maybeArgs->map(function($args) {
            return call_user_func_array($this->val, $args);
        });
    }

    public function append($appendee) {
        return $appendee->appendJust($this);
    }

    protected function appendJust($just) {
        // this is where the real work of appending two Just's is done.

        // Since we can't know if the value contained in a Maybe is itself a
        // monoid, we're just going to put the values in an array. But there are
        // four cases that we have to account for to create the proper result
        // array so that associativity is maintained.
        $leftVal = $just->val;
        $rightVal = $this->val;
        if (!is_array($leftVal) && !is_array($rightVal)) {
            $resultArray = [$leftVal, $rightVal];
        } else if (is_array($leftVal) && !is_array($rightVal)) {
            $leftVal[] = $rightVal;
            $resultArray = $leftVal;
        } else if (!is_array($leftVal) && is_array($rightVal)) {
            array_unshift($rightVal, $leftVal);
            $resultArray = $rightVal;
        } else {
            // both values are arrays
            $resultArray = array_merge($leftVal, $rightVal);
        }

        return Maybe::fromValue($resultArray);
    }

    public function accept($maybeVisitor) {
	return $maybeVisitor->visitJust($this);
    }

    public function get() {
	return $this->val;
    }

    public function orElse(callable $f, array $args) {
	return $this;
    }

    public function isNothing() {
	return false;
    }
}
