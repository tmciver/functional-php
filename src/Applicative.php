<?php

namespace TMciver\Functional;

use TMciver\Functional\Functor;

trait Applicative {
    use Functor;

    /**
     * @param A value to be put into a minimal context.
     * @return The given value in a context.
     */
    abstract function pure($val);

    /**
     * The __invoke magic method allows the Applicative to be called like a
     * normal function but whose implementation gives it the Applicative
     * behavior. The implementation of __invoke should handle being called with
     * zero or more arguments and "do the right thing."
     * @return The value returned by applying the function in a context to one
     *         or more values in a context. This value is itself put into a
     *         context: the same context as this one.
     */
    abstract function __invoke();
}
