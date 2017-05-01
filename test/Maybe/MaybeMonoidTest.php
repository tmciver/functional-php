<?php

use TMciver\Functional\Maybe\Maybe;

class MaybeMonoidTest extends PHPUnit_Framework_TestCase {

    public function testAppendForIdentityOnLeft() {

	    $just5 = Maybe::fromValue(5);
        $identity = $just5->identity();
	    $appended = $identity->append($just5);
	    $expexted = Maybe::fromValue(5);

	    $this->assertEquals($appended, $expexted);
    }

    public function testAppendForIdentityOnRight() {

        $just5 = Maybe::fromValue(5);
        $identity = $just5->identity();
	    $appended = $just5->append($identity);
	    $expexted = Maybe::fromValue(5);

	    $this->assertEquals($appended, $expexted);
    }

    public function testAppendForTwoJusts() {

        $just5 = Maybe::fromValue(5);
        $just6 = Maybe::fromValue(6);
	    $appended = $just5->append($just6);
	    $expexted = Maybe::fromValue([5, 6]);

	    $this->assertEquals($appended, $expexted);
    }

    public function testAssociativity() {

        // we'll combine four values in two different ways and make sure the
        // results are the same.
        $just1 = Maybe::fromValue(1);
        $just2 = Maybe::fromValue(2);
        $just3 = Maybe::fromValue(3);
        $just4 = Maybe::fromValue(4);

        // First, combine the first two, then the last two and finally combine
        // the two results.
        $firstTwo = $just1->append($just2);
        $secondTwo = $just3->append($just4);
        $result1 = $firstTwo->append($secondTwo);

        // Next, combine the first two, then combine that result with the third
        // and then combine that result with the fourth.
        $firstThree = $firstTwo->append($just3);
        $result2 = $firstThree->append($just4);

        $this->assertEquals($result1, $result2);
    }

    public function testAppendForContainedMonoids1() {

      // create two Maybe's containing strings
      $just1 = Maybe::fromValue("Hello, ");
      $just2 = Maybe::fromValue("World!");

      // Append them
      $appended = $just1->append($just2);

      $expected = Maybe::fromValue("Hello, World!");

      $this->assertEquals($appended, $expected);
    }

    public function testAppendForContainedMonoids2() {

      // create two Maybe's containing Maybe's
      $just1 = Maybe::fromValue(Maybe::fromValue(1));
      $just2 = Maybe::fromValue(Maybe::fromValue([2, 3]));

      // Append them
      $appended = $just1->append($just2);

      $expected = Maybe::fromValue(Maybe::fromValue([1, 2, 3]));

      $this->assertEquals($appended, $expected);
    }
}
