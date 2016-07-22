<?php

namespace TMciver\Functional\Maybe;

use TMciver\Functional\Traversable;

class MaybeTraverser extends Traversable {

    public function traverse(callable $f, $array) {

        $vals = [];
        $foundNothing = false;
        foreach ($array as $maybe) {
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
            $result = new Nothing();
        } else {
            $result = new Just($vals);
        }

        return $result;
    }
}
