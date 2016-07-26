<?php

namespace TMciver\Functional\Maybe;

use TMciver\Functional\AssociativeArray;

class MaybeArray extends AssociativeArray {

    public function traverse(callable $f) {

        $vals = [];
        $foundNothing = false;
        foreach ($this->array as $maybe) {
            if ($maybe->isNothing()) {
                $foundNothing = true;
                break;
            } else {
                $newMaybe = $f($maybe);
                if ($newMaybe->isNothing()) {
                    $foundNothing = true;
                    break;
                } else {
                    $vals[] = $newMaybe->get();
                }
            }
        }

        if ($foundNothing) {
            $result = Maybe::nothing();
        } else {
            $result = Maybe::fromValue($vals);
        }

        return $result;
    }
}
