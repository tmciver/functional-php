<?php

use TMciver\Functional\LinkedList\LinkedListFactory;

class LinkedListFactoryTest extends PHPUnit_Framework_TestCase {

  private $listFactory;
  private $emptyList;

  public function __construct() {
    $this->listFactory = new LinkedListFactory();
    $this->emptyList = $this->listFactory->empty();
  }

  public function testFromNativeArrayNonEmpty() {
    $ll = $this->listFactory->fromNativeArray([1, 2, 3]);
    $expected = $this->listFactory->empty()->cons(3)->cons(2)->cons(1);

    $this->assertEquals($expected, $ll);
  }

  public function testFromNativeArrayEmpty() {
    $ll = $this->listFactory->fromNativeArray([]);
    $expected = $this->emptyList;

    $this->assertEquals($expected, $ll);
  }

}
