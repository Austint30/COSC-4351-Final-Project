<?php

require __DIR__.'/../include/validation/luhn-algorithm.php';

use PHPUnit\Framework\TestCase;

final class LuhnAlgorithmTest extends TestCase {
    public function testValidCreditCardNumber(): void {
        $cc = "9990715511324911";
        echo "Testing luhn-algorithm.php where ".$cc." is valid\n";
        $valid = luhnAlgorithm($cc);
        $this->assertTrue($valid);
    }

    public function testInvalidCreditCardNumber(): void {

        $ccList = array(
            "9990715511324311",
            "999071324311",
            "ligma",
            "",
            0
        );

        foreach ($ccList as $cc) {
            echo "Testing luhn-algorithm.php where ".$cc." is not valid\n";
            $valid = luhnAlgorithm($cc);
            $this->assertFalse($valid);
        }
    }
}

?>