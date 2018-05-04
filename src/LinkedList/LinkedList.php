<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\Collection;
use TMciver\Functional\Applicative;
use TMciver\Functional\SemiGroup;

abstract class LinkedList {
  use Collection, SemiGroup, Applicative;

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

  public function append($other) {
    throw new \Exception('Not yet implemented.');
  }

  public abstract function toNativeArray();

  public abstract function concat($otherList);
}
