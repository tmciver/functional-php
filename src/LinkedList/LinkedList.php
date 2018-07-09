<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\ObjectFoldable;
use TMciver\Functional\ObjectTraversable;
use TMciver\Functional\ObjectMonad;
use TMciver\Functional\ObjectTypeclasses\ObjectMonoid;
use TMciver\Functional\Maybe\Maybe;
use TMciver\Functional\Maybe\MaybeVisitor;
use TMciver\Functional\Tuple;

abstract class LinkedList {
  use ObjectFoldable, ObjectTraversable, ObjectMonoid, ObjectMonad;

  public static $CONS_CELL_LIMIT = 32;
  public static $TO_STRING_MAX = 10;

  private $str;
  protected $factory;

  public function __construct(LinkedListFactory $factory) {
    $this->factory = $factory;
  }

  /**
   * Adds the given value to the head of this list.
   * @param $value The value to add.
   */
  public function add($value) {
    if ($this->numConsCells() + 1 > self::$CONS_CELL_LIMIT) {
      $tmpList = new Cons($value, $this, $this->factory);
      return new ArrayBackedLinkedList($tmpList->toNativeArray(), $this->factory);
    } else {
      return new Cons($value, $this, $this->factory);
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
    $init = $monad->pure($this->factory->empty());

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
    // TODO Come up with more efficient version.

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

    // Apply the function applicatively and get the result (default of empty list).
    // If the result is Nothing, then we've reached the end of one list and we
    // return the emtpy list. Otherwise, we return the previously constructed
    // tail.
    $interleaved = $maybeConsTwo($maybeV1, $maybeV2)->getOrElse($this->factory->empty());

    return $interleaved;
  }

  /**
   * @return A new LinkedList whose elements are the same as this one but sorted
   *         using PHP's standard `sort` function.
   */
  public final function sort() {
    $arr = $this->toNativeArray();
    sort($arr);

    return $this->factory->fromNativeArray($arr);
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

  public function zip(LinkedList $other) {
    // TODO Come up with more efficient version.

    // Get the next vals for each of the lists.
    // :: Maybe a
    $maybeV1 = $this->head();
    $maybeV2 = $other->head();

    // Function to zip both values to the zipped tail.
    // :: a -> a -> LinkedList[Tuple[a, b]]
    $zipTwo = function ($v1, $v2) use ($other) {
      // First, zip the tails of both lists.
      $zippedTail = $this->tail()->zip($other->tail());

      // Zip a Tuple of the two elements onto it.
      return $zippedTail->cons(new Tuple($v1, $v2));
    };

    // Put the function into the Maybe context
    // :: Maybe (a -> a -> LinkedList a)
    $maybeZipTwo = Maybe::fromValue($zipTwo);

    // Apply the function applicatively and get the result (default of empty list).
    // If the result is Nothing, then we've reached the end of one list and we
    // return the emtpy list. Otherwise, we return the previously constructed
    // tail.
    $zipped = $maybeZipTwo($maybeV1, $maybeV2)->getOrElse($this->factory->empty());

    return $zipped;
  }

  /**
   * @param $sep :: a. A value whose type shoule be the same as the type of
   *        elements of this `LinkedList`.
   * @return A new `LinkedList` which is this `LinkedList` with $sep element
   *         inserted between it's elements. For example, if you have a
   *         `LinkedList` `$l = LinkedList(1, 1, 1)` and you call
   *         `$l->intersperse(2)`, you'll get `LinkedList(1, 2, 1, 2, 1)`.
   */
  final public function intersperse($sep) {
    // Create an infinite list where each element is $sep.
    $factory = new LinkedListFactory();
    $seps = $factory->repeat($sep);

    // Interleave the infinite list of $sep with this list.
    $l = $seps->interleave($this);

    // This *almost* creates the list that we want - except it has an extra $sep
    // at the head. So, we just take the tail.
    return $l->tail();
  }

  /**
   * @return A `LinkedList` that contains the elements of this `LinkedList` in
   *         reverse order.
   */
  final public function reverse() {
    $cons = function ($acc, $x) { return $acc->cons($x); };
    $emptyList = (new LinkedListFactory())->empty();
    return $this->foldLeft($emptyList, $cons);
  }
}
