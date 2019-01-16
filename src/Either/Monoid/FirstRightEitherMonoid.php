<?php

namespace PhatCats\Either\Monoid;

use PhatCats\Typeclass\Monoid;
use PhatCats\Either\Either;

/*
 * This Either monoid gives the same behavior as Haskell's Either SemiGroup. In
 * particular, it has this behavior:
 *
 * $firstRightEitherMonoid->append(a :: Left, b) = b
 * $firstRightEitherMonoid->append(a, b) = a
 *
 * In words, if the first arguemnt is a Left, the second argument is the result;
 * otherwise the first argument is the result.  Therefore, the wrapped values
 * are never appended.
 */
class FirstRightEitherMonoid implements Monoid {

  private $leftInnerMonoid;

  public function __construct(Monoid $leftInnerMonoid) {
    $this->leftInnerMonoid = $leftInnerMonoid;
  }

  public function identity() {
    return Either::left($this->leftInnerMonoid->identity());
  }

  public function append($first, $second) {
    return $first->isLeft() ? $second : $first;
  }
}
