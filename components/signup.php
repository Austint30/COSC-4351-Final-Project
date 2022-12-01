<!-- Why did I have to include __DIR__? Because this file can be reused by many files in different directories this include gets messed up without using __DIR__ -->
<?php include_once __DIR__."/../include/form.php" ?>

<form id="signup-form" action="signup.php" method="post">
    <?php
        if (isset($flags) && $flags->signup_failed_msg){
            echo '<div class="alert alert-danger mb-2" role="alert">'.$flags->$signup_failed_msg.'</div>';
        }

        $emailMsg = null;
        $passwordMsg = null;
        $rPasswordMsg = null;
        $nameMsg = null;
        $mailingMsg = null;
        $billingMsg = null;
        $paymentMsg = null;

        if (isset($flags)){
            $emailMsg = $flags->emailMsg;
            $passwordMsg = $flags->passwordMsg;
            $rPasswordMsg = $flags->rPasswordMsg;
            $nameMsg = $flags->nameMsg;
            $mailingMsg = $flags->mailingMsg;
            $billingMsg = $flags->billingMsg;
            $paymentMsg = $flags->paymentMsg;
        }

    ?>
    <!-- Email input field-->
    <div>
        <h3 class="required-asterisk">Email:</h3>
        <input id="signup-email" name="email" type="email" placeholder="Enter Email Address" class="form-control <?php echo $emailMsg ? "is-invalid" : "" ?>" value="<?php echo $email ?? "" ?>">
        <?php renderErrorFeedback($emailMsg) ?>
        <br><br>
    </div>

    <!-- Password input field-->
    <div>
        <h3 class="required-asterisk">Password:</h3>
        <input type="password" id="signup-password" name="password" placeholder="Enter Password" class="form-control <?php echo $passwordMsg ? "is-invalid" : "" ?>" value="<?php echo $password ?? "" ?>">
        <?php renderErrorFeedback($passwordMsg) ?>
        <br><br>
    </div>

    <div>
        <h3 class="required-asterisk">Retype-Password:</h3>
        <input type="password" id="signup-retype-password" name="retype-password" placeholder="Retype Password" class="form-control <?php echo $rPasswordMsg ? "is-invalid" : "" ?>" value="<?php echo $rPassword ?? "" ?>">
        <?php renderErrorFeedback($rPasswordMsg) ?>
        <br><br>
    </div>

    <div>
        <h3 class="required-asterisk">Name</h3>
        <input id="signup-name" name="name" placeholder="Your name" class="form-control <?php echo $nameMsg ? "is-invalid" : "" ?>" value="<?php echo $name ?? "" ?>">
        <?php renderErrorFeedback($nameMsg) ?>
        <br><br>
    </div>

    <div>
        <h3 class="required-asterisk">Mailing Address</h3>
        <input id="signup-mailing-address" name="mailing-address" placeholder="Mailing Address" class="form-control <?php echo $mailingMsg ? "is-invalid" : "" ?>" value="<?php echo $mailing ?? "" ?>">
        <?php renderErrorFeedback($mailingMsg) ?>
        <br><br>
    </div>

    <div>
        <h3 class="required-asterisk">Billing Address</h3>
        <span class="mb-1">
            <input type="checkbox" id="signup-mail-same-billing" name="mail-same-billing" value="mail-same-billing" <?php echo isset($sameAsMail) && $sameAsMail ? "checked" : "" ?> />
            <label for="mail-same-billing">Same as mailing address</label>
        </span>
        <input id="signup-billing-address" name="billing-address" placeholder="Billing Address" class="form-control <?php echo $billingMsg ? "is-invalid" : "" ?>" value="<?php echo isset($sameAsMail) && $sameAsMail ? "" : $billing ?? "" ?>">
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