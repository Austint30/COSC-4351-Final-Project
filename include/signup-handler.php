<?php
include_once 'exceptions.php';
include_once 'connect.php';
include_once 'form.php';
include_once 'auth.php';


class SignUpFlags {
    public bool $signup_failed_msg = false;
    public bool $form_invalid = false;

    public string $emailMsg = "";
    public string $passwordMsg = "";
    public string $rPasswordMsg = "";
    public string $nameMsg = "";
    public string $mailingMsg = "";
    public string $billingMsg = "";
    public string $paymentMsg = "";
}

function signup(SignUpFlags &$flags){
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] != "POST"){
        throw InvalidMethodException("POST method is required");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = validateNotEmpty("email", $flags->$emailMsg, "Email is required", $flags->$form_invalid);
        $password = validateNotEmpty("password", $flags->$passwordMsg, "Password is required", $flags->$form_invalid);

        $passwordValidator = function($rpswd) use ($password){
            if (($rpswd ?? null) === $password){
                return;
            }
            else
            {
                return "Password and Retype Password are not the same";
            }
        };

        $rPassword = validateCustom("retype-password", $passwordValidator, $flags->$rPasswordMsg, $flags->$form_invalid);
        $name = validateNotEmpty("name", $flags->$nameMsg, "Name is required", $form_invalid);
        $mailing = validateNotEmpty("mailing-address", $flags->$mailingMsg, "Mailing address is required", $flags->$form_invalid);
        $sameAsMail = $_POST["mail-same-billing"] ?? null;
        
        $payment = validateNotEmpty("pref-payment", $flags->$paymentMsg, "Preferred payment required", $flags->$form_invalid);

        if ($sameAsMail){
            $billing = $mailing;
        }
        else
        {
            $billing = validateNotEmpty("billing-address", $flags->$billingMsg, "Billing address required", $flags->$form_invalid);
        }

        if (!$form_invalid)
        {
            $stmt = $conn->prepare("INSERT INTO restaurant.user (username, password, email, name, mail_addr, billing_addr, pref_pay_method)
            VALUES (?,?,?,?,?,?,?)");

            $password = hashPassword($password);
        
            $stmt->bind_param("sssssss", $email, $password, $email, $name, $mailing, $billing, $payment);

            try {
                $stmt->execute();
                storeSession($email, $name, $email, null);
                return getCurrentUser();
                exit;
            }
            catch(mysqli_sql_exception $e){
                $flags->$signup_failed_msg = "User already exists";
            }
        }
    }
}

?>