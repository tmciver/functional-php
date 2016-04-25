<?php

namespace TMciver\Functional;

class Just implements Maybe {

    private $val;

    public function __construct($val) {
	$this->val = $val;
    }

    public function bind(Callable $f) {
	return $f($this->val);
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
