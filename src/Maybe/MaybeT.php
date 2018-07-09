<?php

namespace TMciver\Functional\Maybe;

use TMciver\Functional\ObjectTypeclasses\ObjectMonad;
use TMciver\Functional\AssociativeArray;
use TMciver\Functional\PartialFunction;

class MaybeT {
    use ObjectMonad;

    private $monad;

    public function __construct($monad) {
	$this->monad = $monad;
    }

    public function map(callable $f) {
	return new MaybeT($this->monad->map(function ($maybe) use ($f) {
	    return $maybe->map($f);
	}));
    }

    public function fail($msg) {
        return new MaybeT($this->monad->pure(Maybe::nothing()));
    }

    public function flatMap(callable $f) {
	$newObjectMonad = $this->monad->flatMap(function ($maybe) use ($f) {
	    if ($maybe->isNothing()) {
		$newObjectMonad = $this->monad->pure($maybe);
	    } else {
		$newMaybeT = $f($maybe->get());
		$newObjectMonad = $newMaybeT->monad;
	    }

	    return $newObjectMonad;
	});

	return new MaybeT($newObjectMonad);
    }

    protected function applyNoArg() {
      return $this->map(function ($f) {
	  return call_user_func($f);
	});
    }

    protected function applyToArg($applicativeArgument) {
      return $this->flatMap(function($f) use ($applicativeArgument) {
	  // Wrap the applicative value in a PartialFunction,
	  // if it is not already.
	  $pf = $f instanceof PartialFunction ? $f : new PartialFunction($f);

	  return $applicativeArgument->map($pf);
	});
    }

    public function pure($val) {
	return new MaybeT($this->monad->pure(Maybe::fromValue($val)));
    }
}
