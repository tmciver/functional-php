<?php

use TMciver\Functional\Either\Right;
use TMciver\Functional\Either\Left;

class EitherMonoidTest extends PHPUnit_Framework_TestCase {

    public function testAppendForIdentityOnLeft() {

	$right5 = new Right(5);
        $identity = $right5->identity();
	$appended = $identity->append($right5);
	$expexted = new Right(5);

	$this->assertEquals($appended, $expexted);
    }

    public function testAppendForIdentityOnRight() {

        $right5 = new Right(5);
        $identity = $right5->identity();
	$appended = $right5->append($identity);
	$expexted = new Right(5);

	$this->assertEquals($appended, $expexted);
    }

    public function testAppendForTwoRights() {

        $right5 = new Right(5);
        $right6 = new Right(6);
	$appended = $right5->append($right6);
	$expexted = new Right([5, 6]);

	$this->assertEquals($appended, $expexted);
    }

    public function testAssociativity() {

        // we'll combine four values in two different ways and make sure the
        // results are the same.
        $right1 = new Right(1);
        $right2 = new Right(2);
        $right3 = new Right(3);
        $right4 = new Right(4);

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
}
