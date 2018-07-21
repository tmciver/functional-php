<?php

namespace TMciver\Functional\Typeclass;

abstract class BaseMonad extends BaseApplicative implements Monad {

  public function flatMap($ma, callable $f) {
    return $ma->flatMap($f);
  }

  public function join($mma) {
    return $mma->join();
  }
}
