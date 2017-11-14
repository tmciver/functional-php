<?php

namespace TMciver\Functional;

class PartialFunction {

  private $f;
  private $numArgsRemaining;
  private $args;

  public function __construct(callable $f, $args = []) {
    $this->f = $f;
    $this->args = $args;

    // calculate the number of remaining arguments
    $rf = new \ReflectionFunction($f);
    $numArgsNeeded = $rf->getNumberOfParameters();
    $numArgsProvided = count($args);
    $this->numArgsRemaining = $numArgsNeeded - $numArgsProvided;
  }

  public function __invoke() {
    $args = func_get_args();
    $allArgs = array_merge($this->args, $args);
    $numArgs = count($allArgs);
    $numArgsRemaining = $this->numArgsRemaining - $numArgs;

    return ($numArgsRemaining > 0) ?
      new PartialFunction($this->f, $allArgs) :
      call_user_func_array($this->f, $allArgs);
  }
}