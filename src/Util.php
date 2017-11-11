<?php

namespace TMciver\Functional;

class Util {

  /**
   * @param $obj An instance of any class.
   * @returns bool True if the given instance has an 'append' method; false
   *          otherwise.
   */
  public static function is_monoid($obj) {
    return method_exists($obj, 'append');
  }
}
