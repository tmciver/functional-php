<?php

namespace TMciver\Functional\Either\Monad;

use TMciver\Functional\Typeclass\Monad;
use TMciver\Functional\Either\Right;
use TMciver\Functional\Either\Either;

class RightFavoringEitherMonad implements Monad {

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

  public function apply($eitherF, $eitherArgs = null) {
    if ($eitherF->isLeft()) {
      return $eitherF;
    } else {
      $f = $eitherF->get();

      if (is_null($eitherArgs)) {
        // There are no arguments passed in so we attempt to call the wrapped callable without arguments.
        try {
          $val = $f();
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
        //print_r($eitherArgs);
        $eitherVal = $this->map($eitherArgs, $f);
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
