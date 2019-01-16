<?php

namespace PhatCats\ObjectTypeclass;

trait ObjectFunctor {

    /**
     * @param callable $f A function of one argument whose type is the type of
     * value contained in the functor.
     * @return An instance of ObjectFunctor whose type is the same as this ObjectFunctor.
     */
    abstract function map(callable $f);

    /**
     * @param $msg (string) An error message.
     * @return An instance of ObjectFunctor whose type is the same as this ObjectFunctor.
     */
    abstract function fail($msg);
}
