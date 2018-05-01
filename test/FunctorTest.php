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

  public function testComposition() {
    $f = function ($x) { return $x + 1; };
    $g = function ($x) { return $x * 2; };
    $fAndThenG = function ($x) use ($f, $g) {
	return $g($f($x));
    };

    foreach ($this->functorData as $functorData) {
      $functor = $functorData->getIntFunctor();
      $fMapGMapFunctor = $functor->map($f)->map($g);
      $fAndThenGFunctor = $functor->map($fAndThenG);

      $this->assertEquals($fMapGMapFunctor, $fAndThenGFunctor);
    }
  }
}

interface FunctorInstance {
  function getIntFunctor();
}

class ListFunctorInstance implements FunctorInstance {
  function getIntFunctor() { return (new LinkedListFactory())->fromNativeArray([1, 2, 3]); }
}