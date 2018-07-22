<?php

namespace TMciver\Functional\Validation;

use TMciver\Functional\Typeclass\BaseApplicative;

class ValidationApplicative extends BaseApplicative {

  public function pure($v) {
    return is_null($v) ?
      new Failure("Error: called ValidationApplicative::pure with a null value.") :
      new Success($v);
  }
}
