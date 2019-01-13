<?php

namespace TMciver\Functional\Maybe;

use TMciver\Functional\Typeclass\SemiGroup;

class Nothing extends Maybe {

    public function getOrElse($default) {
        return $default;
    }

    public function map(Callable $f) {
	return $this;
    }

    public function flatMap(callable $f) {
	return $this;
    }

    protected function applyNoArg() {
      return $this;
    }

    protected function applyToArg($ignore) {
      return $this;
    }

    protected function applyToJust($just) {
      return $this;
    }

    public function append($appendee, SemiGroup $semiGroup = null) {
        return $appendee;
    }

    protected function appendJust($just, SemiGroup $semiGroup) {
        return $just;
    }

    public function accept($maybeVisitor) {
	return $maybeVisitor->visitNothing($this);
    }

    public function orElse(callable $f, array $args) {

        // Since we don't know if $f will throw an exception, we wrap the call
	// in a try/catch. The result wiil be Left if there's an exception.
	try {
	    $maybeResult = call_user_func_array($f, $args);
	} catch (\Exception $e) {
            // Unfortunately, we lose the error context. That's just the nature
            // of using Maybe in a language that has exceptions.
	    $maybeResult = Maybe::nothing();
	}

	return $maybeResult;
    }

    public function isNothing() {
	return true;
    }
}
