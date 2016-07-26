<?php

use TMciver\Functional\Maybe\Maybe;
use TMciver\Functional\Test\Maybe\ToStringMaybeVisitor;

class MaybeVisitorTest extends PHPUnit_Framework_TestCase {

    public function testJustVisitor() {

	$maybeVisitor = new ToStringMaybeVisitor();
	$just = Maybe::fromValue(123);
	$justAsString = $just->accept($maybeVisitor);

	$this->assertEquals($justAsString, "123");
    }

    public function testNothingVisitor() {

	$maybeVisitor = new ToStringMaybeVisitor();
	$nothing = Maybe::nothing();
	$nothingAsString = $nothing->accept($maybeVisitor);

	$this->assertEquals($nothingAsString, "Nothing!");
    }
}
