<?php

use PHPUnit\Framework\TestCase;
use PhatCats\Validation\Validation;

require_once __DIR__ . '/../util.php';

class ValidationFunctorTest extends TestCase {

  public function testMapForSuccess() {

    $validationInt = Validation::fromValue(1);
    $validationIntPlusOne = $validationInt->map('addOne');
    $expected = Validation::fromValue(2);

    $this->assertEquals($expected, $validationIntPlusOne);
  }

  public function testMapForFailure() {

    $failure = Validation::failure("Pwned!");
    $mappedFailure = $failure->map('addOne');

    $this->assertEquals($mappedFailure, $failure);
  }

  public function testMapExceptionHandling() {

    $validationInt = Validation::fromValue(1);
    $mappedValidationInt = $validationInt->map('throwException');

    $this->assertInstanceOf('PhatCats\Validation\Failure', $mappedValidationInt);
  }

  public function testMapNullHandling() {

    $validationInt = Validation::fromValue(1);
    $mappedValidationInt = $validationInt->map('returnNull');

    $this->assertInstanceOf('PhatCats\Validation\Failure', $mappedValidationInt);
  }
}
