<?php

namespace TMciver\Functional;

trait ObjectTraversable {

    /**
     * @param $f A callable of a single parameter that returns some Monad.
     * @param $monad (Monad) An instance of the desired context. This Monad
     *        should be of the same type as that returned by $f. This Monad can
     *        be any value of a given Monad (e.g., can be `Nothing` or `Just` in
     *        the case that a `Maybe` is desired); it is only used so that the
     *        appropriate implementation of `pure` may be called.
     * @return A single "wrapped" array whose elements are the same type as
     *         those wrapped by the return value of $f.
     */
    abstract function traverse(callable $f, $monad);

    /**
     * @param $monad (Monad) An instance of the desired context. This Monad
     *        should be of the same type as the implementor of `sequence`. This
     *        Monad can be any value of a given Monad (e.g., can be `Nothing`
     *        or `Just` in the case that a `Maybe` is desired); it is only used
     *        so that the appropriate implementation of `pure` may be called.
     * @return A single "wrapped" array whose elements are the same type as
     *         those wrapped by the elements of the input array.
     */
    function sequence($monad) {
        $id = function ($i) { return $i; };
        return $this->traverse($id, $monad);
    }
}
