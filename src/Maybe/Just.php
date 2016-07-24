<?php

namespace TMciver\Functional\Maybe;

use TMciver\Functional\Maybe\Maybe;
use TMciver\Functional\Maybe\Nothing;

class Just extends Maybe {

    private $val;

    public function __construct($val) {
	$this->val = $val;
    }

    public function fmap(callable $f) {

	// Since we don't know if $f will throw an exception, we wrap the call
	// in a try/catch. The result wiil be Nothing if there's an exception.
	try {
	    $result = $f($this->val);

	    // If the result is null, we return Nothing.
	    if (is_null($result)) {
		$maybeResult = new Nothing("Result of call to " . $f . " was null.");
	    } else {
		$maybeResult = new Just($result);
	    }
	} catch (\Exception $e) {
	    $maybeResult = new Nothing($e->getMessage());
	}

	return $maybeResult;
    }

    public function bind(callable $f) {

	// Since we don't know if $f will throw an exception, we wrap the call
	// in a try/catch. The result wiil be Nothing if there's an exception.
	try {
	    $maybeResult = $f($this->val);

	    // If the result is null, we return Nothing.
	    if (is_null($maybeResult)) {
		$maybeResult = new Nothing();
	    }
	} catch (\Exception $e) {
	    $maybeResult = new Nothing();
	}

	return $maybeResult;
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

        return new Just($resultArray);
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
