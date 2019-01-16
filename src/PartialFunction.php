<?php

namespace PhatCats;

use TRex\Reflection\CallableReflection;

class PartialFunction {

  private $f;
  private $numArgsRemaining;
  private $args;

  public function __construct(callable $f, $args = []) {
    $this->f = $f;
    $this->args = $args;

    // calculate the number of remaining arguments
    $cr = new CallableReflection($f);
    $rf = $cr->getReflector();
    $numArgsNeeded = $rf->getNumberOfParameters();
    $numArgsProvided = count($args);
    $this->numArgsRemaining = $numArgsNeeded - $numArgsProvided;
  }

  public function __invoke() {
    $args = func_get_args();
    $numArgs = count($args);
    $numArgsRemaining = $this->numArgsRemaining - $numArgs;
    $allArgs = array_merge($this->args, $args);

    return ($numArgsRemaining > 0) ?
      new PartialFunction($this->f, $allArgs) :
      call_user_func_array($this->f, $allArgs);
  }
}