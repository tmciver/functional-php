<?php

use TMciver\Functional\Either\Right;
use TMciver\Functional\Either\Left;

class EitherTest extends PHPUnit_Framework_TestCase {

    public function testEitherGetOrElseForRight() {

        $either = new Right("Hello!");
        $val = $either->getOrElse("World!");

        $this->assertEquals("Hello!", $val);
    }

    public function testEitherGetOrElseForLeft() {

        $either = new Left('');
        $val = $either->getOrElse("World!");

        $this->assertEquals("World!", $val);
    }
}