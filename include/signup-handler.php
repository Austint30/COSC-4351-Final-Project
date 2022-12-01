<?php
include_once 'exceptions.php';
include_once 'connect.php';
include_once 'form.php';
include_once 'auth.php';


class SignUpFlags {
    public ?string $signup_failed_msg = null;
    public bool $form_invalid = false;

    public string $emailMsg = "";
    public string $passwordMsg = "";
    public string $rPasswordMsg = "";
    public string $nameMsg = "";
    public string $mailingMsg = "";
    public string $billingMsg = "";
    public string $paymentMsg = "";
}

class SignUpFormData {
    public string $email = "";
    public string $password = "";
    public string $rPassword = "";
    public string $name = "";
    public string $mailing = "";
    public string $sameAsMail = "";
    public string $billing = "";
    public string $payment = "";

}

function signup(SignUpFlags &$flags, SignUpFormData &$formData){
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] != "POST"){
        throw InvalidMethodException("POST method is required");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $formData->email = validateNotEmpty("email", $flags->emailMsg, "Email is required", $flags->form_invalid);
        $formData->password = validateNotEmpty("password", $flags->passwordMsg, "Password is required", $flags->form_invalid);

        $passwordValidator = function($rpswd) use ($formData){
            if (($rpswd ?? null) === $formData->password){
                return;
            }
            else
            {
                return "Password and Retype Password are not the same";
            }
        };

        $formData->rPassword = validateCustom("retype-password", $passwordValidator, $flags->rPasswordMsg, $flags->form_invalid);
        $formData->name = validateNotEmpty("name", $flags->nameMsg, "Name is required", $form_invalid);
        $formData->mailing = validateNotEmpty("mailing-address", $flags->mailingMsg, "Mailing address is required", $flags->form_invalid);
        $formData->sameAsMail = $_POST["mail-same-billing"] ?? "";
        
        $formData->payment = validateNotEmpty("pref-payment", $flags->paymentMsg, "Preferred payment required", $flags->form_invalid);

        if ($formData->sameAsMail){
            $formData->billing = $formData->mailing;
        }
        else
        {
            $formData->billing = validateNotEmpty("billing-address", $flags->billingMsg, "Billing address required", $flags->form_invalid);
        }

        if (!$flags->form_invalid)
        {
            $stmt = $conn->prepare("INSERT INTO restaurant.user (username, password, email, name, mail_addr, billing_addr, pref_pay_method)
            VALUES (?,?,?,?,?,?,?)");

            $password = hashPassword($formData->password);
        
            $stmt->bind_param("sssssss", $formData->email, $password, $formData->email, $formData->name, $formData->mailing, $formData->billing, $formData->payment);
            try {
                $stmt->execute();
                storeSession($formData->email, $formData->name, $formData->email, null);
                return getCurrentUser();
                exit;
            }
            catch(mysqli_sql_exception $e){
                $flags->signup_failed_msg = "User already exists";
            }
        }
    }
}

?>