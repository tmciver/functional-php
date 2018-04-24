<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\Maybe\Maybe;

class EmptyList extends LinkedList {

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
}