<?php

use TMciver\Functional\LinkedList\LinkedListFactory;
use TMciver\Functional\Maybe\Maybe;

require_once __DIR__ . '/../util.php';

class ListTest extends PHPUnit_Framework_TestCase {

  private $listFactory;
  private $emptyList;

  public function __construct() {
    $this->listFactory = new LinkedListFactory();
    $this->emptyList = $this->listFactory->empty();
  }

  public function testAdd() {

    $myList = $this->listFactory->fromNativeArray([2, 3, 4]);
    $newList = $myList->cons(1);
    $expected = $this->listFactory->fromNativeArray([1, 2, 3, 4]);

    $this->assertEquals($expected, $newList);
  }

  public function testRemoveElementThatExists() {

    $myList = $this->listFactory->fromNativeArray([1, 2, 3]);
    $newList = $myList->remove(3);
    $expected = $this->listFactory->fromNativeArray([1, 2]);

    $this->assertEquals($expected, $expected);
  }

  public function testRemoveElementThatDoesNotExist() {

    $myList = $this->listFactory->fromNativeArray([1, 2, 3]);
    $newList = $myList->remove(4);
    $expected = $myList; // list should be unchanged

    $this->assertEquals($expected, $newList);
  }

  public function testRemoveOnlyFirstElement() {

    $myList = $this->listFactory->fromNativeArray([2, 1, 2, 3]);
    $newList = $myList->remove(2);
    $expected = $this->listFactory->fromNativeArray([1, 2, 3]);

    $this->assertEquals($expected, $newList);
  }

  public function testContainsWhenItContains() {

    $myList = $this->listFactory->fromNativeArray([1, 2, 3]);
    $hasElement = $myList->contains(3);
    $expected = true;

    $this->assertEquals($expected, $hasElement);
  }

  public function testContainsWhenItDoesNotContain() {

    $myList = $this->listFactory->fromNativeArray([1, 2, 3]);
    $hasElement = $myList->contains(4);
    $expected = false;

    $this->assertEquals($expected, $hasElement);
  }

  public function testHeadWhenNonEmpty() {
    $myList = $this->listFactory->fromNativeArray([1, 2, 3]);
    $headMaybe = $myList->head();
    $expected = Maybe::fromValue(1);

    $this->assertEquals($expected, $headMaybe);
  }

  public function testHeadWhenEmpty() {
    $myList = $this->emptyList;
    $headMaybe = $myList->head();
    $expected = Maybe::$nothing;

    $this->assertEquals($expected, $headMaybe);
  }

  public function testTailWhenNonEmpty() {
    $myList = $this->listFactory->fromNativeArray([1, 2, 3]);
    $tail = $myList->tail();
    $expected = $this->listFactory->fromNativeArray([2, 3]);

    $this->assertEquals($expected, $tail);
  }

  public function testTailWhenEmpty() {
    $myList = $this->emptyList;
    $tail = $myList->tail();
    $expected = $this->emptyList;

    $this->assertEquals($expected, $tail);
  }

  public function testSize() {
    $list1 = $this->listFactory->fromNativeArray([1, 2, 3]);
    $list2 = $this->emptyList;
    $expected1 = 3;
    $expected2 = 0;

    $this->assertEquals($expected1, $list1->size());
    $this->assertEquals($expected2, $list2->size());
  }

  public function testMap() {
    $list = $this->listFactory->fromNativeArray([1, 2, 3]);
    $listPlusOne = $list->map(function ($x) { return $x + 1;});
    $expected = $this->listFactory->fromNativeArray([2, 3, 4]);

    $this->assertEquals($expected, $listPlusOne);
  }

  public function testFlatMap() {
    $list = $this->listFactory->fromNativeArray([1, 2, 3]);
    $f = function($i) { return $this->listFactory->fromNativeArray([$i + 1, $i + 2, $i + 3]); };
    $result = $list->flatMap($f);
    $expected = $this->listFactory->fromNativeArray([2, 3, 4, 3, 4, 5, 4, 5, 6]);

    $this->assertEquals($expected, $result);
  }

  public function testConcatBothNonNil() {
    $list1 = $this->listFactory->fromNativeArray([1, 2, 3]);
    $list2 = $this->listFactory->fromNativeArray([4, 5, 6]);

    $result = $list1->concat($list2);
    $expected = $this->listFactory->fromNativeArray([1, 2, 3, 4, 5, 6]);

    $this->assertEquals($expected, $result);
  }

  public function testConcatNilAndNonNil() {
    $list1 = $this->listFactory->empty();
    $list2 = $this->listFactory->fromNativeArray([4, 5, 6]);

    $result = $list1->concat($list2);
    $expected = $this->listFactory->fromNativeArray([4, 5, 6]);

    $this->assertEquals($expected, $result);
  }

  public function testConcatNonNilAndNil() {
    $list1 = $this->listFactory->fromNativeArray([4, 5, 6]);
    $list2 = $this->listFactory->empty();

    $result = $list1->concat($list2);
    $expected = $this->listFactory->fromNativeArray([4, 5, 6]);

    $this->assertEquals($expected, $result);
  }

  public function testApply() {
    $fs = $this->listFactory->fromNativeArray([addOne, multiplyByTwo]);
    $args = $this->listFactory->fromNativeArray([1, 2]);
    $result = $fs->apply($args);
    $expected = $this->listFactory->fromNativeArray([2, 3, 2, 4]);

    $this->assertEquals($expected, $result);
  }

  public function testInvoke() {
    $fs = $this->listFactory->fromNativeArray([addOne, multiplyByTwo]);
    $args = $this->listFactory->fromNativeArray([1, 2]);
    $result = $fs($args);
    $expected = $this->listFactory->fromNativeArray([2, 3, 2, 4]);

    $this->assertEquals($expected, $result);
  }

  public function testInvokeNoArgs() {
    $f = function () { return 1; };
    $fs = $this->listFactory->pure($f);
    $result = $fs();
    $expected = $this->listFactory->pure(1);

    $this->assertEquals($expected, $result);
  }

  public function testToNativeArray() {
    $nArray = [1, 2, 3];
    $list = $this->listFactory->fromNativeArray($nArray);
    $expected = $nArray;
    $result = $list->toNativeArray();

    $this->assertEquals($expected, $result);
  }

  public function testFilter() {
    $list = $this->listFactory->fromNativeArray([1, 2, 3, 4]);
    $isOdd = function ($v) { return $v % 2 != 0; };
    $filteredList = $list->filter($isOdd);
    $excpected = $this->listFactory->fromNativeArray([1, 3]);

    $this->assertEquals($excpected, $filteredList);
  }
}
