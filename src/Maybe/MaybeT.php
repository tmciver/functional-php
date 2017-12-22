<?php

namespace TMciver\Functional\Maybe;

use TMciver\Functional\Monad;
use TMciver\Functional\AssociativeArray;
use TMciver\Functional\PartialFunction;

class MaybeT {
    use Monad;

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
	$newMonad = $this->monad->flatMap(function ($maybe) use ($f) {
	    if ($maybe->isNothing()) {
		$newMonad = $this->monad->pure($maybe);
	    } else {
		$newMaybeT = $f($maybe->get());
		$newMonad = $newMaybeT->monad;
	    }

	    return $newMonad;
	});

	return new MaybeT($newMonad);
    }

    public function apply($applicativeArgument = null) {

      if (is_null($applicativeArgument)) {
	$result = $this->map(function ($f) {
	    return call_user_func($f);
	  });
      } else {
	$result = $this->flatMap(function($f) use ($applicativeArgument) {
	    // Wrap the applicative value in a PartialFunction,
	    // if it is not already.
	    $pf = $f instanceof PartialFunction ? $f : new PartialFunction($f);

	    return $applicativeArgument->map($pf);
	  });
      }

      return $result;
    }

    public function pure($val) {
	return new MaybeT($this->monad->pure(Maybe::fromValue($val)));
    }
}
