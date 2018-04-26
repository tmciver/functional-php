<?php

use TMciver\Functional\LinkedList\LinkedListFactory;
use TMciver\Functional\LinkedList\Nil;

class LinkedListFactoryTest extends PHPUnit_Framework_TestCase {

  private $empty;

  public function __construct() {
    $this->empty = new Nil();
  }

  public function testFromNativeArrayNonEmpty() {
    $ll = LinkedListFactory::fromNativeArray([1, 2, 3]);
    $expected = $this->empty->add(3)->add(2)->add(1);

    $this->assertEquals($expected, $ll);
  }

  public function testFromNativeArrayEmpty() {
    $ll = LinkedListFactory::fromNativeArray([]);
    $expected = $this->empty;

    $this->assertEquals($expected, $ll);
  }

  public function testFromNativeArrayNull() {
    $ll = LinkedListFactory::fromNativeArray(null);
    $expected = $this->empty;

    $this->assertEquals($expected, $ll);
  }
}