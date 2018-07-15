<?php

namespace TMciver\Functional\Typeclass;

interface Functor {

  /**
   * @param $v A value of a type for which this is a Functor, i.e. the value
   *        that will be mapped over.
   * @param callable $f A function of one argument whose type is the type of
   *        value contained in the functor.
   * @return A value that has been mapped over with the same type as $v.
   */
  function map($v, callable $f);

  /**
   * @param $msg (string) An error message.
   * @return An instance of Functor whose type is the same as this Functor.
   */
  //abstract function fail($msg);
}
