<?php

namespace TMciver\Functional\Test;

use TMciver\Functional\Maybe\MaybeVisitor;

// This MaybeVisitor converts Just/Nothing to strings. In the case of Just, it
// casts the contained value to a string; in the case of Nothing, it just
// returns the string "Nothing!".
class ToStringMaybeVisitor implements MaybeVisitor {

    public function visitJust($just) {
	return (string)$just->get();
    }

    public function visitNothing($nothing) {
	return "Nothing!";
    }
}
