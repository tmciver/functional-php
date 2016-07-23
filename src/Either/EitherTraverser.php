<?php

namespace TMciver\Functional\Either;

use TMciver\Functional\Traversable;

class EitherTraverser extends Traversable {

    public function traverse(callable $f, $array) {

        $vals = [];
        $foundLeft = false;
        foreach ($array as $either) {
            if ($either->isLeft()) {
                $foundLeft = true;
                break;
            } else {
                $newEither = $f($either);
                if ($newEither->isLeft()) {
                    $foundLeft = true;
                    break;
                } else {
                    $vals[] = $newEither->get();
                }
            }
        }

        if ($foundLeft) {
            $result = new Left('');
        } else {
            $result = new Right($vals);
        }

        return $result;
    }
}
