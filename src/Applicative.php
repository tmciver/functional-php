<?php

namespace TMciver\Functional;

use TMciver\Functional\Functor;

/**
 * A fuctor with application. An applicative containing a function can be
 * applied to an argument contained in another applicative.
 */
trait Applicative {
    use Functor;

    protected $val;

    /**
     * @param A value to be put into a minimal context.
     * @return The given value in a context.
     */
    abstract public function pure($val);

    /**
     * Partially applies the function contained in this Applicative to the value
     * contained in the given applicative argument.
     *
     * @param $applicativeArgument An object whose class implements the Applicatie
     *        trait.
     * @return An Applicative of the same class as this one containing either
     *         another partially-applied function or a non-function value.
     */
    final function apply($applicativeArgument) {
      // Wrap the applicative value in a PartialFunction,
      // if it is not already.
      $pf = $this->val instanceof PartialFunction ?
	$this->val :
	new PartialFunction($this->val);

      return $applicativeArgument->map($pf);
    }

    /**
     * The __invoke magic method allows the Applicative to be called like a
     * normal function but whose implementation gives it the Applicative
     * behavior. The implementation of __invoke should handle being called with
     * zero or more arguments and "do the right thing."
     * @return The value returned by applying the function in a context to one
     *         or more values in a context. This value is itself put into a
     *         context: the same context as this one.
     */
    public function __invoke() {
      $args = func_get_args();
      $callback = function ($applicativeFun, $applicativeArg) {
	return $applicativeFun->apply($applicativeArg);
      };
      $result = array_reduce($args, $callback, $this);

      return $result;
    }
}
