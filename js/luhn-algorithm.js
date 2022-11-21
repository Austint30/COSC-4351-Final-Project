/*
Based on https://github.com/tobymac208/YouTubeTutorials/blob/main/javascript_credit_card_validation/index.js
*/

//This is the luhnAlgorithm function which checks if a CC number is valid or not. This is a simplified better version of the Luhn Algo.
const luhnAlgorithm = (ccNumber) => {
    const cclength = ccNumber.length;
    let count = 0;

    //Loop through ccNumber. Starts at the beginning of the number and begins doubling from the first number.
    if(cclength % 2 === 0)
    {
        for(let i = 0; i < cclength; i++)
        {
            let currDigit = parseInt(ccNumber[i]); //have to do this because ccNumber[i] is actually a char 
            if (i % 2 == 0) //Only multiply every other num by 2, starts doubling with the second-to-last number. Do not do the last number
            {
                if ((currDigit *= 2) > 9)
                {
                    // Separate the number into component parts and then add them together.
                    let trailingNumber = currDigit % 10;
                    let firstNumber = parseInt(currDigit / 10);

                    // If currentDigit was 18 then currentDigit is now 9.
                    currDigit = firstNumber + trailingNumber;
                }
            }
            
            count += currDigit;
        }
    }
    else {
        //this is same thing but for odd len cards such as american express
        for(let i = cclength - 1 ; i >= 0; i--)
        {
            let currDigit = parseInt(ccNumber[i]);
            if ((i - 1) % 2 == 0) 
            {
                if ((currDigit *= 2) > 9)
                {
                    let trailingNumber = currDigit % 10;
                    let firstNumber = parseInt(currDigit / 10);

                    currDigit = firstNumber + trailingNumber;
                }
            }
            
            count += currDigit;
        }
    }

    return (count % 10) === 0;
}