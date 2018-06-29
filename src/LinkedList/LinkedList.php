<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\Foldable;
use TMciver\Functional\Traversable;
use TMciver\Functional\Monad;
use TMciver\Functional\Monoid;
use TMciver\Functional\Maybe\Maybe;
use TMciver\Functional\Maybe\MaybeVisitor;
use TMciver\Functional\Tuple;

abstract class LinkedList {
  use Foldable, Traversable, Monoid, Monad;

  public static $CONS_CELL_LIMIT = 32;
  public static $TO_STRING_MAX = 10;

  private $str;

  /**
   * Adds the given value to the head of this list.
   * @param $value The value to add.
   */
  public function add($value) {
    if ($this->numConsCells() + 1 > self::$CONS_CELL_LIMIT) {
      $tmpList = new Cons($value, $this);
      return new ArrayBackedLinkedList($tmpList->toNativeArray());
    } else {
      return new Cons($value, $this);
    }
  }

  /**
   * Alias for Collection::add
   */
  public function cons($value) {
    return $this->add($value);
  }

  protected abstract function numConsCells();

  /**
   * @return TMciver\Functional\Maybe\Maybe containing value.
   */
  public abstract function head();

  /**
   * @return the tail of this LinkedList as LinkedList.
   */
  public abstract function tail();

  /**
   * @param $n the number of elements of the LinkedList to take.
   * @return A new LinkedList of the first $n elements of this LinkedList.
   *         Returns an empty LinkedList if this LinkedList is empty.
   */
  public abstract function take($n);

  /**
   * @param $n the number of elements of the LinkedList to drop.
   * @return A new LinkedList containing all of this LinkedList but the first $n
   *         elements. Returns an empty LinkedList if this LinkedList is empty.
   */
  public abstract function drop($n);

  /**
   * @return True is this LinkedList is empty, False otherwise.
   */
  public abstract function isEmpty();

  public function fail() {
    return (new LinkedListFactory())->empty();
  }

  public function pure($val) {
    return (new LinkedListFactory())->pure($val);
  }

  final public function concat($otherList) {
    return $this->append($otherList);
  }

  final public function toNativeArray() {
    // initialize an array of the proper size with NULLs
    $array = array_fill(0, $this->size(), NULL);

    return $this->toNativeArrayPrivate($array, 0);
  }

  protected abstract function toNativeArrayPrivate(array &$array, $idx);

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
	  $returnedMonad = $monad->fail('The callable passed to `LinkedList::traverse` returned null.');
	}
      } catch (\Exception $e) {
	$returnedMonad = $monad->fail('The callable passed to `LinkedList::traverse` threw an exception: ' . $e->getMessage());
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

  public final function __toString() {
    if (is_null($this->str)) {
      // Take no more than self::$TO_STRING_MAX elements to stringify
      $toStringify = $this->take(self::$TO_STRING_MAX);

      // Initialize an accumulator to be used in the subsequent fold based on
      // whether the list contains at lease one element.
      $acc = $this->head()->accept(new class implements MaybeVisitor {
	  function visitNothing($nothing) { return "LinkedList("; }
	  function visitJust($just) { return "LinkedList(" . (string)$just->get(); }
	});

      // Stringify the tail of $toStringify
      $tmpStr = $toStringify->tail()->foldLeft($acc, function ($acc, $x) {
	  return $acc . ", " . (string)$x;
	});

      // Complete stringification and assign to $this->str
      $this->str = ($this->size() > $toStringify->size()) ?
	$tmpStr . ", . . .)" :
	$tmpStr . ")";
    }

    return $this->str;
  }

  public function interleave($other) {

    // Get the next vals for each of the lists.
    // :: Maybe a
    $maybeV1 = $this->head();
    $maybeV2 = $other->head();

    // Function to cons both values to the interleaved tail.
    // :: a -> a -> LinkedList a
    $consTwo = function ($v1, $v2) use ($other) {
      // First, interleave the tails of both lists.
      $interleavedTail = $this->tail()->interleave($other->tail());

      // Cons the two elements onto it.
      return $interleavedTail->cons($v2)->cons($v1);
    };

    // Put the function into the Maybe context
    // :: Maybe (a -> a -> LinkedList a)
    $maybeConsTwo = Maybe::fromValue($consTwo);

    // Apply the function applicatively and match on the result.
    // If the result is Nothing, then we've reached the end of one list and we
    // return the emtpy list. Otherwise, we return the previously constructed
    // tail.
    return $maybeConsTwo($maybeV1, $maybeV2)->accept(new class implements MaybeVisitor {
	function visitNothing($nothing) { return new Nil(); }
	function visitJust($just) { return $just->get(); }
      });
  }

  /**
   * @return A new LinkedList whose elements are the same as this one but sorted
   *         using PHP's standard `sort` function.
   */
  public final function sort() {
    $arr = $this->toNativeArray();
    sort($arr);

    return new ArrayBackedLinkedList($arr);
  }

  /**
   * @param $i :: int The index of the desired `LinkedList` element.
   * @return :: Maybe[a] The desired `LinkedList` element wrapped in a `Maybe`.
   */
  abstract public function nth(int $i): Maybe;

  /**
   * @param $f :: a -> bool. A predicate.
   * @return LinkedList. Returns a prefix of this LinkedList up until the first
   *         element that does not satisfy the predicate.
   */
  abstract public function takeWhile(callable $f): LinkedList;

  /**
   * @param $f :: a -> bool. A predicate.
   * @return LinkedList. Returns a suffix of this LinkedList after, and
   *         including, the first element that does not satisfy the predicate.
   */
  abstract public function dropWhile(callable $f): LinkedList;

  /**
   * @param $i :: int The index at which to split this `LinkedList`.
   * @return :: Tuple. Returns a `Tuple` whose first element is the prefix of
   *         this `LinkedList` of length $i and second element is the remainder
   *         of the `LinkedList`.
   */
  abstract public function splitAt(int $i);

  /**
   * @param $f :: a -> bool. A predicate that takes an element of the
   *        `LinkedList` and returns a bool.
   * @return Tuple[LinkedList, LinkedList]. A tuple whose first element is a
   *         `LinkedList` of all the elements of this `LinkedList` that satisfy
   *         the predicate; the second element of the tuple is a `LinkedList`
   *         whose element did not satisfy the predicate.
   */
  final public function partition(callable $f) {
    // TODO: find a more efficient version (probably using `foldRight`); this
    // one requires two traversals (although, an implementation using
    // `foldRight` would necessitate the creation of `n` Tuple objects).
    $left = $this->filter($f);
    $right = $this->filter(function ($x) use ($f) { return !$f($x); });
    return new Tuple($left, $right);
  }
}
