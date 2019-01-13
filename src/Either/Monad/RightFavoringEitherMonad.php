<?php

namespace TMciver\Functional\Either\Monad;

use TMciver\Functional\Typeclass\BaseMonad;
use TMciver\Functional\Either\Right;
use TMciver\Functional\Either\Either;
use TMciver\Functional\PartialFunction;

class RightFavoringEitherMonad extends BaseMonad {

  public function pure($v) {
    return is_null($v) ?
      Either::left("Error: called EitherMonad::pure with a null value.") :
      new Right($v);
  }

  /**
   * @see \TMciver\Functional\Typeclass\Functor::map()
   */
  public function map($either, callable $f) {
    if ($either->isLeft()) {
      return $either;
    } else {
      $val = $either->get();

      try {
        $eitherVal = new Right($f($val));
      } catch (\Exception $e) {
        $eitherVal = Either::left('Got an exception when calling the callable passed to ' . get_class($this) . '::map()');
      }

      return $eitherVal;
    }
  }

  /**
   * @see \TMciver\Functional\Typeclass\Monad::flatMap()
   */
  public function flatMap($either, callable $f) {
    if ($either->isLeft()) {
      return $either;
    } else {
      $val = $either->get();

      try {
        $eitherVal = $f($val);
      } catch (\Exception $e) {
        $eitherVal = Either::left('Got an exception when calling the callable passed to ' . get_class($this) . '::flatMap()');
      }

      return $eitherVal;
    }
  }

  public function join($eitherEither) {
    return $eitherEither->isLeft() ?
      $eitherEither :
      $eitherEither->get();
  }

  public function apply($eitherF, $eitherArg = null) {
    if ($eitherF->isLeft()) {
      return $eitherF;
    } else {
      $f = $eitherF->get();

      // Wrap the applicative value in a PartialFunction, if it // is not already.
      $pf = $f instanceof PartialFunction ? $f : new PartialFunction($f);

      if (is_null($eitherArg)) {
        // There are no arguments passed in so we attempt to call the wrapped callable without arguments.
        try {
          $val = $pf();
          if (is_null($val)) {
            $eitherVal = Either::left('Got a null value when calling the no-argument callable passed to ' . get_class($this) . '::apply()');
          } else {
            $eitherVal = new Right($val);
          }
        } catch (\Exception $e) {
          $eitherVal = Either::left('Got an exception when calling the callable passed to ' . get_class($this) . '::flatMap()');
        }
      } else {
        // We have wrapped arguments.
        $eitherVal = $this->map($eitherArg, $pf);
      }

      return $eitherVal;
    }
  }

  public function fail($message = 'Unknown failure.') {
    return Either::left($message);
  }

  public function getOrElse($either, $ifLeft) {
    return $either->isLeft() ?
      $ifLeft :
      $either->get();
  }
}
