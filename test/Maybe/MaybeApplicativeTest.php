<?php

use PHPUnit\Framework\TestCase;
use TMciver\Functional\Maybe\Maybe;

class MaybeApplicativeTest extends TestCase {

    public function testApplicativeForNoArgs() {

        // The function
        $maybeFn = Maybe::fromValue(function() { return 42; });

        // Call the function
        $maybeResult = $maybeFn();

        $expectedResult = Maybe::fromValue(42);

        $this->assertEquals($expectedResult, $maybeResult);
    }

    public function testApplicativeForMultipleArgsNoNothings() {

        // The function
        $maybeFn = Maybe::fromValue('substr');

        // The args
        $maybeStr = Maybe::fromValue('Hello world!');
        $maybeStart = Maybe::fromValue(6);
        $maybeLength = Maybe::fromValue(5);

        // Apply the function applicatively
        $maybeResult = $maybeFn($maybeStr, $maybeStart, $maybeLength);

        $expectedResult = Maybe::fromValue('world');

        $this->assertEquals($expectedResult, $maybeResult);
    }

    public function testApplicativeForMultipleArgsSomeNothings() {

        // The function
        $maybeFn = Maybe::fromValue('substr');

        // The args
        $maybeStr = Maybe::fromValue('Hello world!');
        $maybeStart = Maybe::nothing('I am Error!');
        $maybeLength = Maybe::fromValue(5);

        // Apply the function applicatively
        $maybeResult = $maybeFn($maybeStr, $maybeStart, $maybeLength);

        $expectedResult = $maybeStart;

        $this->assertEquals($expectedResult, $maybeResult);
    }

    public function testApplicativeForNothing() {

        // The function
        $maybeFn = Maybe::nothing('There is no function!');

        // The args
        $maybeStr = Maybe::fromValue('Hello world!');
        $maybeStart = Maybe::fromValue(6);
        $maybeLength = Maybe::fromValue(5);

        // Apply the function applicatively
        $maybeResult = $maybeFn($maybeStr, $maybeStart, $maybeLength);

        $expectedResult = $maybeFn;

        $this->assertEquals($expectedResult, $maybeResult);
    }
}
