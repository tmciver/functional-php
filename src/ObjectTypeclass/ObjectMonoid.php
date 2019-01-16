<?php

namespace PhatCats\ObjectTypeclass;

trait ObjectMonoid {
    use ObjectSemiGroup;

    /**
     * @return The identity element.
     */
    abstract function identity();
}
