<?php

namespace PhatCats\Typeclass;

interface SemiGroup {

  /**
   * @param $left left-hand object to be appended.
   * @param $right left-hand object to be appended.
   * @return Result of appending this object with appendee. Should have same
   *         type as this object.
   */
  function append($left, $right);
}
