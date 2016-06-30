<?php

use TMciver\Functional\MonadTransformer;
use TMciver\Functional\Maybe\Just;
use TMciver\Functional\Maybe\Nothing;
use TMciver\Functional\Either\Left;
use TMciver\Functional\Either\Right;
use TMciver\Functional\Either\EitherVisitor;
use TMciver\Functional\Test\ToStringMaybeVisitor;

class EitherMaybeMonadTransformerVisitorTest extends PHPUnit_Framework_TestCase {

    private $monadTransformerVisitor;

    public function __construct() {
	$this->monadTransformerVisitor = new EitherMaybeTToStringVisitor(new ToStringMaybeVisitor());
    }

    public function testLeftVisitor() {

	// create a MonadTransformer
	$mt = new MonadTransformer(new Left("I am Error."));

	// Use the visitor to convert the MonadTransformer to a string
	$mtString = $mt->accept($this->monadTransformerVisitor);

	$this->assertEquals($mtString, "I am Error.");
    }

    public function testRightNothingVisitor() {

	// create a MonadTransformer
	$mt = new MonadTransformer(new Right(new Nothing()));

	// Use the visitor to convert the MonadTransformer to a string
	$mtString = $mt->accept($this->monadTransformerVisitor);

	$this->assertEquals($mtString, "Nothing!");
    }

    public function testRightJustVisitor() {

	// create a MonadTransformer
	$mt = new MonadTransformer(new Right(new Just(5.0)));

	// Use the visitor to convert the MonadTransformer to a string
	$mtString = $mt->accept($this->monadTransformerVisitor);

	$this->assertEquals($mtString, "5.0");
    }
}

/**
 * A visitor that converts an Either Maybe MonadTransformer to a string.
 */
class EitherMaybeTToStringVisitor implements EitherVisitor {

    private $maybeVisitor;

    public function __construct($maybeVisitor) {
	$this->maybeVisitor = $maybeVisitor;
    }

    public function visitLeft($left) {
	return (string)$left->get();
    }

    public function visitRight($right) {
	return $right->get()->accept($this->maybeVisitor);
    }
}
