
<!-- Why did I have to include __DIR__? Because this file can be reused by many files in different directories this include gets messed up without using __DIR__ -->
<?php include_once __DIR__."/../include/form.php" ?>

<!-- Form starts here -->
<form id="login-form" action="login.php" method="post">
    <?php
        if (isset($flags) && $flags->login_failed){
            echo '<div class="alert alert-danger mb-2" role="alert">Invalid username or password</div>';
        }
    ?>
    <!-- Email input field-->
    <div>
        <h3>Email:</h3>
        <input id="email" name="username" placeholder="Enter Email Address" class="form-control <?php echo (isset($flags) && $flags->usernameMsg) ? "is-invalid" : "" ?>" value="<?php echo $userId ?? "" ?>">
        <?php renderErrorFeedback($flags->usernameMsg ?? null) ?>
        <br><br>
    </div>

    <!-- Password input field-->
    <div>
        <h3>Password:</h3>
        <input type="password" id="password" name="password" placeholder="Enter Password" class="form-control <?php echo (isset($flags) && $flags->passwordMsg) ? "is-invalid" : "" ?>" value="<?php echo $password ?? "" ?>">
        <?php renderErrorFeedback($flags->passwordMsg ?? null) ?>
        <br><br>
    </div>

    <!-- Remember me checkbox -->
    <!-- <div class="checkbox"> 
        <label>
            <input type="checkbox"> Remember me
        </label> 
    </div>  -->

    <!-- Submit button -->
    <div>
        <button type="submit" class="btn btn-primary">Submit</button> </form> 
    </div>
</form>