<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\Maybe\Maybe;

class Nil extends LinkedList {

  /**
   * @internal
   * Clients should not construct Nils directly; use `LinkedListFactory` instead.
   */
  public function __construct() {}

  public function isEmpty() {
    return true;
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

  public function take($n) {
    return $this;
  }

  public function drop($n) {
    return $this;
  }

  protected function toNativeArrayPrivate(array &$array, $idx) {
    return $array;
  }

  public function size() {
    return 0;
  }

  public function map(callable $f) {
    return $this;
  }

  public function flatMap(callable $f) {
    return $this;
  }

  protected function applyNoArg() {
    return $this;
  }

  protected function applyToArg($ignore) {
    return $this;
  }

  final public function append($other) {
    return $other;
  }

  final public function filter($f) {
    return $this;
  }

  final public function foldLeft($init, callable $f) {
    return $init;
  }

  final public function foldRight($init, callable $f) {
    return $init;
  }

  protected function numConsCells() {
    return 0;
  }

  /**
   * @param $i :: int The index of the desired `LinkedList` element.
   * @return :: Maybe[a] The desired `LinkedList` element wrapped in a `Maybe`.
   */
  public function nth(int $i): Maybe {
    return Maybe::nothing();
  }

  final public function takeWhile(callable $f): LinkedList {
    return $this;
  }

  final public function dropWhile(callable $f): LinkedList {
    return $this;
  }

}
