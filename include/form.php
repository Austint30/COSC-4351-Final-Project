<?php
    include_once "validation/luhn-algorithm.php";

    function validateNotEmpty($fieldName, &$errMsgVar, $errMsg="This field is required!", &$hasError=null){
        $isInvalid = false;

        if (!isset($_POST[$fieldName])){
            $errMsgVar = $errMsg;
            if ($hasError !== null){
                $hasError = true;
            }
            return '';
        }

        if (empty($_POST[$fieldName])){
            $errMsgVar = $errMsg;
            if ($hasError !== null){
                $hasError = true;
            }
        }
        return $_POST[$fieldName];
    }

    function validateCustom($fieldName, $validationFunc, &$errMsgVar, &$hasError=null){
        $errMsg = $validationFunc($_POST[$fieldName]);
        if ($errMsg){
            $errMsgVar = $errMsg;
            if ($hasError !== null){
                $hasError = true;
            }
        }
        return $_POST[$fieldName];
    }

    function validateEmail($fieldName, &$errMsgVar, $errMsg="Email is in an invalid format.", &$hasError=null){

        $value = $_POST[$fieldName];
        $invalid = false;

        $atSymbolPos = strPos($value, "@");
        $dotPos = strPos($value, ".");

        if ($atSymbolPos === false){
            $invalid = true;
        }

        if ($dotPos === false || $dotPos <= $atSymbolPos){
            $invalid = true;
        }

        if ($invalid){
            $errMsgVar = $errMsg;
            if ($hasError !== null){
                $hasError = true;
            }
        }
        return $_POST[$fieldName];
    }

    // Removes extra fluff from phone numbers
    function filterPhoneNumber($phone){
        if ($phone === null){
            return null;
        }
        return preg_replace("/[^0-9]/", '', $phone);
    }

    function validatePhone($fieldName, &$errMsgVar, $errMsg="Phone Number is in an invalid format.", &$hasError=null){
        $value = $_POST[$fieldName];

        $value = filterPhoneNumber($value); // Remove extra characters

        // Then check if there is 10 numbers
        $invalid = !preg_match('/^[0-9]{10}+$/', $value);

        if ($invalid){
            $errMsgVar = $errMsg;
            if ($hasError !== null){
                $hasError = true;
            }
        }
        return $_POST[$fieldName];
    }

    function validateCreditCard($fieldName, &$errMsgVar, $errMsg="Credit Card is invalid.", &$hasError=null){
        $value = $_POST[$fieldName];

        $invalid = !luhnAlgorithm($value);
        if ($invalid){
            $errMsgVar = $errMsg;
            if ($hasError !== null){
                $hasError = true;
            }
        }
        return $_POST[$fieldName];
    }


    function renderErrorFeedback($message){
        if ($message){
            echo '<div class="invalid-feedback" style="display: block;">'.$message.'</div>';
        }
    }

?>