<?php

namespace TMciver\Functional\Test;

use TMciver\Functional\LinkedList\LinkedListFunctor;
use TMciver\Functional\LinkedList\LinkedListFactory;

class LinkedListFunctorTest extends FunctorTest {

  function getFunctorInstance() {
    return new LinkedListFunctor();
  }

  function getValue() {
    return (new LinkedListFactory())->fromNativeArray([1, 2, 3, 4, 5]);
  }

  function getF() {
    return function (int $x) : int { return $x + 1; };
  }

  function getG() {
    return function (int $x) : string { return (string)$x; };
  }
}
