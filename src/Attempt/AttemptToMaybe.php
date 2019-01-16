<?php

namespace PhatCats\Attempt;

use PhatCats\Maybe\Maybe;

class AttemptToMaybe implements AttemptVisitor {

    function visitFailure($failure) {
        return Maybe::nothing();
    }

    function visitSuccess($success) {
        return Maybe::fromValue($success->get());
    }
}