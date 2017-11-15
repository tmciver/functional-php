<?php

namespace TMciver\Functional;

use TMciver\Functional\Applicative;

trait Monad {
  //use Applicative;

    /**
     * @param callable $f A function of one argument whose type is the type of
     * value contained in the monad. The return type of $f should be the same as
     * this monad, i.e., if this monad is a Maybe, then the return type of $f
     * should be a Maybe.
     * @return The value returned by $f.
     */
    abstract function flatMap(callable $f);

    /**
     * Removes one layer of structure.
     * @return The type of the return value should be the same type as this Monad.
     */
    function join() {

	// the identity function. Can you believe PHP doesn't have one in the
	// standard lib?
	$id = function ($x) { return $x; };

	return $this->flatMap($id);
    }
}
