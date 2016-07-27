<?php

use TMciver\Functional\Either\Either;

class EitherTest extends PHPUnit_Framework_TestCase {

    public function testEitherGetOrElseForRight() {

        $either = Either::fromValue("Hello!");
        $val = $either->getOrElse("World!");

        $this->assertEquals("Hello!", $val);
    }

    public function testEitherGetOrElseForLeft() {

        $either = Either::left('');
        $val = $either->getOrElse("World!");

        $this->assertEquals("World!", $val);
    }
}
