<?php

namespace TMciver\Functional\Either;

use TMciver\Functional\Monad;
use TMciver\Functional\Monoid;
use TMciver\Functional\Either\Right;

abstract class Either {
    use Monoid, Monad;

    public function pure($val) {
	return new Right($val);
    }

    public function identity() {
        return new Left('');
    }

    /**
     * Function for doing double dispatch from Right::append.
     */
    protected abstract function appendRight($right);

    public abstract function getOrElse($default);

    /**
     * Calls the Callable $f (or not) in a sub-class-specific way.
     * @param Callable $f the Callable to (optionally) call.
     * @param array $args The arguments to pass to the Callable $f. The array
     * length must be equal to the number of arguments expected by $f.
     * @return An instance of Maybe.
     */
    public abstract function orElse(callable $f, array $args);

    /**
     * @return True if this object is an instance of the Left class; false
     * otherwise.
     */
    public abstract function isLeft();

    public abstract function accept($eitherVisitor);
}
