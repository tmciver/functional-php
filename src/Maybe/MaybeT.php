<?php

namespace TMciver\Functional\Maybe;

class MaybeT {

    private $monad;

    public function __construct($monad) {
	$this->monad = $monad;
    }

    public function bind(callable $f) {
	$newMonad = $this->monad->bind(function ($maybe) use ($f) {
	    if ($maybe->isNothing()) {
		$newMonad = $this->monad->pure($maybe);
	    } else {
		$newMaybeT = $f($maybe->get());
		$newMonad = $newMaybeT->getMonad();
	    }

	    return $newMonad;
	});

	return new MaybeT($newMonad);
    }

    public function getMonad() {
	return $this->monad;
    }
}
