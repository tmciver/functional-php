<?php

namespace TMciver\Functional;

use TMciver\Functional\Nothing;

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
		$maybeResult = new Nothing("Result of call to " . $f . " was null.");
	    }
	} catch (\Exception $e) {
	    $maybeResult = new Nothing($e->getMessage());
	}

	return $maybeResult;
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
