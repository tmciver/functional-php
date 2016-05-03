<?php

use TMciver\Functional\Maybe\Just;
use TMciver\Functional\Maybe\Nothing;
use TMciver\Functional\Test\ToStringMaybeVisitor;

class MaybeVisitorTest extends PHPUnit_Framework_TestCase {

    public function testJustVisitor() {

	$maybeVisitor = new ToStringMaybeVisitor();
	$just = new Just(123);
	$justAsString = $just->accept($maybeVisitor);

	$this->assertEquals($justAsString, "123");
    }

    public function testNothingVisitor() {

	$maybeVisitor = new ToStringMaybeVisitor();
	$nothing = new Nothing("Hello!");
	$nothingAsString = $nothing->accept($maybeVisitor);

	$this->assertEquals($nothingAsString, "Hello!");
    }
}
