<?php

namespace TMciver\Functional\Either;

use TMciver\Functional\Either\Either;

class Left extends Either {

    private $val;

    public function __construct($val) {
	$this->val = $val;
    }

    public function getOrElse($default) {
        return $default;
    }

    public function map(Callable $f) {
	return $this;
    }

    public function bind(callable $f) {
	return $this;
    }

    public function accept($eitherVisitor) {
	return $eitherVisitor->visitLeft($this);
    }

    public function orElse(callable $f, array $args) {
	return call_user_func_array($f, $args);
    }

    public function get() {
	return $this->val;
    }

    public function isLeft() {
	return true;
    }
}
