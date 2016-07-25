<?php

namespace TMciver\Functional\Either;

use TMciver\Functional\Either\Either;
use TMciver\Functional\Either\Left;

class Right extends Either {

    private $val;

    public function __construct($val) {
	$this->val = $val;
    }

    public function getOrElse($default) {
        return $this->val;
    }

    public function map(callable $f) {

	// Since we don't know if $f will throw an exception, we wrap the call
	// in a try/catch. The result wiil be Left if there's an exception.
	try {
	    $result = $f($this->val);

	    // If the result is null, we return Left.
	    if (is_null($result)) {
		$eitherResult = new Left("Result of call to " . $f . " was null.");
	    } else {
		$eitherResult = new Right($result);
	    }
	} catch (\Exception $e) {
	    $eitherResult = new Left($e->getMessage());
	}

	return $eitherResult;
    }

    public function bind(callable $f) {

	// Since we don't know if $f will throw an exception, we wrap the call
	// in a try/catch. The result wiil be Left if there's an exception.
	try {
	    $eitherResult = $f($this->val);

	    // If the result is null, we return Left.
	    if (is_null($eitherResult)) {
		$eitherResult = new Left("Result of call to " . $f . " was null.");
	    }
	} catch (\Exception $e) {
	    $eitherResult = new Left($e->getMessage());
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
