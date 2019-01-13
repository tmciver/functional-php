<?php

namespace TMciver\Functional\Typeclass;

/**
 * An abstract class implementing the Applicative interface containing an
 * implementation of the `__invoke()` magic method for convenience.  Any custom
 * Applicative instance you may write should extend this class.
 */
abstract class BaseApplicative implements Applicative {

  function __invoke() {
    // $ff, ...$fas
    $args = func_get_args();

    // make sure we were given at least one argument.
    if (count($args) < 1) {
      throw new \Exception('Must call Applicative::__invoke() with at least one argument.');
    }

    // Get Applicative function.
    $ff = $args[0];

    // Get the Applicative arguments.
    array_shift($args);
    $fas = $args;

    $numArgs = count($fas);
    if ($numArgs > 0) {
      $callback = function ($applicativeFun, $applicativeArg) {
        return $applicativeFun->apply($applicativeArg);
      };
      $result = array_reduce($fas, $callback, $ff);
    } else {
      $result = $this->apply($ff);
    }

    return $result;
  }
}
