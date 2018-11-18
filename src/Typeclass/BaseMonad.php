<?php

namespace TMciver\Functional\Typeclass;

abstract class BaseMonad extends BaseApplicative implements Monad {

  public function flatMap($ma, callable $f) {
    return $this->map($ma, $f)->join();
  }

  public function join($mma) {
    return $this->flatMap($mma, $identity);
  }
}
