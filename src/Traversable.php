<?php

namespace TMciver\Functional;

trait Traversable {

    /**
     * @param $f A callable of a single parameter that returns a "wrapped" value.
     * @return A single "wrapped" array whose elements are the same type as
     *         those wrapped by the return value of $f.
     */
    abstract function traverse(callable $f);

    /**
     * @return A single "wrapped" array whose elements are the same type as
     *         those wrapped by the elements of the input array.
     */
    function sequence() {
        $id = function ($i) { return $i; };
        return $this->traverse($id);
    }
}
