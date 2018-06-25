<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\Maybe\Maybe;
use TMciver\Functional\PartialFunction;

class Cons extends LinkedList {

  private $value;
  private $tail;
  private $size;
  private $numConsCells;

  /**
   * @internal
   * Clients should not construct Conses directly; use `LinkedListFactory` instead.
   */
  public function __construct($value, $list) {
    $this->value = $value;
    $this->tail = $list;
    $this->numConsCells = $list->numConsCells() + 1;
  }

  public function isEmpty() {
    return false;
  }

  public function take($n) {
    if ($n < 1) {
      $l = new Nil();
    } else {
      $l = new Cons($this->value, $this->tail->take($n - 1));
    }

    return $l;
  }

  public function drop($n) {
    return ($n == 0) ?
      $this :
      $this->tail->drop($n - 1);
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

  protected function toNativeArrayPrivate(array &$array, $idx) {
    // Put this Cons' value in the array at position $idx.
    $array[$idx] = $this->value;

    // Continue with the tail.
    return $this->tail->toNativeArrayPrivate($array, $idx + 1);
  }

  public function size() {
    // Memozize the size if it's not already.
    if (is_null($this->size)) {
      $this->size = $this->foldLeft(0, function ($size, $x) { return $size + 1; });
    }

    return $this->size;
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

  final public function foldLeft($init, callable $f) {
    $acc = $f($init, $this->value);
    return $this->tail->foldLeft($acc, $f);
  }

  final public function foldRight($init, callable $f) {
    $acc = $this->tail->foldRight($init, $f);
    return $f($this->value, $acc);
  }

  protected function numConsCells() {
    return $this->numConsCells;
  }

  /**
   * @param $i :: int The index of the desired `LinkedList` element.
   * @return :: Maybe[a] The desired `LinkedList` element wrapped in a `Maybe`.
   */
  public function nth(int $i): Maybe {
    return ($i == 0) ?
               Maybe::fromValue($this->value) :
               $this->tail->nth($i - 1);
  }

  final public function takeWhile(callable $f): LinkedList {
    $abll = new ArrayBackedLinkedList($this->toNativeArray());
    return $abll->takeWhile($f);
  }

  final public function dropWhile(callable $f): LinkedList {
    return $f($this->value) ?
      $this->tail->dropWhile($f) :
      $this;
  }
}
