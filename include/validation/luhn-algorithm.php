<?php

//This is the luhnAlgorithm function which checks if a CC number is valid or not. This is a simplified better version of the Luhn Algo.
function luhnAlgorithm(string $ccNumber){
    $ccLen = strlen($ccNumber);
    $count = 0;

    if ($ccLen % 2 === 0){
        for ($i=0; $i < $ccLen; $i++) { 
            $currDigit = intval($ccNumber[$i]); //have to do this because ccNumber[i] is actually a char 
            if ($i % 2 == 0){
                if (($currDigit *= 2) > 9) //Only multiply every other num by 2, starts doubling with the second-to-last number. Do not do the last number
                {
                    // Separate the number into component parts and then add them together.
                    $trailingNum = $currDigit % 10;
                    $firstNum = (int)($currDigit / 10);

                    // If currentDigit was 18 then currentDigit is now 9.
                    $currDigit = $firstNum + $trailingNum;
                }
            }

            $count += $currDigit;
        }
    }
    else
    {
        //this is same thing but for odd len cards such as american express
        for ($i=$ccLen-1; $i >= 0 ; $i--) { 
            $currDigit = intval($ccNumber[$i]);
            if (($i - 1) % 2 == 0){
                if (($currDigit *= 2) > 9){
                    $trailingNum = $currDigit % 10;
                    $firstNum = (int)($currDigit / 10);

                    $currDigit = $firstNum + $trailingNum;
                }
            }
            $count += $currDigit;
        }
    }

    return ($count % 10) === 0;
}

?>