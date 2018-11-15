<?php

namespace TMciver\Functional\Test\Typeclass\Monad;

use PHPUnit\Framework\TestCase;
use TMciver\Functional\Maybe\Maybe;
use TMciver\Functional\Maybe\MaybeT;
use TMciver\Functional\Either\Either;
use TMciver\Functional\Either\Monad\RightFavoringEitherMonad;
use TMciver\Functional\LinkedList\LinkedListFactory;

abstract class MonadTest extends TestCase {

  protected abstract function getMonad();
  protected abstract function getValue();
  protected abstract function getMonadicFunctionF();
  protected abstract function getMonadicFunctionG();

  public function testLeftIdentity() {
    $val = $this->getValue();
    $monad = $this->getMonad();
    $f = $this->getMonadicFunctionF();

    $result1 = $monad->pure($val)->flatMap($f);
    $result2 = $f($val);

    $this->assertEquals($result1, $result2);
  }

  public function testRightIdentity() {
    $monad = $this->getMonad();
    $val = $this->getValue();
    $m = $monad->pure($val);
    $f = function($val) use ($monad) {
      return $monad->pure($val);
    };

    $result1 = $monad->flatMap($m, $f);
    $result2 = $m;

    $this->assertEquals($result1, $result2);
  }

  public function testAssociativity() {
    $monad = $this->getMonad();
    $val = $this->getValue();
    $m = $monad->pure($val);
    $f = $this->getMonadicFunctionF();
    $g = $this->getMonadicFunctionG();

    $result1 = $monad->flatMap($m, $f)->flatMap($g);
    $result2 = $monad->flatMap($m, function($x) use ($f, $g) {
	  return $f($x)->flatMap($g);
	});

    $this->assertEquals($result1, $result2);
  }
}

interface MonadTestData {

  /**
   * Return some regular, non-monadic value like and int, string or array
   */
  function getValue();

  /**
   * Return an instance of the monad under test.
   */
  function getMonadInstance();
  function getMonadFunctionF();
  function getMonadFunctionG();
}

class MaybeTTestData implements MonadTestData {
  private $maybeT;

  public function __construct() {
    $this->maybeT = new MaybeT(Either::fromValue(Maybe::fromValue(1)));
  }

  function getValue() { return 1; }
  function getMonadInstance() { return $this->maybeT; }
  function getMonadFunctionF() {
    return function($i) { return $this->maybeT->pure($i + 1); };
  }
  function getMonadFunctionG() {
    return function($i) { return $this->maybeT->pure($i . ''); };
  }
}

class LinkedListTestData implements MonadTestData {
  private $factory;
  function __construct() {
    $this->factory = new LinkedListFactory();
  }
  function getValue() { return 1; }
  function getMonadInstance() { return $this->factory->fromNativeArray([1, 2, 3]); }
  function getMonadFunctionF() {
    return function($i) { return $this->factory->fromNativeArray([$i + 1, $i + 2, $i + 3]); };
  }
  function getMonadFunctionG() {
    return function($i) {
      return $this->factory->fromNativeArray(str_split(str_repeat(".", $i)));
    };
  }
}
