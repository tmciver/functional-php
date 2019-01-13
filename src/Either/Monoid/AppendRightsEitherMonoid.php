<?php

namespace TMciver\Functional\Either\Monoid;

use TMciver\Functional\Typeclass\Monoid;
use TMciver\Functional\Either\Either;
use TMciver\Functional\Either\EitherVisitor;

/*
 * This Either monoid is a Right-preferring monoid and, in the case of two
 * Rights, will append the inner values.  In particular, it has this behavior:
 *
 * $appendRightsEitherMonoid->append($a :: Left, $b) = $b
 * $appendRightsEitherMonoid->append($a, $b :: Left) = $a
 * $appendRightsEitherMonoid->append($a :: Right, $b :: Right) =
 *      Right($innerMonoid->append($a->val, $b->val))
 *
 * In words, if only one of the values being appended is a Right, then that is
 * the result, otherwise they are both Rights and the inner values are appended
 * using the provided monoid and the result is then wrapped in a Right.  If they
 * are both Lefts, the Left on the right is the result.
 */
class AppendRightsEitherMonoid implements Monoid {

  private $rightInnerMonoid;

  public function __construct(Monoid $rightInnerMonoid) {
    $this->rightInnerMonoid = $rightInnerMonoid;
  }

  public function identity() {
    return Either::fromValue($this->rightInnerMonoid->identity());
  }

  public function append($first, $second) {
    // Boy, the Visitor Pattern can get complicated!
    return $first->accept(new class($second, $this->rightInnerMonoid) implements EitherVisitor {
        private $second;
        private $innerMonoid;

        function __construct ($second, $innerMonoid) {
          $this->second = $second;
          $this->innerMonoid = $innerMonoid;
        }

        function visitLeft($left) {
          return $this->second;
        }

        function visitRight($right) {
          return $this->second->accept(new class($right, $this->innerMonoid) implements EitherVisitor {
              private $firstRight;
              private $innerMonoid;

              function __construct ($firstRight, $innerMonoid) {
                $this->firstRight = $firstRight;
                $this->innerMonoid = $innerMonoid;
              }

              function visitLeft($left) {
                return $this->firstRight;
              }

              function visitRight($secondRight) {
                return Either::fromValue($this->innerMonoid->append($this->firstRight->get(), $secondRight->get()));
              }
            });
        }
      });
  }
}
