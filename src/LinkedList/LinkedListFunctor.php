<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\Typeclass\Functor;

class LinkedListFunctor implements Functor {

  function map(/*type LinkedList*/ $l, callable $f) {
    return $l->map($f);
  }
}
