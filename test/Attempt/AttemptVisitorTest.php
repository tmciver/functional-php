<?php

use PHPUnit\Framework\TestCase;
use TMciver\Functional\Attempt\Attempt;
use TMciver\Functional\Attempt\AttemptToMaybe;
use TMciver\Functional\Maybe\Maybe;

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
