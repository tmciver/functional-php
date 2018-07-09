<?php

namespace TMciver\Functional\ObjectTypeclasses;

trait ObjectSemiGroup {

    /**
     * @param $appendee object to be appended to this one.
     * @return Result of appending this object with appendee. Should have same
     *         type as this object.
     */
    abstract function append($appendee);
}
