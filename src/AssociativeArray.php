<?php

namespace TMciver\Functional;

// Just a wrapper around the native PHP array to allow for cool FP goodness.
class AssociativeArray {
    use Traversable;

    protected $array;

    public Function __construct($array) {
        $this->array = $array;
    }

    // This can be generically implemented for all AssociativeArrays when we
    // have an implementation for Applicative.
    public function traverse(callable $f) {
        throw new \Exception('Not yet supported.');
    }
}