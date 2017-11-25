<?php

use TMciver\Functional\Validation\Validation;
use TMciver\Functional\Maybe\Maybe;
use TMciver\Functional\Either\Either;

class MonadTest extends PHPUnit_Framework_TestCase {

  private $monadTestData;

  public function __construct() {
    $this->monadTestData = [new ValidationTestData(),
			    new MaybeTestData(),
			    new EitherTestData()];
  }

  public function testLeftIdentity() {

    // test all monads
    foreach($this->monadTestData as $monadTestData) {

      $val = $monadTestData->getValue();
      $monad = $monadTestData->getMonadInstance();
      $f = $monadTestData->getMonadFunctionF();

      $result1 = $monad->pure($val)->flatMap($f);
      $result2 = $f($val);

      $this->assertEquals($result1, $result2);
    }
  }

  public function testRightIdentity() {

    // test all monads
    foreach($this->monadTestData as $monadTestData) {

      $monad = $monadTestData->getMonadInstance();
      $f = function($val) use ($monad) {
	return $monad->pure($val);
      };

      $result1 = $monad->flatMap($f);
      $result2 = $monad;

      $this->assertEquals($result1, $result2);
    }
  }

  public function testAssociativity() {

    // test all monads
    foreach($this->monadTestData as $monadTestData) {

      $monad = $monadTestData->getMonadInstance();
      $f = $monadTestData->getMonadFunctionF();
      $g = $monadTestData->getMonadFunctionG();

      $result1 = $monad->flatMap($f)->flatMap($g);
      $result2 = $monad->flatMap(function($x) use ($f, $g) {
	  return $f($x)->flatMap($g);
	});

      $this->assertEquals($result1, $result2);
    }
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

class ValidationTestData implements MonadTestData {
  function getValue() { return 1; }
  function getMonadInstance() { return Validation::fromValue(1); }
  function getMonadFunctionF() {
    return function($i) { return Validation::fromValue($i + 1); };
  }
  function getMonadFunctionG() {
    return function($i) { return Validation::fromValue($i . ''); };
  }
}

class MaybeTestData implements MonadTestData {
  function getValue() { return 1; }
  function getMonadInstance() { return Maybe::fromValue(1); }
  function getMonadFunctionF() {
    return function($i) { return Maybe::fromValue($i + 1); };
  }
  function getMonadFunctionG() {
    return function($i) { return Maybe::fromValue($i . ''); };
  }
}

class EitherTestData implements MonadTestData {
  function getValue() { return 1; }
  function getMonadInstance() { return Either::fromValue(1); }
  function getMonadFunctionF() {
    return function($i) { return Either::fromValue($i + 1); };
  }
  function getMonadFunctionG() {
    return function($i) { return Either::fromValue($i . ''); };
  }
}
