<?php

namespace TMciver\Functional\Maybe;

class Nothing extends Maybe {

    public function getOrElse($default) {
        return $default;
    }

    public function map(Callable $f) {
	return $this;
    }

    public function concatMap(callable $f) {
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
	return call_user_func_array($f, $args);
    }

    public function isNothing() {
	return true;
    }
}
