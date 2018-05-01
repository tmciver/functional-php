<?php

use TMciver\Functional\LinkedList\LinkedListFactory;

class FunctorTest extends PHPUnit_Framework_TestCase {

  private $functorData;

  public function __construct() {
    $this->functorData = [new ListFunctorInstance()];
  }

  public function testIdentityLaw() {
    $id = function ($x) { return $x; };
    foreach ($this->functorData as $functorData) {
      $functor = $functorData->getIntFunctor();
      $newFunctor = $functor->map($id);
      $this->assertEquals($functor, $newFunctor);
    }
  }
}

interface FunctorInstance {
  function getIntFunctor();
}

class ListFunctorInstance implements FunctorInstance {
  function getIntFunctor() { return (new LinkedListFactory())->fromNativeArray([1, 2, 3]); }
}