<?php

namespace TMciver\Functional\Maybe;

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

    public function __invoke() {
        return $this;
    }

    public function append($appendee) {
        return $appendee;
    }

    protected function appendJust($just) {
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
