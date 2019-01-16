<?php

use PHPUnit\Framework\TestCase;
use PhatCats\Maybe\Maybe;

class HeadTest extends TestCase {

    public function testHeadOnNonEmptyArray() {

	$a = ['apples', 'oranges', 'bananas'];
	$h = $this->head($a);
	$expectedResult = Maybe::fromValue('apples');

	$this->assertEquals($h, $expectedResult);
    }

    public function testHeadOnEmptyArray() {

	$a = [];
	$h = $this->head($a);
	$expectedResult = Maybe::nothing();

	$this->assertEquals($h, $expectedResult);
    }

    public function testHeadOnString() {

	$a = "hello";
	$h = $this->head($a);
	$expectedResult = Maybe::nothing();

	$this->assertEquals($h, $expectedResult);
    }

    public function testHeadOnObject() {

	$h = $this->head($this);
	$expectedResult = Maybe::nothing();

	$this->assertEquals($h, $expectedResult);
    }

    public function testHeadOnAssociativeArray() {

	$a = ['1' => 'apples',
	      '2' => 'oranges',
	      '3' => 'bananas'];
	$h = $this->head($a);
	$expectedResult = Maybe::fromValue('apples');

	$this->assertEquals($h, $expectedResult);
    }

    private function head($array) {
	if (is_array($array)) {
	    if (count($array) > 0) {
		$vals = array_values($array);
		$h = Maybe::fromValue($vals[0]);
	    } else {
		$h = Maybe::nothing();
	    }
	} else {
	    $h = Maybe::nothing();
	}

	return $h;
    }
}
