<?php $pageTitle="Sign Up"; $pageID="signup"; ?>
<?php include_once 'include/page-begin.php' ?>
<?php include_once 'include/form.php' ?>

<?php
    
    $signup_failed_msg = null;

    $emailMsg = null;
    $passwordMsg = null;
    $rPasswordMsg = null;
    $nameMsg = null;
    $mailingMsg = null;
    $billingMsg = null;
    $paymentMsg = null;
    $formHasError = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = validateNotEmpty("email", $emailMsg, "Email is required", $formHasError);
        $password = validateNotEmpty("password", $passwordMsg, "Password is required", $formHasError);

        $passwordValidator = function($rpswd) use ($password){
            if (($rpswd ?? null) === $password){
                return;
            }
            else
            {
                return "Password and Retype Password are not the same";
            }
        };

        $rPassword = validateCustom("retype-password", $passwordValidator, $rPasswordMsg, $formHasError);
        $name = validateNotEmpty("name", $nameMsg, "Name is required", $formHasError);
        $mailing = validateNotEmpty("mailing-address", $mailingMsg, "Mailing address is required", $formHasError);
        $sameAsMail = $_POST["mail-same-billing"] ?? null;
        
        $payment = validateNotEmpty("pref-payment", $paymentMsg, "Preferred payment required", $formHasError);

        if ($sameAsMail){
            $billing = $mailing;
        }
        else
        {
            $billing = validateNotEmpty("billing-address", $billingMsg, "Billing address required", $formHasError);
        }

        if (!$formHasError)
        {
            $stmt = $conn->prepare("INSERT INTO restaurant.user (username, password, email, name, mail_addr, billing_addr, pref_pay_method)
            VALUES (?,?,?,?,?,?,?)");
        
            $stmt->bind_param("sssssss", $email, hashPassword($password), $email, $name, $mailing, $billing, $payment);

            try {
                $stmt->execute();
                storeSession($username, $name, $email);
                header("Location: /?successmsg=Account was successfully created! You are now logged in.");
                exit;
            }
            catch(mysqli_sql_exception $e){
                $signup_failed_msg = "User already exists";
            }
        }
    }
?>
   
<div class="container text-center page-body" style="max-width: 500px">
    <h5 class="border-bottom pb-3">Sign Up</h5>
    <!-- Form starts here -->
    <form action="signup.php" method="post">
        <?php
            if ($signup_failed_msg){
                echo '<div class="alert alert-danger mb-2" role="alert">'.$signup_failed_msg.'</div>';
            }
        ?>
        <!-- Email input field-->
        <div>
            <h3 class="required-asterisk">Email:</h3>
            <input id="email" name="email" type="email" placeholder="Enter Email Address" class="form-control <?php echo $emailMsg ? "is-invalid" : "" ?>" value="<?php echo $email ?? "" ?>">
            <?php renderErrorFeedback($emailMsg) ?>
            <br><br>
        </div>

        <!-- Password input field-->
        <div>
            <h3 class="required-asterisk">Password:</h3>
            <input type="password" id="password" name="password" placeholder="Enter Password" class="form-control <?php echo $passwordMsg ? "is-invalid" : "" ?>" value="<?php echo $password ?? "" ?>">
            <?php renderErrorFeedback($passwordMsg) ?>
            <br><br>
        </div>

        <div>
            <h3 class="required-asterisk">Retype-Password:</h3>
            <input type="password" id="retype-password" name="retype-password" placeholder="Retype Password" class="form-control <?php echo $rPasswordMsg ? "is-invalid" : "" ?>" value="<?php echo $rPassword ?? "" ?>">
            <?php renderErrorFeedback($rPasswordMsg) ?>
            <br><br>
        </div>

        <div>
            <h3 class="required-asterisk">Name</h3>
            <input id="name" name="name" placeholder="Your name" class="form-control <?php echo $nameMsg ? "is-invalid" : "" ?>" value="<?php echo $name ?? "" ?>">
            <?php renderErrorFeedback($nameMsg) ?>
            <br><br>
        </div>

        <div>
            <h3 class="required-asterisk">Mailing Address</h3>
            <input id="mailing-address" name="mailing-address" placeholder="Mailing Address" class="form-control <?php echo $mailingMsg ? "is-invalid" : "" ?>" value="<?php echo $mailing ?? "" ?>">
            <?php renderErrorFeedback($mailingMsg) ?>
            <br><br>
        </div>

        <div>
            <h3 class="required-asterisk">Billing Address</h3>
            <span class="mb-1">
                <input type="checkbox" id="mail-same-billing" name="mail-same-billing" value="mail-same-billing" <?php echo isset($sameAsMail) && $sameAsMail ? "checked" : "" ?> />
                <label for="mail-same-billing">Same as mailing address</label>
            </span>
            <input id="billing-address" name="billing-address" placeholder="Billing Address" class="form-control <?php echo $billingMsg ? "is-invalid" : "" ?>" value="<?php echo isset($sameAsMail) && $sameAsMail ? "" : $billing ?? "" ?>">
            <?php renderErrorFeedback($billingMsg) ?>
            <br><br>
        </div>

        <div>
            <h3 class="required-asterisk">Preferred Payment Method</h3>
            <select class="form-control <?php echo $paymentMsg ? "is-invalid" : "" ?>" name="pref-payment" value="<?php echo $payment ?? "" ?>">
                <option value="CARD">Card</option>
                <option value="CASH">Cash</option>
                <option value="CHECK">Check</option>
            </select>
            <?php renderErrorFeedback($paymentMsg) ?>
            <br><br>
        </div>

        <!-- Submit button -->
        <div>
            <button type="submit" class="btn btn-primary">Submit</button> </form> 
        </div>
    </form>
</div>

<script>
    let billingEl = document.getElementById('billing-address');
    let mailSameBillEl = document.getElementById('mail-same-billing');

    mailSameBillEl.addEventListener('click', onCheckClicked);

    function onCheckClicked(){
        if (mailSameBillEl.checked){
            billingEl.setAttribute("disabled", "");
        }
        else if (billingEl.hasAttribute("disabled")){
            billingEl.removeAttribute("disabled");
        }
    }

    onCheckClicked();
</script>

<!-- <footer>
    <div class="p-3 mb-2 bg-secondary text-white">
        <p>COSC 4351 - Group #1 </p>
    </div>
</footer> -->

<?php include_once 'include/page-end.php' ?>