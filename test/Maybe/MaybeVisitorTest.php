<?php

use PHPUnit\Framework\TestCase;
use PhatCats\Maybe\Maybe;
use PhatCats\Either\Either;
use PhatCats\Maybe\MaybeToEither;
use PhatCats\Test\Maybe\ToStringMaybeVisitor;

class MaybeVisitorTest extends TestCase {

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
