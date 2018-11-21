<?php

namespace TMciver\Functional\Typeclass;

/**
 * Applicative to be used as the basis for an Applicative for a type that uses
 * the `ObjectApplicative` trait or otherwise has an implementation for the
 * `map` method.
 */
abstract class BaseApplicativeForObjectApplicative extends BaseApplicative {

  public function apply($ff, $fa = null) {
    return $ff->apply($fa);
  }

  public function map($ma, callable $f) {
    return $ma->map($f);
  }
}
