<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\Collection;
use TMciver\Functional\Monad;
use TMciver\Functional\Monoid;

abstract class LinkedList {
  use Collection, Monoid, Monad;

  /**
   * Alias for Collection::add
   */
  public function cons($value) {
    return $this->add($value);
  }

  /**
   * @return TMciver\Functional\Maybe\Maybe containing value.
   */
  public abstract function head();

  /**
   * @return the tail of this LinkedList as LinkedList.
   */
  public abstract function tail();

  public function fail() {
    return (new LinkedListFactory())->empty();
  }

  public function pure($val) {
    return (new LinkedListFactory())->pure($val);
  }

  final public function concat($otherList) {
    return $this->append($otherList);
  }

  public abstract function toNativeArray();

  final public function identity() {
    return (new LinkedListFactory())->empty();
  }

  final public function toLinkedList() {
    return $this;
  }
}
