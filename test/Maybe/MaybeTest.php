<?php

use TMciver\Functional\Maybe\Maybe;

class MaybeTest extends PHPUnit_Framework_TestCase {

    public function testMaybeGetOrElseForJust() {

        $maybe = Maybe::fromValue("Hello!");
        $val = $maybe->getOrElse("World!");

        $this->assertEquals("Hello!", $val);
    }

    public function testMaybeGetOrElseForNothing() {

        $maybe = Maybe::nothing();
        $val = $maybe->getOrElse("World!");

        $this->assertEquals("World!", $val);
    }
}
