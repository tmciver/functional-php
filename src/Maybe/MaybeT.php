<?php

namespace TMciver\Functional\Maybe;

use TMciver\Functional\Monad;

class MaybeT {
    use Monad;

    private $monad;

    public function __construct($monad) {
	$this->monad = $monad;
    }

    public function fmap(callable $f) {
	return new MaybeT($this->monad->fmap(function ($maybe) use ($f) {
	    return $maybe->fmap($f);
	}));
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

    public function pure($val) {
	return new MaybeT($this->monad->pure(new Just($val)));
    }

    public function getMonad() {
	return $this->monad;
    }
}
