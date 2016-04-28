<?php

namespace TMciver\Functional;

use TMciver\Functional\Applicative;

trait Monad {
    use Applicative;

    /**
     * @param callable $f A function of one argument whose type is the type of
     * value contained in the monad. The return type of $f should be the same as
     * this monad, i.e., if this monad is a Maybe, then the return type of $f
     * should be a Maybe.
     * @return The value returned by $f.
     */
    function bind(callable $f) {
	return $this->fmap($f)->join();
    }

    /**
     * Removes one layer of structure.
     * @return The type of the return value should be the same type as this Monad.
     */
    abstract function join();
}
