<?php

use PHPUnit\Framework\TestCase;
use TMciver\Functional\Attempt\Attempt;

class AttemptMonadTest extends TestCase {

	public function testPure() {

		// using `pure` in this lib requres having a reference to an object of
		// the desired type, so here, we'll just create a Failure Attempt.
		$try = Attempt::failure('');

		// create a wrapped val
		$wrappedVal = $try->pure("Hello!");

		$this->assertInstanceOf('TMciver\Functional\Attempt\Success', $wrappedVal);
		$this->assertEquals($wrappedVal->get(), "Hello!");
	}

	public function testFlatMapForSuccess() {

		$tryInt = Attempt::fromValue(1);
		$tryIntPlusOne = $tryInt->flatMap(function ($i) {
			return Attempt::fromValue($i + 1);
		});

		$this->assertEquals($tryIntPlusOne->get(), 2);
	}

	public function testFlatMapForFailure() {

		$tryInt = Attempt::failure("Error!");
		$tryIntPlusOne = $tryInt->flatMap(function ($i) {
			return Attempt::fromValue($i + 1);
		});

		$this->assertInstanceOf('TMciver\Functional\Attempt\Failure', $tryIntPlusOne);
	}
}
