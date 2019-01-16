<?php

use PHPUnit\Framework\TestCase;
use PhatCats\Maybe\Maybe;
use PhatCats\Maybe\Nothing;
use PhatCats\Test\StaticClass;

class MaybeTest extends TestCase {

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

    public function testStaticMethodCall() {

        $maybe = Maybe::fromValue("Hello world!");
        $f = ['\PhatCats\Test\StaticClass', 'toUpperCase'];
        $maybeUpperCase = $maybe->map($f);
        $expexted = Maybe::fromValue("HELLO WORLD!");

        $this->assertEquals($expexted, $maybeUpperCase);
    }
}
