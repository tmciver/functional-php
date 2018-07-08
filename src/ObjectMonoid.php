<?php

namespace TMciver\Functional;

trait ObjectMonoid {
    use ObjectSemiGroup;

    /**
     * @return The identity element.
     */
    abstract function identity();
}
