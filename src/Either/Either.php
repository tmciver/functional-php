<?php

namespace TMciver\Functional\Either;

use TMciver\Functional\Monad;
use TMciver\Functional\Either\Right;

abstract class Either {
    use Monad;

    public function pure($val) {
	return new Right($val);
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
     * @return True if this object is an instance of the Left class; false
     * otherwise.
     */
    abstract function isLeft();

    abstract function accept($eitherVisitor);
}
