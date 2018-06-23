<?php

use PHPUnit\Framework\TestCase;
use TMciver\Functional\Either\Either;
use TMciver\Functional\Either\Left;

class EitherTest extends TestCase {

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

    public function testOrElseForLeft() {

        $either = Either::left('');
        $eitherNoException = $either->orElse(function () {
            throw new \Exception('I should be caught!');
        }, []);

        $this->assertInstanceOf(Left::class, $eitherNoException);
    }

    public function testOrElseForRight() {

        $either = Either::fromValue('');
        $eitherSame = $either->orElse(function () {
            return Either::fromValue('A new Either!');
        }, []);

        $this->assertEquals($either, $eitherSame);
    }

    public function testEitherErrorMessage() {

        $errMsg = 'No power in the \'verse can stop me.';
        $either = Either::fromValue(null, $errMsg);
        $expected = Either::left($errMsg);

        $this->assertEquals($expected, $either);
    }
}
