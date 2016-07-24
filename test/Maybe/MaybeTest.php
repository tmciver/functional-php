<?php

use TMciver\Functional\Maybe\Just;
use TMciver\Functional\Maybe\Nothing;

class MaybeTest extends PHPUnit_Framework_TestCase {

    public function testMaybeGetOrElseForJust() {

        $maybe = new Just("Hello!");
        $val = $maybe->getOrElse("World!");

        $this->assertEquals("Hello!", $val);
    }

    public function testMaybeGetOrElseForNothing() {

        $maybe = new Nothing();
        $val = $maybe->getOrElse("World!");

        $this->assertEquals("World!", $val);
    }
}