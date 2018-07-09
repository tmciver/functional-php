<?php

namespace TMciver\Functional\ObjectTypeclasses;

/**
 * A fuctor with application. An applicative containing a function can be
 * applied to an argument contained in another applicative.
 */
trait ObjectApplicative {
    use ObjectFunctor;

    /**
     * @param A value to be put into a minimal context.
     * @return The given value in a context.
     */
    abstract public function pure($val);

    /**
     * Partially applies the function contained in this ObjectApplicative to the value
     * contained in the given applicative argument.
     *
     * @param $applicativeArgument | null: An object whose class implements the
     *        Functor trait. If null is passed, then the wrapped function
     *        should be called without arguments.
     * @return An ObjectApplicative of the same class as this one containing either
     *         another partially-applied function or a non-function value.
     */
    final public function apply($applicativeArgument = null) {
      return is_null($applicativeArgument) ?
	$this->applyNoArg() :
	$this->applyToArg($applicativeArgument);
    }

    /**
     * Calls the wrapped function with no arguments.
     */
    protected abstract function applyNoArg();

    /**
     * Calls the wrapped function on the value wrapped in the supplied argument.
     */
    protected abstract function applyToArg($applicativeArgument);

    /**
     * The __invoke magic method allows the ObjectApplicative to be called like a
     * normal function but whose implementation gives it the ObjectApplicative
     * behavior. The implementation of __invoke should handle being called with
     * zero or more arguments and "do the right thing."
     * @return The value returned by applying the function in a context to one
     *         or more values in a context. This value is itself put into a
     *         context: the same context as this one.
     */
    public function __invoke() {
      $args = func_get_args();
      $numArgs = count($args);

      if ($numArgs > 0) {
	$callback = function ($applicativeFun, $applicativeArg) {
	  return $applicativeFun->apply($applicativeArg);
	};
	$result = array_reduce($args, $callback, $this);
      } else {
	$result = $this->apply();
      }

      return $result;
    }
}
