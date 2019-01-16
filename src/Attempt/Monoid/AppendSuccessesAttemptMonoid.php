<?php

namespace PhatCats\Attempt\Monoid;

use PhatCats\Typeclass\Monoid;
use PhatCats\Attempt\Attempt;
use PhatCats\Attempt\AttemptVisitor;

/*
 * This Attempt monoid is a Success-preferring monoid and, in the case of two
 * Successs, will append the inner values.  In particular, it has this behavior:
 *
 * $appendSuccesssAttemptMonoid->append($a :: Failure, $b) = $b
 * $appendSuccesssAttemptMonoid->append($a, $b :: Failure) = $a
 * $appendSuccesssAttemptMonoid->append($a :: Success, $b :: Success) =
 *      Success($innerMonoid->append($a->val, $b->val))
 *
 * In words, if only one of the values being appended is a Success, then that is
 * the result, otherwise they are both Successs and the inner values are appended
 * using the provided monoid and the result is then wrapped in a Success.  If they
 * are both Failures, the Failure on the success is the result.
 */
class AppendSuccesssAttemptMonoid implements Monoid {

  private $successInnerMonoid;

  public function __construct(Monoid $successInnerMonoid) {
    $this->successInnerMonoid = $successInnerMonoid;
  }

  public function identity() {
    return Attempt::fromValue($this->successInnerMonoid->identity());
  }

  public function append($first, $second) {
    // Boy, the Visitor Pattern can get complicated!
    return $first->accept(new class($second, $this->successInnerMonoid) implements AttemptVisitor {
        private $second;
        private $innerMonoid;

        function __construct ($second, $innerMonoid) {
          $this->second = $second;
          $this->innerMonoid = $innerMonoid;
        }

        function visitFailure($failure) {
          return $this->second;
        }

        function visitSuccess($success) {
          return $this->second->accept(new class($success, $this->innerMonoid) implements AttemptVisitor {
              private $firstSuccess;
              private $innerMonoid;

              function __construct ($firstSuccess, $innerMonoid) {
                $this->firstSuccess = $firstSuccess;
                $this->innerMonoid = $innerMonoid;
              }

              function visitFailure($failure) {
                return $this->firstSuccess;
              }

              function visitSuccess($secondSuccess) {
                return Attempt::fromValue($this->innerMonoid->append($this->firstSuccess->get(), $secondSuccess->get()));
              }
            });
        }
      });
  }
}
