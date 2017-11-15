<?php

function identity($x) {
  return $x;
}

function compose($f, $g) {
  return function ($x) use ($f, $g) {
    return $g($f($x));
  };
}

function addOne($i) {
    return $i + 1;
}

function add($x, $y) {
  return $x + $y;
}

function throwException($i) {
    throw new \Exception("I'm totally freaking out!'");
}

function returnNull($i) {
    return null;
}
