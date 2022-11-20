<?php $pageTitle="Log In"; $pageID="login"; ?>
<?php include_once 'include/page-begin.php' ?>
<?php include_once 'include/form.php' ?>
<?php include_once 'include/auth.php' ?>
<?php include_once 'include/login-handler.php' ?>

<?php

    $flags = new LoginFlags();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = login($flags);
        if ($user){
            if ($user->type === "ADMIN"){
                        
                header("Location: /admin.php?successmsg=You are now logged in as an admin.");
            }
            else
            {
                header("Location: /?successmsg=You are now logged in.");
            }
        }
    }

?>

<div class="container text-center page-body" style="max-width: 500px">
    <h5 class="border-bottom pb-3">Log In</h5>
    <!-- Form starts here -->
    <?php include 'components/login.php' ?>
</div>

<!-- <footer>
    <div class="p-3 mb-2 bg-secondary text-white">
        <p>COSC 4351 - Group #1 </p>
    </div>
</footer> -->

<?php include_once 'include/page-end.php' ?>