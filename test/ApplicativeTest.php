<?php

use TMciver\Functional\Validation\Validation;

class ApplicativeTest extends PHPUnit_Framework_TestCase {

  private $applicativesToTest;

  public function __construct() {
    $this->applicativesToTest = [Validation::fromValue(1)];
  }

  public function testIdentity() {

    // test all applicatives
    foreach($this->applicativesToTest as $applicative) {
      $result = $applicative->pure(identity)->apply($applicative);

      $this->assertEquals($applicative, $result);
    }
  }

  public function testComposition() {

    // test all applicatives
    foreach($this->applicativesToTest as $applicative) {
      $compose = $applicative->pure(compose);
      $f = $applicative->pure(addOne);
      $g = $applicative->pure(addOne);
      $arg = $applicative->pure(1);
      $result = $compose->apply($f)->apply($g)->apply($arg);
      $expectedResult = $applicative->pure(3);

      $this->assertEquals($expectedResult, $result);
    }
  }

  public function testHomomorphism() {

    // test all applicatives
    foreach($this->applicativesToTest as $applicative) {
      $f = $applicative->pure(addOne);
      $x = $applicative->pure(1);
      $result = $f->apply($x);
      $exptectedResult = $applicative->pure(addOne(1));

      $this->assertEquals($exptectedResult, $result);
    }
  }

  public function testInvoke() {

    // test all applicatives
    foreach($this->applicativesToTest as $applicative) {
      $f = $applicative->pure(add);
      $x = $applicative->pure(1);
      $y = $applicative->pure(2);
      $result = $f($x, $y);
      $exptectedResult = $applicative->pure(3);

      $this->assertEquals($exptectedResult, $result);
    }
  }
}
