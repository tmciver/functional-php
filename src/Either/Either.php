<?php

namespace TMciver\Functional\Either;

abstract class Either {

    public static function fromValue($val, $errorMsg = 'Attempted to create TMciver\Functional\Either\Right with a null value.') {
        if (is_null($val)) {
            $either = self::fail($errorMsg);
        } else {
            $either = new Right($val);
        }

        return $either;
    }

    public static function left($val) {
        if (is_null($val)) {
            $either = self::fail('Attempted to create TMciver\Functional\Either\Left with a null value.');
        } else {
            $either = new Left($val);
        }

        return $either;
    }

    /**
     * @return True if this object is an instance of the Left class; false
     * otherwise.
     */
    public abstract function isLeft();

    public abstract function accept($eitherVisitor);
}
