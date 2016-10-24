<?php

use TMciver\Functional\Either\Either;

class EitherApplicativeTest extends PHPUnit_Framework_TestCase {

    public function testApplicativeForNoArgs() {

        // The function
        $eitherFn = Either::fromValue(function() { return 42; });

        // Call the function
        $eitherResult = $eitherFn();

        $expectedResult = Either::fromValue(42);

        $this->assertEquals($expectedResult, $eitherResult);
    }

    public function testApplicativeForMultipleArgsNoLefts() {

        // The function
        $eitherFn = Either::fromValue('substr');

        // The args
        $eitherStr = Either::fromValue('Hello world!');
        $eitherStart = Either::fromValue(6);
        $eitherLength = Either::fromValue(5);

        // Apply the function applicatively
        $eitherResult = $eitherFn($eitherStr, $eitherStart, $eitherLength);

        $expectedResult = Either::fromValue('world');

        $this->assertEquals($expectedResult, $eitherResult);
    }

    public function testApplicativeForMultipleArgsSomeLefts() {

        // The function
        $eitherFn = Either::fromValue('substr');

        // The args
        $eitherStr = Either::fromValue('Hello world!');
        $eitherStart = Either::left('I am Error!');
        $eitherLength = Either::fromValue(5);

        // Apply the function applicatively
        $eitherResult = $eitherFn($eitherStr, $eitherStart, $eitherLength);

        $expectedResult = $eitherStart;

        $this->assertEquals($expectedResult, $eitherResult);
    }

    public function testApplicativeForLeft() {

        // The function
        $eitherFn = Either::left('There is no function!');

        // The args
        $eitherStr = Either::fromValue('Hello world!');
        $eitherStart = Either::fromValue(6);
        $eitherLength = Either::fromValue(5);

        // Apply the function applicatively
        $eitherResult = $eitherFn($eitherStr, $eitherStart, $eitherLength);

        $expectedResult = $eitherFn;

        $this->assertEquals($expectedResult, $eitherResult);
    }
}
