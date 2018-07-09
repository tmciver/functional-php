<?php

namespace TMciver\Functional\ObjectTypeclasses;

trait ObjectMonoid {
    use ObjectSemiGroup;

    /**
     * @return The identity element.
     */
    abstract function identity();
}
