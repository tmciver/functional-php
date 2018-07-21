<?php

namespace TMciver\Functional\Test\Typeclass\Applicative;

use PHPUnit\Framework\TestCase;
use TMciver\Functional\Maybe\Maybe;
use TMciver\Functional\Maybe\MaybeT;
use TMciver\Functional\Either\Either;
use TMciver\Functional\Validation\Validation;
use TMciver\Functional\LinkedList\LinkedListFactory;

abstract class ApplicativeTest extends TestCase {

  private $applicativesToTest;
  private $applicative;

  abstract function getApplicative();

  public function setUp() {

    // Set up a MaybeT instance. I need to figure out a better way
    // to do this.
    $maybeT = new MaybeT(Either::fromValue(Maybe::fromValue(1)));

    // These exist as a kludge for creating Applicatives; they're not the actual
    // Applicatives.
    $this->applicativesToTest = [Maybe::fromValue(1),
				 Either::fromValue(1),
				 Validation::fromValue(1),
				 $maybeT];
  }

  public function testIdentity() {

    // test all applicatives
    // TODO Remove once all applicatives have their own test subclass.
    foreach($this->applicativesToTest as $applicative) {
      $result = $applicative->pure('identity')->apply($applicative);

      $this->assertEquals($applicative, $result);
    }

    $applicative = $this->getApplicative();
    $ff = $applicative->pure('identity');
    $fa = $applicative->pure("hello");
    $result = $applicative->apply($ff, $fa);

    $this->assertEquals($fa, $result);
  }

  public function testComposition() {

    // test all applicatives
    // TODO Remove once all applicatives have their own test subclass.
    foreach($this->applicativesToTest as $applicative) {
      $compose = $applicative->pure('compose');
      $f = $applicative->pure('addOne');
      $g = $applicative->pure('addOne');
      $arg = $applicative->pure(1);
      $result = $compose->apply($f)->apply($g)->apply($arg);
      $expectedResult = $applicative->pure(3);

      $this->assertEquals($expectedResult, $result);
    }

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

    // test all applicatives
    // TODO Remove once all applicatives have their own test subclass.
    foreach($this->applicativesToTest as $applicative) {
      $f = $applicative->pure('addOne');
      $x = $applicative->pure(1);
      $result = $f->apply($x);
      $exptectedResult = $applicative->pure(addOne(1));

      $this->assertEquals($exptectedResult, $result);
    }

    $applicative = $this->getApplicative();
    $ff = $applicative->pure('addOne');
    $fa = $applicative->pure(1);
    $result = $applicative->apply($ff, $fa);
    $exptectedResult = $applicative->pure(addOne(1));

    $this->assertEquals($exptectedResult, $result);
  }

  public function testInvoke() {

    // test all applicatives
    foreach($this->applicativesToTest as $applicative) {
      $f = $applicative->pure('add');
      $x = $applicative->pure(1);
      $y = $applicative->pure(2);
      $result = $f($x, $y);
      $exptectedResult = $applicative->pure(3);

      $this->assertEquals($exptectedResult, $result);
    }
  }
}
