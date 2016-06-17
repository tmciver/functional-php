<?php

namespace TMciver\Functional\Either;

use TMciver\Functional\Either\Either;

class Left extends Either {

    private $message;

    public function __construct($message) {
	$this->message = $message;
    }

    public function fmap(Callable $f) {
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

    public function isLeft() {
	return true;
    }
}
