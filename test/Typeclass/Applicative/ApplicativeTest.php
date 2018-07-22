<?php

namespace TMciver\Functional\Test\Typeclass\Applicative;

use PHPUnit\Framework\TestCase;
use TMciver\Functional\Maybe\Maybe;
use TMciver\Functional\Maybe\MaybeT;
use TMciver\Functional\Either\Either;
use TMciver\Functional\Validation\Validation;

abstract class ApplicativeTest extends TestCase {

  private $applicative;

  abstract function getApplicative();

  public function testIdentity() {
    $applicative = $this->getApplicative();
    $ff = $applicative->pure('identity');
    $fa = $applicative->pure("hello");
    $result = $applicative->apply($ff, $fa);

    $this->assertEquals($fa, $result);
  }

  public function testComposition() {
    $applicative = $this->getApplicative();
    $compose = $applicative->pure('compose');
    $ff = $applicative->pure('addOne');
    $fg = $applicative->pure('addOne');
    $fa = $applicative->pure(1);
    $result = $applicative->apply(
      $applicative->apply(
        $applicative->apply($compose, $ff),
        $fg
      ),
      $fa
    );
    $expectedResult  = $applicative->pure(3);

    $this->assertEquals($expectedResult, $result);
  }

  public function testHomomorphism() {
    $applicative = $this->getApplicative();
    $ff = $applicative->pure('addOne');
    $fa = $applicative->pure(1);
    $result = $applicative->apply($ff, $fa);
    $exptectedResult = $applicative->pure(addOne(1));

    $this->assertEquals($exptectedResult, $result);
  }

  // public function testInvoke() {

  //   // TODO fix
  //   // test all applicatives
  //   foreach($this->applicativesToTest as $applicative) {
  //     $f = $applicative->pure('add');
  //     $x = $applicative->pure(1);
  //     $y = $applicative->pure(2);
  //     $result = $f($x, $y);
  //     $exptectedResult = $applicative->pure(3);

  //     $this->assertEquals($exptectedResult, $result);
  //   }
  // }
}
