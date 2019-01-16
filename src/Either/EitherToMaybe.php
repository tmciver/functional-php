<?php

namespace PhatCats\Either;

use PhatCats\Maybe\Maybe;

class EitherToMaybe implements EitherVisitor {

    function visitLeft($left) {
        return Maybe::nothing();
    }

    function visitRight($right) {
        return Maybe::fromValue($right->get());
    }
}