<?php

namespace TMciver\Functional;

abstract class Traversable {

    /**
     * @param $f A callable of a single parameter that returns a "wrapped" value.
     * @param $array A PHP array of "wrapped" values (the "wrapper" type is the
     *        same as that returned by $f).
     * @return A single "wrapped" array whose elements are the same type as
     *         those wrapped by the return value of $f.
     */
    abstract function traverse(callable $f, $array);

    /**
     * @param $array A PHP array of "wrapped" values
     * @return A single "wrapped" array whose elements are the same type as
     *         those wrapped by the elements of the input array.
     */
    function sequence($array) {
        $id = function ($i) { return $i; };
        return $this->traverse($id, $array);
    }
}
