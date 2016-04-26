<?php

namespace TMciver\Functional;

use TMciver\Functional\Applicative;

interface Monad extends Applicative {

    /**
     * @param callable $f A function of one argument whose type is the type of
     * value contained in the monad. The return type of $f should be the same as
     * this monad, i.e., if this monad is a Maybe, then the return type of $f
     * should be a Maybe.
     * @return The value returned by $f.
     */
    function bind(callable $f);
}
