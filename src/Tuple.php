<?php

namespace TMciver\Functional;

class Tuple {

  private $first;
  private $second;

  public function __construct($first, $second) {
    $this->first = $first;
    $this->second = $second;
  }

  public function first() {
    return $this->first;
  }

  public function second() {
    return $this->second;
  }

}
