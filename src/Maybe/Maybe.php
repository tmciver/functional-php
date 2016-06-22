<?php

namespace TMciver\Functional\Maybe;

use TMciver\Functional\Monad;
use TMciver\Functional\Maybe\Just;

abstract class Maybe {
    use Monad;

    public function pure($val) {
	return new Just($val);
    }

    /**
     * Calls the Callable $f (or not) in a sub-class-specific way.
     * @param Callable $f the Callable to (optionally) call.
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
