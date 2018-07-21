<?php

namespace TMciver\Functional\Typeclass;

abstract class BaseApplicative extends DefaultFunctor implements Applicative {

  function apply($ff, $fa = null) {
    return $ff->apply($fa);
  }
}
