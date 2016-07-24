<?php

namespace TMciver\Functional\Maybe;

use TMciver\Functional\Monad;
use TMciver\Functional\Monoid;
use TMciver\Functional\Maybe\Just;

abstract class Maybe {
    use Monoid, Monad;

    public function pure($val) {
	return new Just($val);
    }

    public function identity() {
        return new Nothing();
    }

    /**
     * Function for doing double dispatch from Just::append.
     */
    protected abstract function appendJust($just);

    /**
     * @param $default The default value to return if this Maybe is an instance
     * of Nothing.
     * @return The contained value if this Maybe is an instance of Just, or the
     * default value otherwise.
     */
    public abstract function getOrElse($default);

    /**
     * Calls the Callable $f (or not) in a sub-class-specific way.
     * @param Callable $f the Callable to (optionally) call. This callable
     * should be a function of a number of arguments equal to the number of
     * array elements given in $args and should return a sub-class of Maybe.
     * @param array $args The arguments to pass to the Callable $f. The array
     * length must be equal to the number of arguments expected by $f.
     * @return An instance of Maybe.
     */
    abstract function orElse(callable $f, array $args);

    /**
     * @return True if this object is an instance of the Nothing class; false
     * otherwise.
     */
    abstract function isNothing();

    abstract function accept($maybeVisitor);
}
