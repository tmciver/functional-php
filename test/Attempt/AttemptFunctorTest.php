<?php

use PHPUnit\Framework\TestCase;
use TMciver\Functional\Attempt\Attempt;

class AttemptFunctorTest extends TestCase {

    public function testIdentityLaw() {

	$id = function ($val) { return $val; };
	$tryVal = Attempt::fromValue("Hello");
	$mappedAttemptVal = $tryVal->map($id);

	$this->assertEquals($tryVal, $mappedAttemptVal);
    }

    public function testMapSuccess() {

	$toUpper = function ($str) { return strtoupper($str); };
	$tryStr = Attempt::fromValue("hello");
	$mappedAttemptStr = $tryStr->map($toUpper);
	$expectedAttemptStr = Attempt::fromValue("HELLO");

	$this->assertEquals($mappedAttemptStr, $expectedAttemptStr);
    }

    public function testMapFailure() {

	$toUpper = function ($str) { return strtoupper($str); };
	$tryStr = Attempt::failure("We have a problem!");
	$mappedAttemptStr = $tryStr->map($toUpper);

	$this->assertInstanceOf('TMciver\Functional\Attempt\Failure', $mappedAttemptStr);
    }
}
