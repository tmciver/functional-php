<?php

namespace TMciver\Functional;

trait Collection {
  abstract function add($value);
  abstract function remove($value);
  abstract function contains($value);
  abstract function size();

  /**
   * @param $f A single argument function taking an element from the collection
   *        and returning a boolean.
   * @return A new collection containing only those elements from this
   *         collection that satisfy the predicate $f.
   */
  abstract function filter($f);
}
