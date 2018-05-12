<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\Foldable;
use TMciver\Functional\Traversable;
use TMciver\Functional\Monad;
use TMciver\Functional\Monoid;

abstract class LinkedList {
  use Foldable, Traversable, Monoid, Monad;

  /**
   * Alias for Collection::add
   */
  public function cons($value) {
    return $this->add($value);
  }

  /**
   * @return TMciver\Functional\Maybe\Maybe containing value.
   */
  public abstract function head();

  /**
   * @return the tail of this LinkedList as LinkedList.
   */
  public abstract function tail();

  public function fail() {
    return (new LinkedListFactory())->empty();
  }

  public function pure($val) {
    return (new LinkedListFactory())->pure($val);
  }

  final public function concat($otherList) {
    return $this->append($otherList);
  }

  public abstract function toNativeArray();

  final public function identity() {
    return (new LinkedListFactory())->empty();
  }

  final public function toLinkedList() {
    return $this;
  }

  final public function traverse(callable $f, $monad) {
    // Initial value for the fold: an empty array wrapped in a default
    // context.
    $init = $monad->pure(new Nil());

    // Define the folding function.
    // $acc :: Monad m => m[LinkedList]
    $foldingFn = function ($curr, $acc) use ($f, $monad) {

      // Call $f on the current value of the LinkedList, $curr. The return
      // value should be a monadic value.
      try {
	$returnedMonad = $f($curr);

	// If the result is null, we fail.
	if (is_null($returnedMonad)) {
	  $returnedMonad = $monad->fail('A call the callable passed to `LinkedList::traverse` returned null.');
	}
      } catch (\Exception $e) {
	$returnedMonad = $monad->fail('A call the callable passed to `LinkedList::traverse` threw an exception: ' . $e->getMessage());
      }

      // Put the value wrapped by the above monadic value in the array
      // held by the accumulator, $acc, to get the new accumulator.
      $newAcc = $returnedMonad->flatMap(function ($newVal) use ($acc) {
	  return $acc->map(function ($list) use ($newVal) {
	      return $list->cons($newVal);
	    });
	});

      return $newAcc;
    };

    // Finally, perform the fold.
    return $this->foldRight($init, $foldingFn);
  }
}
