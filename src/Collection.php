<?php

namespace TMciver\Functional;

trait Collection {
  abstract function add($value);
  abstract function remove($value);
  abstract function contains($value);
  abstract function size();
}