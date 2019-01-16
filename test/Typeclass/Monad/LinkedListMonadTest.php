<?php

namespace PhatCats\Test\Typeclass\Monad;

use PhatCats\LinkedList\LinkedListMonad;
use PhatCats\LinkedList\LinkedList;
use PhatCats\LinkedList\LinkedListFactory;

/**
 * Class for testing `LinkedListMonad`.
 * @see PhatCats\Test\Typeclass\Monad\MonadTest;
 */
class LinkedListMonadTest extends MonadTest {

  private $linkedListMonad;
  private $factory;

  public function setUp() {
    $this->linkedListMonad = new LinkedListMonad();
    $this->factory = new LinkedListFactory();
  }

  protected function getMonad() {
    return $this->linkedListMonad;
  }

  protected function getValue() {
    return 1;
  }

  protected function getMonadicFunctionF() {
    return function($i) {
      return $this->factory->fromNativeArray([$i + 1, $i + 2, $i + 3]);
    };
  }

  protected function getMonadicFunctionG() {
    return function($i) {
      return $this->factory->fromNativeArray(str_split(str_repeat(".", $i)));
    };
  }
}
