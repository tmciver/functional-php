<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\Maybe\Maybe;

class Cons extends LinkedList {

  private $value;
  private $tail;

  /**
   * @internal
   * Clients should not construct Conses directly; use `LinkedListFactory` instead.
   */
  public function __construct($value, $list) {
    $this->value = $value;
    $this->tail = $list;
  }

  /**
   * Adds the given value to the head of this list.
   * @param $value The value to add.
   */
  public function add($value) {
    return new Cons($value, $this);
  }

  /**
   * Removes the first occurrence of given value from this list.
   * @param $value The value to remove.
   */
  public function remove($value) {
    if ($this->contains($value)) {
      if ($this->value == $value) {
	return $this->tail;
      } else {
	return new Cons($this->value, $this->tail->remove($value));
      }
    } else {
      return $this;
    }
  }

  /**
   * Returns true if the given value is in this list. False otherwise.
   * @param $value The value to remove.
   */
  public function contains($value) {
    if ($this->value == $value) {
      return true;
    } else {
      return $this->tail->contains($value);
    }
  }

  public function head() {
    return Maybe::fromValue($this->value);
  }

  public function tail() {
    return $this->tail;
  }

  public function size() {
    return 1 + $this->tail->size();
  }
}