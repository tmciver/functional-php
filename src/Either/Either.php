<?php

namespace TMciver\Functional\Either;

use TMciver\Functional\Monad;
use TMciver\Functional\ObjectMonoid;
use TMciver\Functional\Either\Right;

abstract class Either {
    use ObjectMonoid, Monad;

    public static function fromValue($val, $errorMsg = 'Attempted to create TMciver\Functional\Either\Right with a null value.') {
        if (is_null($val)) {
            $either = self::fail($errorMsg);
        } else {
            $either = new Right($val);
        }

        return $either;
    }

    public static function left($val) {
        if (is_null($val)) {
            $either = self::fail('Attempted to create TMciver\Functional\Either\Left with a null value.');
        } else {
            $either = new Left($val);
        }

        return $either;
    }

    public function pure($val) {
	return self::fromValue($val);
    }

    public function fail($msg = 'There was a problem; calling `Either::fail()`.') {
	return self::left($msg);
    }

    public function identity() {
        return new Left('');
    }

    protected abstract function applyToRight($right);

    /**
     * Function for doing double dispatch from Right::append.
     */
    protected abstract function appendRight($right);

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
     * @return True if this object is an instance of the Left class; false
     * otherwise.
     */
    public abstract function isLeft();

    public abstract function accept($eitherVisitor);
}
