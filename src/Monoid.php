<?php

namespace TMciver\Functional;

trait Monoid {
    use SemiGroup;

    /**
     * @return The identity element.
     */
    abstract function identity();
}