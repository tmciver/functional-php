<?php

namespace TMciver\Functional;

class Nothing extends Maybe {

    private $message;

    public function __construct($message = '') {
	$this->message = $message;
    }

    public function fmap(Callable $f) {
	return $this;
    }

    public function bind(callable $f) {
	return $this;
    }

    public function orElse(callable $f, array $args) {
	return call_user_func_array($f, $args);
    }

    public function getMessage() {
	return $this->message;
    }

    public function isNothing() {
	return true;
    }
}
