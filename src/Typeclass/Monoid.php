<?php

namespace PhatCats\Typeclass;

interface Monoid extends SemiGroup {

  /**
   * @return The identity element.
   */
  function identity();
}
