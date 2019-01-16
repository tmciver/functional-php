<?php

namespace PhatCats\Test\Typeclass\Monad;

use PHPUnit\Framework\TestCase;

/**
 * Test class for testing the monad laws of any monad.  The [Template
 * Pattern](https://en.wikipedia.org/wiki/Template_method_pattern) is used to
 * instantiate the necessary test data.  To create a new monad test create a
 * sub-class of this class and provide implementations for all abstract methods.
 */
abstract class MonadTest extends TestCase {

  /**
   * @returns An instance of the monad to test.
   */
  protected abstract function getMonad();

  /**
   * @returns Any value. The function returned by `$self::getMonadicFunctionF()`
   * must be able to accept this value as an argument.
   */
  protected abstract function getValue();

  /**
   * @returns a function that will be called with the value returned from
   * `$self::getValue()` and returns a monad of the same type as the monad under
   * test.
   */
  protected abstract function getMonadicFunctionF();

  /**
   * @returns a function that will be called with the value wrapped in the monad
   * returned by `$self::getMonadicFunctionF()` and returns a monad of the same
   * type as the monad under test.
   */
  protected abstract function getMonadicFunctionG();

  public function testLeftIdentity() {
    $val = $this->getValue();
    $monad = $this->getMonad();
    $m = $monad->pure($val);
    $f = $this->getMonadicFunctionF();

    $result1 = $monad->flatMap($m, $f);
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

    $m1 = $monad->flatMap($m, $f);
    $result1 = $monad->flatMap($m1, $g);
    $result2 = $monad->flatMap($m, function($x) use ($monad, $f, $g) {
      $m1 = $f($x);
	  return $monad->flatMap($m1, $g);
	});

    $this->assertEquals($result1, $result2);
  }
}
