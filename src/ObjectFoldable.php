<?php

namespace TMciver\Functional;

trait ObjectFoldable {
  // not sure if it's a good idea to extend Collection . . .
  use Collection;

  /**
   * Left-associative fold of a structure.
   *
   * @param $init The seed value for the fold. This value is the result in the
   *        case of an empty structure.
   * @param $f The folding function. A function of two arguments: the first
   *        argument should be of the same type as $init (and the return type);
   *        the second argument is an element of the `ObjectFoldable` structure.
   * @return A value that has the same type as $init.
   */
  abstract function foldLeft($init, callable $f);

  /**
   * Right-associative fold of a structure.
   *
   * @param $init The seed value for the fold. This value is the result in the
   *        case of an empty structure.
   * @param $f The folding function. A function of two arguments: the first
   *        argument is an element of the `ObjectFoldable` structure; the second
   *        should be of the same type as $init (and the return type).
   * @return A value that has the same type as $init.
   */
  abstract function foldRight($init, callable $f);

  /**
   * Folds the structure by mapping each element to a Monoid (using $toMonoid)
   * and then combining the results using that Monoid.
   *
   * This method has a default implementation (which uses foldLeft) but can be
   * overridden if a given type can provide a more efficient implementation.
   *
   * @param $monoid an instance of a monoid. Should be the same type as the
   *        return type of $toMonoid as well as the return type of foldMap.
   *        Needed for the case of an empty structure.
   * @param $toMonoid A function that takes an element of the structure and
   *        returns a Monoid.
   * @return A value that has the same type as the return type of $toMonoid and
   *         $monoid.
   */
  public function foldMap($monoid, callable $toMonoid) {
    $init = $monoid->identity();
    $f = function ($acc, $x) use ($toMonoid) {
      return $acc->append($toMonoid($x));
    };

    return $this->foldLeft($init, $f);
  }

  /**
   * Folds the structure by combining elements using a monoid. Note that the
   * elements must already be a monoid.
   *
   * This method has a default implementation (which uses foldMap) but can be
   * overridden if a given type can provide a more efficient implementation.
   *
   * @param $monoid an instance of a monoid. Should be the same type as the
   *        elements. Needed for the case of an empty structure.
   * @return a value of the same type as the elements.
   */
  public function fold($monoid) {
    $id = function ($x) { return $x; };
    return $this->foldMap($monoid, $id);
  }
}
