<?php include 'include/page-begin.php' ?>
   
    <div class="text-center">
        <div class="p-3 bg-secondary text-white">
        <!-- Form starts here -->
        <form class="container" style="max-width: 500px">
            <!-- Email input field-->
            <div>
                <h3>Email:</h3>
                <input type="email" id="input_email" name="input_email" placeholder="Enter email" class="form-control"><br><br>
            </div>

            <!-- Password input field-->
            <div>
                <h3>Password:</h3>
                <input type="password" id="input_password" name="input_password" size="50" placeholder="Enter Password" class="form-control"><br><br>
            </div>

            <!-- Remember me checkbox -->
            <div class="checkbox"> 
                <label>
                    <input type="checkbox"> Remember me
                </label> 
            </div> 

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
                <button type="submit" class="btn btn-primary">Register Here</button>
            </div>
        </form>
    </div>
</div>

<!-- <footer>
    <div class="p-3 mb-2 bg-secondary text-white">
        <p>COSC 4351 - Group #1 </p>
    </div>
</footer> -->

<?php include 'include/page-end.php' ?>