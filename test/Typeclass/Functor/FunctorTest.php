<?php

namespace TMciver\Functional\Test\Typeclass\Functor;

use PHPUnit\Framework\TestCase;

abstract class FunctorTest extends TestCase {

  abstract function getFunctorInstance();

  /*
   * A value whose type should be the type whose functor is under test. For
   * example, in the `MaybeFunctor` test, the type of this value should be
   * `Maybe`.
   */
  abstract function getValue();

  /*
   * A function of one argument whose argument type is that returned by
   * `$this::getValue` and whose return type is the same type.
   */
  abstract function getF();

  /*
   * A function of one argument whose type is the same as the value returned by
   * `$this::getF` and whose return type is the same.
   */
  abstract function getG();

  public function testIdentityLaw() {
    $functor = $this->getFunctorInstance();
    $v = $this->getValue();
    $left = $functor->map($v, 'identity');
    $right = $v;

    $this->assertEquals($left, $right);
  }

  public function testCompositionLaw() {
    $functor = $this->getFunctorInstance();
    $v = $this->getValue();
    $f = $this->getF();
    $g = $this->getG();
    $left = $functor->map($v, compose($f, $g));
    $right1 = $functor->map($v, $f);
    $right = $functor->map($right1, $g);

    $this->assertEquals($left, $right);
  }
}
