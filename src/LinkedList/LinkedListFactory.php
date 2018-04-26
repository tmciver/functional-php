<?php

namespace TMciver\Functional\LinkedList;

class LinkedListFactory {

  public static function fromNativeArray(array $array) {
    if (is_null($array) || empty($array)) {
      return LinkedList::empty();
    } else {
      $fn = function ($list, $item) {
	return $list->cons($item);
      };
      return array_reduce($array, $fn, LinkedList::empty());
    }
  }
}