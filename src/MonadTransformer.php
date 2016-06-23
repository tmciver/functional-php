<?php

namespace TMciver\Functional;

/**
 * MonadTransformer is a monad that exists so that `bind` does the "right thing"
 * for the stack of monads which it contains.  If MonadTransformer represents
 * the monad stack F (G a), then `bind` will accept a function whose type is
 * `a -> G b` and calling `bind` on this function will return a MonadTransformer
 * representing the monad stack F (G b).
 *
 * MonadTransformer will probably most commonly be used to represent the monad
 * stack `Either (Maybe a)`, which represents the result of a function that can
 * fail but, if it does not fail, can have no value. As a concrete example,
 * let's create such a monad stack *without* the use of MonadTransformer:
 *
 * $monadStack = new Right(new Just("Hello"));
 *
 * That value represents a monad stack with the type `Either (Maybe String)`.
 * Now, say we have the function `firstLetter`, which takes a string and returns
 * `Nothing` if the string was empty or `Just c` where `c` is the first letter
 * of the string, and we'd like to apply this function to the String wrapped in
 * the above monad stack. Without MonadTransformer the following would be
 * required to do this:
 *
 * $newMonadStack = $monadStack->bind(function ($innerMonad) use ($monadStack) {
 *    return $monadStack->pure($innerMonad->bind(function ($str) {
 *       return firstLetter($str);
 *    }));
 * });
 *
 * Now, let's try that again using MonadTransformer:
 * 
 * $mt = new MonadTransformer(new Right(new Just("Hello")));
 *
 * This time, to apply `firstLetter` to the wrapped string, we simply do:
 *
 * $newMt = $mt->bind(function ($str) {
 *    return firstLetter($str);
 * });
 *
 * Or, even more succinctly:
 *
 * $newMt = $mt->bind('firstLetter');
 */
class MonadTransformer {

    public $outerMonad;

    public function __construct($someMonad) {
	$this->outerMonad = $someMonad;
    }

    /**
     * @param $f should be a function from a value of type `a` to a value of
     *        type `F b` where `F` is the type of the inner monad.
     *
     * @return an instance of `MonadTransformer` containing an instance of the
     *         same value of the original outer monad. This monad, in turn, will
     *         contain the monad returned by $f.
     */
    public function bind(callable $f) {
	return new MonadTransformer($this->outerMonad->bind(
	    function ($innerMonad) use ($f) {
		return $this->outerMonad->pure($innerMonad->bind($f));
	    }
	));
    }
}
