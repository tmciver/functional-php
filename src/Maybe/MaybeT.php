<?php

namespace PhatCats\Maybe;

use PhatCats\Typeclass\Monad;
use PhatCats\ObjectTypeclass\ObjectFunctor;
use PhatCats\AssociativeArray;
use PhatCats\PartialFunction;

class MaybeT {
  use ObjectFunctor;

  private $wrapper;

  public function __construct($wrapper) {
    $this->wrapper = $wrapper;
  }

  public function map(callable $f) {
	return new MaybeT($this->wrapper->map(function ($maybe) use ($f) {
      return $maybe->map($f);
	}));
  }

  public function fail(Monad $m, $msg) {
    return new MaybeT($m->pure(Maybe::nothing()));
  }

  /**
   * Note that this flatMap signature is different than that defined in
   * ObjectMonad and that's why MaybeT no longer uses that trait. This is due to
   * the need to have a Monad instance for the wrapping type available.
   *
   * TODO Consider taking into the constructor the monad for the inner monad
   * instead of passing it here. That way `MaybeT` could use the `ObjectMonad`
   * trait again.
   */
  public function flatMap(Monad $m, callable $f) {
    $newObjectMonad = $m->flatMap($this->wrapper, function ($maybe) use ($m, $f) {
      if ($maybe->isNothing()) {
		$newObjectMonad = $m->pure($maybe);
      } else {
		$newMaybeT = $f($maybe->get());
		$newObjectMonad = $newMaybeT->wrapper;
      }

      return $newObjectMonad;
	});

	return new MaybeT($newObjectMonad);
  }

  public function apply(Monad $m, $fa) {
    return is_null($fa) ?
      $this->applyNoArg() :
      $this->applyToArg($m, $fa);
  }

  protected function applyNoArg() {
    return $this->map(function ($f) {
	  return call_user_func($f);
	});
  }

  protected function applyToArg(Monad $m, $fa) {
    return $this->flatMap($m, function($f) use ($fa) {
	  // Wrap the applicative value in a PartialFunction,
	  // if it is not already.
	  $pf = $f instanceof PartialFunction ? $f : new PartialFunction($f);

	  return $fa->map($pf);
	});
  }

  public function pure($val) {
	return new MaybeT($this->wrapper->pure(Maybe::fromValue($val)));
  }
}
