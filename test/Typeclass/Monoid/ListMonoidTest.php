<?php

namespace PhatCats\Test\Typeclass\Monoid;

use PhatCats\LinkedList\LinkedListFactory;
use PhatCats\LinkedList\ListMonoid;

class ListMonoidTest extends MonoidTest {

  private $factory;

  public function setUp() {
    $this->factory = new LinkedListFactory();
    parent::setUp();
  }

  protected function getMonoid() {
    return new ListMonoid();
  }

  protected function getOne() {
    return $this->factory->fromNativeArray([1, 2]);
  }

  protected function getTwo() {
    return $this->factory->fromNativeArray([3, 4]);
  }

  protected function getThree() {
    return $this->factory->fromNativeArray([5, 6]);
  }

}
