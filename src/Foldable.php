<?php

namespace TMciver\Functional;

trait Foldable {
  // not sure if it's a good idea to extend Collection . . .
  use Collection;

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
   * Right-associative fold of a structure.
   *
   * @param $init The seed value for the fold. This value is the result in the
   *        case of an empty structure.
   * @param $f The folding function. A function of two arguments: the first
   *        argument is an element of the `Foldable` structure; the second
   *        should be of the same type as $init (and the return type).
   * @return A value that has the same type as $init.
   */
  abstract function foldRight($init, callable $f);

  public function foldMap($monoid, callable $toMonoid) {
    $init = $monoid->identity();
    $f = function ($acc, $x) use ($toMonoid) {
      return $acc->append($toMonoid($x));
    };

    return $this->foldLeft($init, $f);
  }
}
