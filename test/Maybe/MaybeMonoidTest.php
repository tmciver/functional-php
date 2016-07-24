<?php

use TMciver\Functional\Maybe\Just;
use TMciver\Functional\Maybe\Nothing;

class MaybeMonoidTest extends PHPUnit_Framework_TestCase {

    public function testAppendForIdentityOnLeft() {

	    $just5 = new Just(5);
        $identity = $just5->identity();
	    $appended = $identity->append($just5);
	    $expexted = new Just(5);

	    $this->assertEquals($appended, $expexted);
    }

    public function testAppendForIdentityOnRight() {

        $just5 = new Just(5);
        $identity = $just5->identity();
	    $appended = $just5->append($identity);
	    $expexted = new Just(5);

	    $this->assertEquals($appended, $expexted);
    }

    public function testAppendForTwoJusts() {

        $just5 = new Just(5);
        $just6 = new Just(6);
	    $appended = $just5->append($just6);
	    $expexted = new Just([5, 6]);

	    $this->assertEquals($appended, $expexted);
    }

    public function testAssociativity() {

        // we'll combine four values in two different ways and make sure the
        // results are the same.
        $just1 = new Just(1);
        $just2 = new Just(2);
        $just3 = new Just(3);
        $just4 = new Just(4);

        // First, combine the first two, then the last two and finally combine
        // the two results.
        $firstTwo = $just1->append($just2);
        $secondTwo = $just3->append($just4);
        $result1 = $firstTwo->append($secondTwo);

        // Next, combine the first two with the third and then combine that
        // result with the fourth.
        $firstThree = $firstTwo->append($just3);
        $result2 = $firstThree->append($just4);

        $this->assertEquals($result1, $result2);
    }
}
