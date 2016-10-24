<?php

namespace TMciver\Functional\Either;

use TMciver\Functional\Either\Either;
use TMciver\Functional\Either\Left;
use TMciver\Functional\AssociativeArray;

class Right extends Either {

    private $val;

    protected function __construct($val) {
	$this->val = $val;
    }

    public function append($appendee) {
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
        if (!is_array($firstVal) && !is_array($secondVal)) {
            $resultArray = [$firstVal, $secondVal];
        } else if (is_array($firstVal) && !is_array($secondVal)) {
            $firstVal[] = $secondVal;
            $resultArray = $firstVal;
        } else if (!is_array($firstVal) && is_array($secondVal)) {
            array_unshift($secondVal, $firstVal);
            $resultArray = $secondVal;
        } else {
            // both values are arrays
            $resultArray = array_merge($firstVal, $secondVal);
        }

        return new Right($resultArray);
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

    public function __invoke() {

        // Get the arguments the function was called with. This ought to be an
        // array or Eithers.
        $args = func_get_args();

        // Convert the array of Eithers to an Either of array by sequencing.
        $eitherArgs = (new AssociativeArray($args))->sequence($this);

        // Call the callable wrapped by this context ($this->val) with the
        // wrapped args, wrap it back up in an Either and return it.
        return $eitherArgs->map(function($args) {
            return call_user_func_array($this->val, $args);
        });
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
