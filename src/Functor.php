<?php

namespace TMciver\Functional;

interface Functor {

    /**
     * @param callable $f A function of one argument whose type is the type of
     * value contained in the functor.
     * @return An instance of Functor whose type is the same as this Functor.
     */
    function fmap(callable $f);
}