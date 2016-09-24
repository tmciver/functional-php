<?php

use TMciver\Functional\Maybe\Maybe;
use TMciver\Functional\Maybe\Nothing;

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

    public function testOrElseForNothing() {

        $maybe = Maybe::nothing('');
        $maybeNoException = $maybe->orElse(function () {
            throw new \Exception('I should be caught!');
        }, []);

        $this->assertInstanceOf(Nothing::class, $maybeNoException);
    }

    public function testOrElseForRight() {

        $maybe = Maybe::fromValue('');
        $maybeSame = $maybe->orElse(function () {
            return Maybe::fromValue('A new Maybe!');
        }, []);

        $this->assertEquals($maybe, $maybeSame);
    }
}
