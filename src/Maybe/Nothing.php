<?php

namespace TMciver\Functional\Maybe;

class Nothing extends Maybe {

    public function fmap(Callable $f) {
	return $this;
    }

    public function bind(callable $f) {
	return $this;
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
