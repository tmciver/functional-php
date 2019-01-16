<?php

use PHPUnit\Framework\TestCase;
use PhatCats\Attempt\Attempt;
use PhatCats\Attempt\AttemptToMaybe;
use PhatCats\Maybe\Maybe;

class AttemptVisitorTest extends TestCase {

    public function testAttemptToMaybeForSuccess() {

        $success = Attempt::fromValue("Hello");
        $conversionVisitor = new AttemptToMaybe();
        $actualMaybe = $success->accept($conversionVisitor);
        $expectedMaybe = Maybe::fromValue("Hello");

        $this->assertEquals($expectedMaybe, $actualMaybe);
    }

    public function testAttemptToMaybeForFailure() {

        $failure = Attempt::failure("I am Error!");
        $conversionVisitor = new AttemptToMaybe();
        $actualMaybe = $failure->accept($conversionVisitor);
        $expectedMaybe = Maybe::nothing();

        $this->assertEquals($expectedMaybe, $actualMaybe);
    }
}
