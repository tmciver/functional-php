<?php

use PHPUnit\Framework\TestCase;
use PhatCats\Attempt\Attempt;

class AttemptApplicativeTest extends TestCase {

    public function testApplicativeForNoArgs() {

        // The function
        $tryFn = Attempt::fromValue(function() { return 42; });

        // Call the function
        $tryResult = $tryFn();

        $expectedResult = Attempt::fromValue(42);

        $this->assertEquals($expectedResult, $tryResult);
    }

    public function testApplicativeForMultipleArgsNoFailures() {

        // The function
        $tryFn = Attempt::fromValue('substr');

        // The args
        $tryStr = Attempt::fromValue('Hello world!');
        $tryStart = Attempt::fromValue(6);
        $tryLength = Attempt::fromValue(5);

        // Apply the function applicatively
        $tryResult = $tryFn($tryStr, $tryStart, $tryLength);

        $expectedResult = Attempt::fromValue('world');

        $this->assertEquals($expectedResult, $tryResult);
    }

    public function testApplicativeForMultipleArgsSomeFailures() {

        // The function
        $tryFn = Attempt::fromValue('substr');

        // The args
        $tryStr = Attempt::fromValue('Hello world!');
        $tryStart = Attempt::failure('I am Error!');
        $tryLength = Attempt::fromValue(5);

        // Apply the function applicatively
        $tryResult = $tryFn($tryStr, $tryStart, $tryLength);

        $expectedResult = $tryStart;

        $this->assertEquals($expectedResult, $tryResult);
    }

    public function testApplicativeForFailure() {

        // The function
        $tryFn = Attempt::failure('There is no function!');

        // The args
        $tryStr = Attempt::fromValue('Hello world!');
        $tryStart = Attempt::fromValue(6);
        $tryLength = Attempt::fromValue(5);

        // Apply the function applicatively
        $tryResult = $tryFn($tryStr, $tryStart, $tryLength);

        $expectedResult = $tryFn;

        $this->assertEquals($expectedResult, $tryResult);
    }
}
