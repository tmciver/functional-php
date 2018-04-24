<?php

namespace TMciver\Functional\LinkedList;

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
}