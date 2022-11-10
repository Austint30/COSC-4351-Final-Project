<?php

    function validateNotEmpty($fieldName, &$errMsgVar, $errMsg="This field is required!", &$hasError=null){
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

    function renderErrorFeedback($message){
        if ($message){
            echo '<div class="invalid-feedback">'.$message.'</div>';
        }
    }

?>