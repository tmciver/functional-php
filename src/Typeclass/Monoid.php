<?php

namespace TMciver\Functional\Typeclass;

interface Monoid extends SemiGroup {

  /**
   * @return The identity element.
   */
  function identity();
}
