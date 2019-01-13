<?php

namespace TMciver\Functional\Attempt\Monoid;

use TMciver\Functional\Typeclass\Monoid;
use TMciver\Functional\Attempt\Attempt;

/*
 * This Attempt monoid gives the same behavior as Haskell's Attempt SemiGroup. In
 * particular, it has this behavior:
 *
 * $firstSuccessAttemptMonoid->append(a :: Failure, b) = b
 * $firstSuccessAttemptMonoid->append(a, b) = a
 *
 * In words, if the first arguemnt is a Failure, the second argument is the result;
 * otherwise the first argument is the result.  Therefore, the wrapped values
 * are never appended.
 */
class FirstSuccessAttemptMonoid implements Monoid {

  private $failureInnerMonoid;

  public function __construct(Monoid $failureInnerMonoid) {
    $this->failureInnerMonoid = $failureInnerMonoid;
  }

  public function identity() {
    return Attempt::failure($this->failureInnerMonoid->identity());
  }

  public function append($first, $second) {
    return $first->isFailure() ? $second : $first;
  }
}
