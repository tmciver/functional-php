<?php

namespace PhatCats\Maybe;

use PhatCats\Maybe\MaybeVisitor;
use PhatCats\Either\Either;

class MaybeToEither implements MaybeVisitor {

    private $leftVal;

    public function __construct($leftVal = 'There was no value found.') {
        $this->leftVal = $leftVal;
    }

    public function visitJust($just) {
	return Either::fromValue($just->get());
    }

    public function visitNothing($nothing) {
	return Either::left($this->leftVal);
    }
}
