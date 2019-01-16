<?php

namespace PhatCats\Validation;

use PhatCats\Typeclass\Applicative;
use PhatCats\Typeclass\SemiGroup;

class ValidationApplicative implements Applicative {

  private $failureSemigroup;

  function __construct(SemiGroup $failureSemigroup) {
    $this->failureSemigroup = $failureSemigroup;
  }

  public function pure($v) {
    return is_null($v) ?
      new Failure("Error: called ValidationApplicative::pure with a null value.") :
      new Success($v);
  }

  function map($v, callable $f) {
    return $v->map($f);
  }

  function apply($ff, $fa = null) {
    return $ff->apply($fa, $this->failureSemigroup);
  }
}
