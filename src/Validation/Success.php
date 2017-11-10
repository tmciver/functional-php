<?php

namespace TMciver\Functional\Validation;

class Success extends Validation {

  private $val;

  protected function __construct($val) {
    $this->val = $val;
  }

  /* function map(callable $f) { */

  /*   // Since we don't know if $f will throw an exception, we wrap the call */
  /*   // in a try/catch. The result wiil be Nothing if there's an exception. */
  /*   try { */
  /*     $ret = call_user_func($f, $this->val); */
  /*     $validationResult = Validation::fromValue($ret); */
  /*   } catch (\Exception $e) { */
  /*     $validationResult = self::fail(); */
  /*   } */

  /*   return $validationResult; */
  /* } */

  public function append($other) {
    return $other->appendToSuccess($this);
  }

  protected function appendToSuccess($leftSuccess) {
    return $leftSuccess;
  }

  protected function appendToFailure($leftFailure) {
    return $this;
  }
}