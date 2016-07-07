<?php

use TMciver\Functional\Maybe\Just;
use TMciver\Functional\Maybe\Nothing;

class HeadTest extends PHPUnit_Framework_TestCase {

    public function testHeadOnNonEmptyArray() {

	$a = ['apples', 'oranges', 'bananas'];
	$h = $this->head($a);
	$expectedResult = new Just('apples');

	$this->assertEquals($h, $expectedResult);
    }

    public function testHeadOnEmptyArray() {

	$a = [];
	$h = $this->head($a);
	$expectedResult = new Nothing();

	$this->assertEquals($h, $expectedResult);
    }

    public function testHeadOnString() {

	$a = "hello";
	$h = $this->head($a);
	$expectedResult = new Nothing();

	$this->assertEquals($h, $expectedResult);
    }

    public function testHeadOnObject() {

	$h = $this->head($this);
	$expectedResult = new Nothing();

	$this->assertEquals($h, $expectedResult);
    }

    public function testHeadOnAssociativeArray() {

	$a = ['1' => 'apples',
	      '2' => 'oranges',
	      '3' => 'bananas'];
	$h = $this->head($a);
	$expectedResult = new Just('apples');

	$this->assertEquals($h, $expectedResult);
    }

    private function head($array) {
	if (is_array($array)) {
	    if (count($array) > 0) {
		$vals = array_values($array);
		$h = new Just($vals[0]);
	    } else {
		$h = new Nothing();
	    }
	} else {
	    $h = new Nothing();
	}

	return $h;
    }
}
