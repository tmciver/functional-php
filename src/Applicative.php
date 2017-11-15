<?php

namespace TMciver\Functional;

use TMciver\Functional\Functor;

trait Applicative {
    use Functor;

    protected $val;

    /**
     * @param A value to be put into a minimal context.
     * @return The given value in a context.
     */
    final public function pure($val) {
      $newVal = is_callable($val) ?
	new PartialFunction($val) :
	$val;

      return $this->realPure($newVal);
    }

    abstract function realPure($val);

    /**
     * A fuctor with application. An applicative containing a function can be
     * applied to an argument contained in another applicative.
     *
     * @param $applicativeArgument An object whose class implements the Applicatie
     *        trait.
     * @return An Applicative of the same class as this one containing either
     *         another partially-applied function or a non-function value.
     */
    final function apply($applicativeArgument) {
      return $applicativeArgument->map($this->val);
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
