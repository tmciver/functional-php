<?php

use PHPUnit\Framework\TestCase;
use TMciver\Functional\Either\Either;
use TMciver\Functional\Maybe\Maybe;

class EitherMonoidTest extends TestCase {

    public function testAppendForIdentityOnLeft() {

	$right5 = Either::fromValue(5);
        $identity = $right5->identity();
	$appended = $identity->append($right5);
	$expexted = Either::fromValue(5);

	$this->assertEquals($appended, $expexted);
    }

    public function testAppendForIdentityOnRight() {

        $right5 = Either::fromValue(5);
        $identity = $right5->identity();
	$appended = $right5->append($identity);
	$expexted = Either::fromValue(5);

	$this->assertEquals($appended, $expexted);
    }

    public function testAppendForTwoRights() {

        $right5 = Either::fromValue(5);
        $right6 = Either::fromValue(6);
	$appended = $right5->append($right6);
	$expexted = Either::fromValue([5, 6]);

	$this->assertEquals($appended, $expexted);
    }

    public function testAssociativity() {

        // we'll combine four values in two different ways and make sure the
        // results are the same.
        $right1 = Either::fromValue(1);
        $right2 = Either::fromValue(2);
        $right3 = Either::fromValue(3);
        $right4 = Either::fromValue(4);

        // First, combine the first two, then the last two and finally combine
        // the two results.
        $firstTwo = $right1->append($right2);
        $secondTwo = $right3->append($right4);
        $result1 = $firstTwo->append($secondTwo);

        // Next, combine the first two with the third and then combine that
        // result with the fourth.
        $firstThree = $firstTwo->append($right3);
        $result2 = $firstThree->append($right4);

        $this->assertEquals($result1, $result2);
    }

    public function testAppendForContainedMonoids1() {

      // create two Either's containing strings
      $right1 = Either::fromValue("Hello, ");
      $right2 = Either::fromValue("World!");

      // Append them
      $appended = $right1->append($right2);

      $expected = Either::fromValue("Hello, World!");

      $this->assertEquals($appended, $expected);
    }

    public function testAppendForContainedMonoids2() {

      // create two Either's containing Maybe's
      $right1 = Either::fromValue(Maybe::fromValue(1));
      $right2 = Either::fromValue(Maybe::fromValue([2, 3]));

      // Append them
      $appended = $right1->append($right2);

      $expected = Either::fromValue(Maybe::fromValue([1, 2, 3]));

      $this->assertEquals($appended, $expected);
    }
}
