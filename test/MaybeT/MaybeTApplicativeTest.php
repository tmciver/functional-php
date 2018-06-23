<?php

use PHPUnit\Framework\TestCase;
use TMciver\Functional\Maybe\MaybeT;
use TMciver\Functional\Either\Either;

class MaybeTApplicativeTest extends TestCase {

    private $maybet;

    public function setUp() {
        $this->maybet = new MaybeT(Either::left(''));
    }

    public function testApplicativeForNoArgs() {

        // The function
        $maybetFn = $this->maybet->pure(function() { return 42; });

        // Call the function
        $maybetResult = $maybetFn();

        $expectedResult = $this->maybet->pure(42);

        $this->assertEquals($expectedResult, $maybetResult);
    }

    public function testApplicativeForMultipleArgsNoNothings() {

        // The function
        $maybetFn = $this->maybet->pure('substr');

        // The args
        $maybetStr = $this->maybet->pure('Hello world!');
        $maybetStart = $this->maybet->pure(6);
        $maybetLength = $this->maybet->pure(5);

        // Apply the function applicatively
        $maybetResult = $maybetFn($maybetStr, $maybetStart, $maybetLength);

        $expectedResult = $this->maybet->pure('world');

        $this->assertEquals($expectedResult, $maybetResult);
    }

    public function testApplicativeForMultipleArgsSomeNothings() {

        // The function
        $maybetFn = $this->maybet->pure('substr');

        // The args
        $maybetStr = $this->maybet->pure('Hello world!');
        $maybetStart = $this->maybet->pure(null); 
        $maybetLength = $this->maybet->pure(5);

        // Apply the function applicatively
        $maybetResult = $maybetFn($maybetStr, $maybetStart, $maybetLength);

        $expectedResult = $maybetStart;

        $this->assertEquals($expectedResult, $maybetResult);
    }

    public function testApplicativeForNothing() {

        // The function
        $maybetFn = $this->maybet->pure(null); 

        // The args
        $maybetStr = $this->maybet->pure('Hello world!');
        $maybetStart = $this->maybet->pure(6);
        $maybetLength = $this->maybet->pure(5);

        // Apply the function applicatively
        $maybetResult = $maybetFn($maybetStr, $maybetStart, $maybetLength);

        $expectedResult = $maybetFn;

        $this->assertEquals($expectedResult, $maybetResult);
    }
}
