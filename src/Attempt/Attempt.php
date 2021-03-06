<?php

namespace PhatCats\Attempt;

use PhatCats\ObjectTypeclass\ObjectMonad;
use PhatCats\ObjectTypeclass\ObjectMonoid;

abstract class Attempt {
  use ObjectMonad;

    public static function fromValue($val, $errorMsg = 'Attempted to create PhatCats\Attempt\Success with a null value.') {
        if (is_null($val)) {
            $try = self::fail($errorMsg);
        } else {
            $try = new Success($val);
        }

        return $try;
    }

    public static function failure($val) {
        if (is_null($val)) {
            $try = self::fail('Attempted to create PhatCats\Attempt\Failure with a null value.');
        } else {
            $try = new Failure($val);
        }

        return $try;
    }

    public function pure($val) {
	return self::fromValue($val);
    }

    public function fail($msg = 'There was a problem; calling `Attempt::fail()`.') {
	return self::failure($msg);
    }

    public function identity() {
        return new Failure('');
    }

    protected abstract function applyToSuccess($success);

    public abstract function getOrElse($default);

    /**
     * Calls the Callable $f (or not) in a sub-class-specific way.
     * @param Callable $f the Callable to (optionally) call.
     * @param array $args The arguments to pass to the Callable $f. The array
     * length must be equal to the number of arguments expected by $f.
     * @return An instance of Maybe.
     */
    public abstract function orElse(callable $f, array $args);

    /**
     * Gives the caller the opportunity to recover from a failure. The provided
     * callable is only called for a `Failure` case.
     *
     * @f callable a function of one argument the type of which is the type of
     *    value held in the `Failure` case and returns an instance of
     *    `Attempt` (usually a `Success).
     */
    public abstract function catch(callable $f);

    /**
     * @return True if this object is an instance of the Failure class; false
     * otherwise.
     */
    public abstract function isFailure();

    public abstract function accept($tryVisitor);
}
