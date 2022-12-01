<?php $pageTitle="Sign Up"; $pageID="signup"; ?>
<?php include_once 'include/page-begin.php' ?>
<?php include_once 'include/form.php' ?>
<?php include_once 'include/signup-handler.php' ?>

<?php

    $flags = new SignUpFlags();
    $formData = new SignUpFormData();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = signup($flags, $formData);

        if ($user){
            header("Location: /?successmsg=Account was successfully created! You are now logged in.");
        }
    }
?>
   
<div class="container text-center page-body" style="max-width: 500px">
    <h5 class="border-bottom pb-3">Sign Up</h5>
    <!-- Form starts here -->
    <?php include 'components/signup.php' ?>
</div>

<!-- <footer>
    <div class="p-3 mb-2 bg-secondary text-white">
        <p>COSC 4351 - Group #1 </p>
    </div>
</footer> -->

<?php include_once 'include/page-end.php' ?>