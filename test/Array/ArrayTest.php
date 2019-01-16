<?php

use PHPUnit\Framework\TestCase;
use PhatCats\AssociativeArray;
use PhatCats\Either\Either;
use PhatCats\Either\Monad\RightFavoringEitherMonad;

class ArrayTest extends TestCase {

    private $monad;

    protected function setUp() {
        $this->monad = new RightFavoringEitherMonad();
    }

    public function testTraverseSuccessForArrayOfInt() {

	$dividend = 12;
	$divisors = [2, 4, 6];
	$intsArray = new AssociativeArray($divisors);
	$eitherResults = $intsArray->traverse(function ($i) use ($dividend) {
	    return divide($dividend, $i);
	}, $this->monad);
	$expected = Either::fromValue([6, 3, 2]);

	$this->assertEquals($expected, $eitherResults);
    }

    public function testTraverseFailureForArrayOfInt() {

	$dividend = 12;
	$divisors = [2, 0, 6];
	$intsArray = new AssociativeArray($divisors);
	$eitherResults = $intsArray->traverse(function ($i) use ($dividend) {
	    return divide($dividend, $i);
	}, $this->monad);
	$expected = Either::left('Division by zero!');

	$this->assertEquals($expected, $eitherResults);
    }

    public function testTraverseForEmptyArray() {

	$arr = new AssociativeArray([]);
	$eitherResult = $arr->traverse(function ($ignore) {
	    throw new \Exception('This should not affect the traversal as it should not be called!');
	}, $this->monad);
	$expected = Either::fromValue([]);

	$this->assertEquals($expected, $eitherResult);
    }

    public function testTraverseForThrownException() {

        $intsArray = new AssociativeArray([2, 0, 6]);
        $eitherResults = $intsArray->traverse(function ($i) {
            if ($i == 0) {
                throw new \Exception('Found zero!');
            } else {
                return Either::fromValue($i);
            }
        }, $this->monad);
        $expected = $this->monad->fail();

        $this->assertInstanceOf(PhatCats\Either\Left::class, $expected);
    }

    public function testTraverseForReturningNull() {

        $intsArray = new AssociativeArray([2, 0, 6]);
        $eitherResults = $intsArray->traverse(function ($ignore) {
            return null;
        }, $this->monad);
        $expected = $this->monad->fail();

        $this->assertInstanceOf(PhatCats\Either\Left::class, $expected);
    }

    public function testHandlingOfNullArgument() {
      $arr = new AssociativeArray(null);
      $expected = Either::fromValue([]);

      $this->assertEquals($arr->sequence($this->monad), $expected);
    }
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
