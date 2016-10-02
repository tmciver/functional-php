<?php

namespace TMciver\Functional;

// Just a wrapper around the native PHP array to allow for cool FP goodness.
class AssociativeArray {
    use Traversable;

    protected $array;

    public function __construct($array) {
        $this->array = $array;
    }

    public function traverse(callable $f, $monad) {

	// Initial value for the fold: an empty array wrapped in a default
	// context.
	$init = $monad->pure([]);

	// Define the folding function.
	$foldingFn = function ($acc, $curr) use ($f) {

	    // Call $f on the current value of the array, $curr. The return
	    // value should be a monadic value.
	    $returnedMonad = $f($curr);

	    // Put the value wrapped by the above monadic value in the array
	    // held by the accumulator, $acc, to get the new accumulator.
	    $newAcc = $returnedMonad->flatMap(function ($newVal) use ($acc) {
		return $acc->map(function ($arr) use ($newVal) {
		    $arr[] = $newVal;
		    return $arr;
		});
	    });

	    return $newAcc;
	};

	// Do the fold.
	$result = array_reduce($this->array, $foldingFn, $init);

	return $result;
    }
}
