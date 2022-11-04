<?php $pageTitle="Log In"; $pageID="login"; ?>
<?php include 'include/page-begin.php' ?>
   
<div class="container text-center page-body" style="max-width: 500px">
    <h5 class="border-bottom pb-3">Log In</h5>
    <!-- Form starts here -->
    <form action="login-response-server.php" method="post">
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

        <!-- Bunch of breaks to move elements down page, probs not the proper way to do it but it works -->
        <br><br><br><br><br><br>

        <!-- Not registered button -->
        <div> 
            <label>
                Not registered?
            </label> 
        </div> 
        <div>
            <a href="/signup.php" class="btn btn-primary">Register Here</a>
        </div>
    </form>
</div>

<!-- <footer>
    <div class="p-3 mb-2 bg-secondary text-white">
        <p>COSC 4351 - Group #1 </p>
    </div>
</footer> -->

<?php include 'include/page-end.php' ?>