<?php
    include_once '../include/connect.php';
    include_once '../include/form.php';
    include_once '../include/auth.php';

    $login_failed = false;
    $form_invalid = false;
    $usernameMsg = null;
    $passwordMsg = null;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userId = validateNotEmpty("username", $usernameMsg, "Username is required", $form_invalid);
        $password = validateNotEmpty("password", $passwordMsg, "Password is required", $form_invalid);

        if (!$form_invalid){
            $stmt = $conn->prepare("SELECT username, email, password, type, name
                                FROM restaurant.user 
                                WHERE (username = ? OR email = ?);");
        
            $stmt->bind_param("ss", $userId, $userId);

            $stmt->execute();

            $result = $stmt->get_result();

            while ($user = $result->fetch_object()){
                if (password_verify($password, $user->password)){
                    // Login successful! Add username to session.
                    storeSession($user->username, $user->name, $user->email);
                    if ($user->type === "ADMIN"){
                        header("Location: /admin.php?successmsg=You are now logged in as an admin.");
                    }
                    else
                    {
                        header("Location: /?successmsg=You are now logged in.");
                    }
                    exit;
                }
            }

            // No users found with that password.
            $login_failed = true;
        }

        
    }
?>


<!-- Form starts here -->
<form action="login.php" method="post">
    <?php
        if ($login_failed){
            echo '<div class="alert alert-danger mb-2" role="alert">Invalid username or password</div>';
        }
    ?>
    <!-- Email input field-->
    <div>
        <h3>Email:</h3>
        <input id="email" name="username" placeholder="Enter Email Address" class="form-control <?php echo $usernameMsg ? "is-invalid" : "" ?>" value="<?php echo $userId ?? "" ?>">
        <?php renderErrorFeedback($usernameMsg) ?>
        <br><br>
    </div>

    <!-- Password input field-->
    <div>
        <h3>Password:</h3>
        <input type="password" id="password" name="password" placeholder="Enter Password" class="form-control <?php echo $passwordMsg ? "is-invalid" : "" ?>" value="<?php echo $password ?? "" ?>">
        <?php renderErrorFeedback($passwordMsg) ?>
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