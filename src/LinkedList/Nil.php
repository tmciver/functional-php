<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\Maybe\Maybe;

class Nil extends LinkedList {

  /**
   * @internal
   * Clients should not construct Nils directly; use `LinkedListFactory` instead.
   */
  public function __construct() {}

  public function add($value) {
    return new Cons($value, $this);
  }

  public function remove($value) {
    return $this;
  }

  public function contains($value) {
    return false;
  }

  public function head() {
    return Maybe::$nothing;
  }

  public function tail() {
    return $this;
  }

  public function size() {
    return 0;
  }

  public function map(callable $f) {
    return $this;
  }
}
