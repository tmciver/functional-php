<?php

namespace TMciver\Functional\LinkedList;

use TMciver\Functional\Collection;
use TMciver\Functional\LinkedList\Nil;
//require_once __DIR__ . '/Nil.php';

abstract class LinkedList {
  use Collection;

  private static $empty1;

  public static function init() {
    self::$empty1 = new Nil();
  }

  public static function empty() {
    return self::$empty1;
  }

  /* protected function __construct() { */
  /*   self::$empty = new Nil(); */
  /* } */

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

LinkedList::init();
