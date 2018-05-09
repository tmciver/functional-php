<?php

namespace TMciver\Functional;

trait Foldable {

  /**
   * Left-associative fold of a structure.
   *
   * @param $init The seed value for the fold. This value is the result in the
   *        case of an empty structure.
   * @param $f The folding function. A function of two arguments: the first
   *        argument should be of the same type as $init (and the return type);
   *        the second argument is an element of the `Foldable` structure.
   * @return A value that has the same type as $init.
   */
  abstract function foldLeft($init, callable $f);

  /**
   * Convert this structure to a `LinkedList`.
   */
  abstract function toLinkedList();
}