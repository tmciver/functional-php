<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\Collection;

abstract class LinkedList {
  use Collection;

  /**
   * Alias for Collection::add
   */
  public function cons($value) {
    return $this->add($value);
  }

  /**
   * @return TMciver\Functional\Maybe\Maybe containing value.
   */
  public abstract function head();

  /**
   * @return the tail of this LinkedList as LinkedList.
   */
  public abstract function tail();

}
