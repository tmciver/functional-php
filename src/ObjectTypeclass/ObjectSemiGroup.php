<?php

namespace PhatCats\ObjectTypeclass;

use PhatCats\Typeclass\SemiGroup;

trait ObjectSemiGroup {

    /**
     * @param $appendee object to be appended to this one.
     * @param $innerSemigroup The semigroup to use to append values wrapped by
     *        this semi-group. May not be applicable for all semi-groups (e.g.,
     *        LinkedList).
     * @return Result of appending this object with appendee. Should have same
     *         type as this object.
     */
    abstract function append($appendee, SemiGroup $innerSemigroup);
}
