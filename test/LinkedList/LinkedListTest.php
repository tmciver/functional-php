<?php

namespace TMciver\Functional\Test\LinkedList;

use PHPUnit\Framework\TestCase;
use TMciver\Functional\LinkedList\Cons;
use TMciver\Functional\LinkedList\LinkedList;
use TMciver\Functional\LinkedList\LinkedListFactory;
use TMciver\Functional\LinkedList\ArrayBackedLinkedList;
use TMciver\Functional\Maybe\Maybe;

require_once __DIR__ . '/../util.php';

abstract class LinkedListTest extends TestCase {

  protected $listFactory;
  protected $emptyList;

  public function setUp() {
    $this->listFactory = new LinkedListFactory();
    $this->emptyList = $this->listFactory->empty();
  }

  // Use the Template Pattern (https://en.wikipedia.org/wiki/Template_method_pattern)
  // for constructing different kinds of LinkedList.
  protected abstract function makeListFromArray(array $array);

  protected function assertLinkedListsEqual($l1, $l2) {
    $this->assertEquals($l1->toNativeArray(), $l2->toNativeArray());
  }

  public function testCons() {
    $myList = $this->makeListFromArray([2, 3, 4]);
    $newList = $myList->cons(1);
    $expected = $this->listFactory->fromNativeArray([1, 2, 3, 4]);

    $this->assertLinkedListsEqual($expected, $newList);
  }

  public function testRemoveElementThatExists() {

    $myList = $this->makeListFromArray([1, 2, 3]);
    $newList = $myList->remove(3);
    $expected = $this->listFactory->fromNativeArray([1, 2]);

    $this->assertLinkedListsEqual($expected, $newList);
  }

  public function testRemoveElementThatDoesNotExist() {

    $myList = $this->makeListFromArray([1, 2, 3]);
    $newList = $myList->remove(4);
    $expected = $myList; // list should be unchanged

    $this->assertLinkedListsEqual($expected, $newList);
  }

  public function testRemoveOnlyFirstElement() {

    $myList = $this->makeListFromArray([2, 1, 2, 3]);
    $newList = $myList->remove(2);
    $expected = $this->listFactory->fromNativeArray([1, 2, 3]);

    $this->assertLinkedListsEqual($expected, $newList);
  }

  public function testContainsWhenItContains() {

    $myList = $this->makeListFromArray([1, 2, 3]);
    $hasElement = $myList->contains(3);
    $expected = true;

    $this->assertEquals($expected, $hasElement);
  }

  public function testContainsWhenItDoesNotContain() {

    $myList = $this->makeListFromArray([1, 2, 3]);
    $hasElement = $myList->contains(4);
    $expected = false;

    $this->assertEquals($expected, $hasElement);
  }

  public function testHeadWhenNonEmpty() {
    $myList = $this->makeListFromArray([1, 2, 3]);
    $headMaybe = $myList->head();
    $expected = Maybe::fromValue(1);

    $this->assertEquals($expected, $headMaybe);
  }

  public function testHeadWhenEmpty() {
    $myList = $this->makeListFromArray([]);
    $headMaybe = $myList->head();
    $expected = Maybe::$nothing;

    $this->assertEquals($expected, $headMaybe);
  }

  public function testTailWhenNonEmpty() {
    $myList = $this->makeListFromArray([1, 2, 3]);
    $tail = $myList->tail();
    $expected = $this->listFactory->fromNativeArray([2, 3]);

    $this->assertLinkedListsEqual($expected, $tail);
  }

  public function testTailWhenEmpty() {
    $myList = $this->makeListFromArray([]);
    $tail = $myList->tail();
    $expected = $this->emptyList;

    $this->assertLinkedListsEqual($expected, $tail);
  }

  public function testSize() {
    $list1 = $this->makeListFromArray([1, 2, 3]);
    $list2 = $this->makeListFromArray([]);
    $expected1 = 3;
    $expected2 = 0;

    $this->assertEquals($expected1, $list1->size());
    $this->assertEquals($expected2, $list2->size());
  }

  public function testMap() {
    $list = $this->makeListFromArray([1, 2, 3]);
    $listPlusOne = $list->map(function ($x) { return $x + 1;});
    $expected = $this->listFactory->fromNativeArray([2, 3, 4]);

    $this->assertLinkedListsEqual($expected, $listPlusOne);
  }

  public function testFlatMap() {
    $list = $this->makeListFromArray([1, 2, 3]);
    $f = function($i) { return $this->makeListFromArray([$i + 1, $i + 2, $i + 3]); };
    $result = $list->flatMap($f);
    $expected = $this->listFactory->fromNativeArray([2, 3, 4, 3, 4, 5, 4, 5, 6]);

    $this->assertLinkedListsEqual($expected, $result);
  }

  public function testConcatBothNonNil() {
    $list1 = $this->makeListFromArray([1, 2, 3]);
    $list2 = $this->makeListFromArray([4, 5, 6]);

    $result = $list1->concat($list2);
    $expected = $this->listFactory->fromNativeArray([1, 2, 3, 4, 5, 6]);

    $this->assertLinkedListsEqual($expected, $result);
  }

  public function testConcatNilAndNonNil() {
    $list1 = $this->makeListFromArray([]);
    $list2 = $this->makeListFromArray([4, 5, 6]);

    $result = $list1->concat($list2);
    $expected = $this->listFactory->fromNativeArray([4, 5, 6]);

    $this->assertLinkedListsEqual($expected, $result);
  }

  public function testConcatNonNilAndNil() {
    $list1 = $this->makeListFromArray([4, 5, 6]);
    $list2 = $this->makeListFromArray([]);

    $result = $list1->concat($list2);
    $expected = $this->listFactory->fromNativeArray([4, 5, 6]);

    $this->assertLinkedListsEqual($expected, $result);
  }

  public function testApply() {
    $fs = $this->makeListFromArray(['addOne', 'multiplyByTwo']);
    $args = $this->makeListFromArray([1, 2]);
    $result = $fs->apply($args);
    $expected = $this->listFactory->fromNativeArray([2, 3, 2, 4]);

    $this->assertLinkedListsEqual($expected, $result);
  }

  public function testInvoke() {
    $fs = $this->makeListFromArray(['addOne', 'multiplyByTwo']);
    $args = $this->makeListFromArray([1, 2]);
    $result = $fs($args);
    $expected = $this->listFactory->fromNativeArray([2, 3, 2, 4]);

    $this->assertLinkedListsEqual($expected, $result);
  }

  public function testInvokeNoArgs() {
    $f = function () { return 1; };
    $fs = $this->listFactory->pure($f);
    $result = $fs();
    $expected = $this->listFactory->pure(1);

    $this->assertEquals($expected, $result);
  }

  public function testToNativeArray() {
    // create an array that is part ArrayBackedLinkedList and part Cons's
    $nArray = [1, 2, 3, 4, 5];
    $list = $this->makeListFromArray($nArray);
    $expected = $nArray;
    $result = $list->toNativeArray();

    $this->assertEquals($expected, $result);
  }

  public function testFilter() {
    $list = $this->makeListFromArray([1, 2, 3, 4]);
    $isOdd = function ($v) { return $v % 2 != 0; };
    $filteredList = $list->filter($isOdd);
    $excpected = $this->listFactory->fromNativeArray([1, 3]);

    $this->assertLinkedListsEqual($excpected, $filteredList);
  }

  public function testFoldLeftNonNil() {
    $list = $this->makeListFromArray([1, 2, 3]);
    $concat = function ($str, $i) { return '(' . $str . '+' . $i . ')'; };
    $result = $list->foldLeft('0', $concat);
    $expected = '(((0+1)+2)+3)';

    $this->assertEquals($expected, $result);
  }

  public function testFoldLeftNil() {
    $list = $this->makeListFromArray([]);
    $add = function ($sum, $x) { return $sum + $x; };
    $sum = $list->foldLeft(0, $add);
    $expected = 0;

    $this->assertEquals($expected, $sum);
  }

  public function testFoldRightNonNil() {
    $list = $this->makeListFromArray([1, 2, 3]);
    $concat = function ($i, $str) { return '(' . $i . '+' . $str . ')'; };
    $result = $list->foldRight('0', $concat);
    $expected = '(1+(2+(3+0)))';

    $this->assertEquals($expected, $result);
  }

  public function testFoldRightNil() {
    $list = $this->makeListFromArray([]);
    $add = function ($x, $sum) { return $sum + $x; };
    $sum = $list->foldRight(0, $add);
    $expected = 0;

    $this->assertEquals($expected, $sum);
  }

  public function testFoldMap() {
    $monoid = Maybe::nothing();
    $list = $this->makeListFromArray(["hello", " world!"]);
    $toMonoid = function ($v) { return Maybe::fromValue($v); };
    $result = $list->foldMap($monoid, $toMonoid);
    $expected = Maybe::fromValue("hello world!");

    $this->assertEquals($expected, $result);
  }

  public function testFold() {
    $monoid = Maybe::nothing();
    $list = $this->makeListFromArray([Maybe::fromValue("hello"),
				      $monoid, // throw in a Nothing for good measure
				      Maybe::fromValue(" world!")]);
    $result = $list->fold($monoid);
    $expected = Maybe::fromValue("hello world!");

    $this->assertEquals($expected, $result);
  }

  public function testTraverseNonNil() {
    $monad = Maybe::nothing();
    $list = $this->makeListFromArray([1, 2, 3]);
    $f = function ($x) { return Maybe::fromValue(strval($x)); };
    $result = $list->traverse($f, $monad);
    $expected = Maybe::fromValue($this->listFactory->fromNativeArray(['1', '2', '3']));

    $this->assertLinkedListsEqual($expected->get(), $result->get());
  }

  public function testTraverseNil() {
    $monad = Maybe::nothing();
    $list = $this->makeListFromArray([]);
    $f = function ($x) { return Maybe::fromValue(strval($x)); };
    $result = $list->traverse($f, $monad);
    $expected = Maybe::fromValue($this->listFactory->empty());

    $this->assertEquals($expected, $result);
  }

  public function testSequence() {
    $monad = Maybe::nothing();
    // List of Maybe Ints (LinkedList[Maybe[Int]])
    $list = $this->makeListFromArray([Maybe::fromValue(1),
				      Maybe::fromValue(2),
				      Maybe::fromValue(3)]);
    $result = $list->sequence($monad);
    $expected = Maybe::fromValue($this->listFactory->fromNativeArray([1, 2, 3]));

    $this->assertLinkedListsEqual($expected->get(), $result->get());
  }

  public function testSequenceForListContainingNothing() {
    $monad = Maybe::nothing();
    // List of Maybe Ints (LinkedList[Maybe[Int]])
    $list = $this->makeListFromArray([Maybe::fromValue(1),
				      Maybe::fromValue(2),
				      $monad, // throw in a Nothing for good measure
				      Maybe::fromValue(3),]);
    // Maybe of List of Int (Maybe[LinkedList[Int]])
    $result = $list->sequence($monad);
    $expected = Maybe::nothing();

    $this->assertEquals($expected, $result);
  }

  public function testConsToArrayBackedLinkedListConversion() {
    // First, set the Cons limit to something small
    LinkedList::$CONS_CELL_LIMIT = 3;

    // Create a Cons LinkedList at the limit
    $l = $this->listFactory->empty()->cons(4)->cons(3)->cons(2);

    // Verify that it's a Cons LinkedList
    $this->assertInstanceOf(Cons::class, $l);

    // Add another element
    $ll = $l->cons(1);

    // Verify that the new list is now an ArrayBackedLinkedList
    $this->assertInstanceOf(ArrayBackedLinkedList::class, $ll);
  }

  public function testIsEmptyWhenEmpty() {
    $l = $this->makeListFromArray([]);

    $this->assertTrue($l->isEmpty());
  }

  public function testIsEmptyWhenNotEmpty() {
    $l = $this->makeListFromArray([1, 2, 3]);

    $this->assertFalse($l->isEmpty());
  }

  public function testTakeZero() {
    $l = $this->makeListFromArray([1, 2, 3, 4, 5]);
    $none = $l->take(0);
    $expected = $this->makeListFromArray([]);

    $this->assertLinkedListsEqual($expected, $none);
  }

  public function testTakeGreaterThanZero() {
    $l = $this->makeListFromArray([1, 2, 3, 4, 5]);
    $none = $l->take(3);
    $expected = $this->makeListFromArray([1, 2, 3]);

    $this->assertLinkedListsEqual($expected, $none);
  }

  public function testDropZero() {
    $l = $this->makeListFromArray([1, 2, 3, 4, 5]);
    $result = $l->drop(0);
    $expected = $l;

    $this->assertLinkedListsEqual($expected, $result);
  }

  public function testDropGreaterThanZero() {
    $l = $this->makeListFromArray([1, 2, 3, 4, 5]);
    $result = $l->drop(3);
    $expected = $this->makeListFromArray([4, 5]);

    $this->assertLinkedListsEqual($expected, $result);
  }

  public function testToStringForSmallList() {
    $l = $this->makeListFromArray([1, 2, 3]);
    $lStr = (string)$l;
    $expected = "LinkedList(1, 2, 3)";

    $this->assertEquals($expected, $lStr);
  }

  public function testToStringForEmptyList() {
    $l = $this->makeListFromArray([]);
    $lStr = (string)$l;
    $expected = "LinkedList()";

    $this->assertEquals($expected, $lStr);
  }

  public function testToStringForLargeList() {
    // set LinkedList::$TO_STRING_MAX to something small
    $currMax = LinkedList::$TO_STRING_MAX;
    LinkedList::$TO_STRING_MAX = 3;
    $l = $this->makeListFromArray([1, 2, 3, 4, 5]);

    $lStr = (string)$l;
    $expected = "LinkedList(1, 2, 3, . . .)";

    // reset LinkedList::$TO_STRING_MAX
    LinkedList::$TO_STRING_MAX = $currMax;

    $this->assertEquals($expected, $lStr);
  }

  public function testInterleave() {
    $l1 = $this->makeListFromArray([1, 3, 5]);
    $l2 = $this->makeListFromArray([2, 4, 6]);
    $result = $l1->interleave($l2);
    $expected  = $this->listFactory->fromNativeArray([1, 2, 3, 4, 5, 6]);

    $this->assertLinkedListsEqual($expected, $result);
  }

  public function testInterleaveInfiniteList() {
    $l1 = $this->makeListFromArray([1, 1, 1]);
    $l2 = $this->listFactory->repeat(0);
    $result = $l1->interleave($l2);
    $expected  = $this->listFactory->fromNativeArray([1, 0, 1, 0, 1, 0]);

    $this->assertLinkedListsEqual($expected, $result);
  }

  public function testInterleaveWithEmptyList() {
    $l1 = $this->makeListFromArray([1, 3, 5]);
    $l2 = $this->listFactory->empty();
    $result = $l1->interleave($l2);
    $expected  = $this->listFactory->empty();

    $this->assertLinkedListsEqual($expected, $result);
  }

  public function testSortNonEmpty() {
    $l = $this->makeListFromArray([5, 9, 12, 43, 2, 0, 7]);
    $l2 = $l->map(function ($x) { return $x; }); // TODO looks like we need a `copy` method?
    $sortedL = $l->sort();
    $expected = $this->listFactory->fromNativeArray([0, 2, 5, 7, 9, 12, 43]);

    $this->assertLinkedListsEqual($expected, $sortedL);

    // Also ensure that source list was not modified
    $this->assertLinkedListsEqual($l2, $l);
  }

  public function testSortEmpty() {
    $l = $this->makeListFromArray([]);
    $sortedL = $l->sort();
    $expected = $this->listFactory->empty();

    $this->assertLinkedListsEqual($expected, $sortedL);
  }

}
