<?php $pageTitle="Sign Up"; $pageID="signup"; ?>
<?php include 'include/page-begin.php' ?>
   
<div class="container text-center page-body" style="max-width: 500px">
    <h5 class="border-bottom pb-3">Sign Up</h5>
    <!-- Form starts here -->
    <form action="signup-response-server.php" method="post">
        <?php
            if (isset($_GET["errormsg"])){
                echo '<div class="alert alert-danger mb-2" role="alert">'.$_GET["errormsg"].'</div>';
            }
        ?>
        <!-- Email input field-->
        <div>
            <h3>Email:</h3>
            <input id="email" name="email" type="email" placeholder="Enter Email Address" class="form-control"><br><br>
        </div>

        <!-- Password input field-->
        <div>
            <h3>Password:</h3>
            <input type="password" id="password" name="password" placeholder="Enter Password" class="form-control"><br><br>
        </div>

        <div>
            <h3>Retype-Password:</h3>
            <input type="password" id="retype-password" name="retype-password" placeholder="Retype Password" class="form-control"><br><br>
        </div>

        <div>
            <h3>Name</h3>
            <input id="name" name="name" placeholder="Your name" class="form-control"><br><br>
        </div>

        <div>
            <h3>Mailing Address</h3>
            <input id="mailing-address" name="mailing-address" placeholder="Mailing Address" class="form-control"><br><br>
        </div>

        <div>
            <h3>Billing Address</h3>
            <input id="billing-address" name="billing-address" placeholder="Billing Address" class="form-control">
            <input type="checkbox" id="mail-same-billing" name="mail-same-billing" />
            <label for="mail-same-billing">Same as mailing address</label>
            <br><br>
        </div>

        <div>
            <h3>Preferred Payment Method</h3>
            <select class="form-control" name="pref-payment">
                <option value="CARD">Card</option>
                <option value="CASH">Cash</option>
                <option value="CHECK">Check</option>
            </select><br><br>
        </div>

        <!-- Submit button -->
        <div>
            <button type="submit" class="btn btn-primary">Submit</button> </form> 
        </div>
    </form>
</div>

<!-- <footer>
    <div class="p-3 mb-2 bg-secondary text-white">
        <p>COSC 4351 - Group #1 </p>
    </div>
</footer> -->

<?php include 'include/page-end.php' ?>