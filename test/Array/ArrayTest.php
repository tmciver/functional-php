<?php

use TMciver\Functional\AssociativeArray;
use TMciver\Functional\Either\Either;

class ArrayTest extends PHPUnit_Framework_TestCase {

    public function testTraverseSuccessForArrayOfInt() {

	$dividend = 12;
	$divisors = [2, 4, 6];
	$intsArray = new AssociativeArray($divisors);
	$instance = Either::left('');
	$eitherResults = $intsArray->traverse(function ($i) use ($dividend) {
	    return divide($dividend, $i);
	}, $instance);
	$expected = Either::fromValue([6, 3, 2]);

	$this->assertEquals($expected, $eitherResults);
    }

    public function testTraverseFailureForArrayOfInt() {

	$dividend = 12;
	$divisors = [2, 0, 6];
	$intsArray = new AssociativeArray($divisors);
	$instance = Either::left('');
	$eitherResults = $intsArray->traverse(function ($i) use ($dividend) {
	    return divide($dividend, $i);
	}, $instance);
	$expected = Either::left('Division by zero!');

	$this->assertEquals($expected, $eitherResults);
    }

    public function testTraverseForEmptyArray() {

	$arr = new AssociativeArray([]);
	$instance = Either::left('');
	$eitherResult = $arr->traverse(function ($ignore) {
	    throw new \Exception('This should not affect the traversal as it should not be called!');
	}, $instance);
	$expected = Either::fromValue([]);

	$this->assertEquals($expected, $eitherResult);
    }

    // This 
    /* public function testTraverseForThrownException() {

       $intsArray = new AssociativeArray([2, 0, 6]);
       $eitherResults = $intsArray->traverse(function ($i) {
       if ($i == 0) {
       throw new \Exception('Found zero!');
       } else {
       return Either::fromValue($i);
       }
       }, Either::class);
       $expected = null;

       //print_r($eitherResults);

       $this->assertEquals($expected, $eitherResults);
     * }*/
}

/**
 * @param x (number) The dividend
 * @param y (number) The divisor
 * @return Either number; Left if the divisor is zero, Right otherwise.
 */
function divide($x, $y) {
    if ($y == 0) {
	$eitherResult = Either::left('Division by zero!');
    } else {
	$eitherResult = Either::fromValue($x/$y);
    }

    return $eitherResult;
}
