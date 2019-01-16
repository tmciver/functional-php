<?php

use PHPUnit\Framework\TestCase;
use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\LinkedList\ArrayBackedLinkedList;
use PhatCats\Maybe\Maybe;
use PhatCats\Tuple;

class LinkedListFactoryTest extends TestCase {

  private $listFactory;
  private $emptyList;

  public function setUp() {
    $this->listFactory = new LinkedListFactory();
    $this->emptyList = $this->listFactory->empty();
  }

  protected function assertLinkedListsEqual($l1, $l2) {
    $this->assertEquals($l1->toNativeArray(), $l2->toNativeArray());
  }

  public function testFromNativeArrayNonEmpty() {
    $ll = $this->listFactory->fromNativeArray([1, 2, 3]);
    $expectedArray = $this->listFactory->empty()->cons(3)->cons(2)->cons(1)->toNativeArray();
    $expected = new ArrayBackedLinkedList($expectedArray, $this->listFactory);

    $this->assertEquals($expected, $ll);
  }

  public function testFromNativeArrayEmpty() {
    $ll = $this->listFactory->fromNativeArray([]);
    $expected = $this->emptyList;

    $this->assertEquals($expected, $ll);
  }

  public function testRange() {
    $list = $this->listFactory->range(2, 11, 2);
    $expected = $this->listFactory->fromNativeArray([2, 4, 6, 8, 10]);

    $this->assertEquals($expected, $list);
  }

  public function testCycleNonEmpty() {
    $l = $this->listFactory->fromNativeArray([1, 2, 3]);
    $c = $this->listFactory->cycle($l);
    $result = $c->take(7);
    $expected = $this->listFactory->fromNativeArray([1, 2, 3, 1, 2, 3, 1]);

    $this->assertLinkedListsEqual($expected, $result);
  }

  public function testCycleEmpty() {
    $l = $this->listFactory->empty();
    $c = $this->listFactory->cycle($l);
    $result = $c->take(7);
    $expected = $this->listFactory->empty();

    $this->assertLinkedListsEqual($expected, $result);
  }

  public function testRepeat() {
    $l = $this->listFactory->repeat('hello');
    $result = $l->take(7);
    $expected = $this->listFactory->fromNativeArray(['hello',
						     'hello',
						     'hello',
						     'hello',
						     'hello',
						     'hello',
						     'hello']);
    $this->assertLinkedListsEqual($expected, $result);
  }

  public function testReplicatePositive() {
    $l = $this->listFactory->replicate(5, 'a');
    $expected = $this->listFactory->fromNativeArray(['a', 'a', 'a', 'a', 'a']);

    $this->assertLinkedListsEqual($expected, $l);
  }

  public function testReplicateZero() {
    $l = $this->listFactory->replicate(0, 'a');
    $expected = $this->listFactory->fromNativeArray([]);

    $this->assertLinkedListsEqual($expected, $l);
  }

  public function testReplicateNegative() {
    $l = $this->listFactory->replicate(-1, 'a');
    $expected = $this->listFactory->fromNativeArray([]);

    $this->assertLinkedListsEqual($expected, $l);
  }

  public function testUnfoldNonEmpty() {
    $init = 10;
    $f = function ($b) {
      return $b < 1 ?
        Maybe::nothing() :
        Maybe::fromValue(new Tuple($b, $b - 1));
    };
    $result = $this->listFactory->unfold($f, $init);
    $expected = $this->listFactory->fromNativeArray([10, 9, 8, 7, 6, 5, 4, 3, 2, 1]);

    $this->assertLinkedListsEqual($expected, $result);
  }

  public function testUnfoldEmpty() {
    $init = 10;
    $f = function ($b) { return Maybe::nothing(); };
    $result = $this->listFactory->unfold($f, $init);
    $expected = $this->listFactory->fromNativeArray([]);

    $this->assertLinkedListsEqual($expected, $result);
  }

}
