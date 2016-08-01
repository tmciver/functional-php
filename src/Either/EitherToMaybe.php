<?php

namespace TMciver\Functional\Either;

use TMciver\Functional\Maybe\Maybe;

class EitherToMaybe implements EitherVisitor {

    function visitLeft($left) {
        return Maybe::nothing();
    }

    function visitRight($right) {
        return Maybe::fromValue($right->get());
    }
}