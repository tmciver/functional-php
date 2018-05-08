<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\Maybe\Maybe;
use TMciver\Functional\PartialFunction;

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

  public function toNativeArray() {
    // TODO: find a better way. This certainly has terrible performance.
    return array_merge([$this->value], $this->tail->toNativeArray());
  }

  public function size() {
    return 1 + $this->tail->size();
  }

  public function map(callable $f) {
    return new Cons($f($this->value), $this->tail->map($f));
  }

  public function flatMap(callable $f) {
    $headList = $f($this->value);

    return $headList->concat($this->tail->flatMap($f));
  }

  protected function applyNoArg() {
    return $this->map(function ($f) {
	return call_user_func($f);
      });
  }

  protected function applyToArg($argList) {
    // Wrap the applicative value in a PartialFunction,
    // if it is not already.
    $pf = $this->value instanceof PartialFunction ?
      $this->value :
      new PartialFunction($this->value);

    // Apply the PartialFunction to each argument in $argList
    $headList = $argList->map($pf);

    // Do the tail applications
    $tailList = $this->tail->applyToArg($argList);

    return $headList->concat($tailList);
  }

  final public function append($other) {
    return new Cons($this->value, $this->tail->append($other));
  }

  final public function filter($f) {
    // First, filter the tail
    $filteredTail = $this->tail->filter($f);

    // Then, filter this node.
    return $f($this->value)
      ? new Cons($this->value, $filteredTail)
      : $filteredTail;
  }
}
