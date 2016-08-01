<?php

use TMciver\Functional\Maybe\Maybe;
use TMciver\Functional\Either\Either;
use TMciver\Functional\Maybe\MaybeToEither;
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

    public function testMaybeToEitherForJust() {

        $just = Maybe::fromValue("Hello");
        $conversionVisitor = new MaybeToEither();
        $actualEither = $just->accept($conversionVisitor);
        $expectedEither = Either::fromValue("Hello");

        $this->assertEquals($expectedEither, $actualEither);
    }

    public function testMaybeToEitherForNothing() {

        $nothing = Maybe::nothing("I am Error!");
        $conversionVisitor = new MaybeToEither("Hey, I was Nothing but now I'm Left!");
        $actualEither = $nothing->accept($conversionVisitor);
        $expectedEither = Either::left("Hey, I was Nothing but now I'm Left!");

        $this->assertEquals($expectedEither, $actualEither);
    }
}
