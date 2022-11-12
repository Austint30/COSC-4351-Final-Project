<?php $pageTitle="Reservations"; $pageID="reservations" ?>
<?php include_once 'include/page-begin.php' ?>


<div class="container text-center page-body" style="max-width: 500px">
    <h5 class="border-bottom pb-3">Reserve a Table</h5>
    <!-- Form starts here -->
    <form action="" method="post">
        <!-- Name input field-->
        <div>
            <h3>Name</h3>
            <input id="name" name="name" placeholder="Enter Full Name" class="form-control">
            <br>
        </div>

        <!-- Phone Number input field-->
        <div>
            <h3>Phone Number</h3>
            <input type="tel" id="phonenumber" name="phonenumber" placeholder="Enter Phone Number" class="form-control">
            <br>
        </div>

        <!-- Email input field-->
        <div>
            <h3>Email Address</h3>
            <input type="email" id="emailaddress" name="emailaddress" placeholder="Enter Email Address Number" class="form-control">
            <br>
        </div>

        <!-- Num Guests input field-->
        <div style="max-width: 200px">
            <h3>Guest Amount </h3>
            <input type="number" id="numguests" name="numguests" placeholder="Enter Number of Guests" class="form-control">
            <br>
        </div>

        <h3>Date and Time</h3>
        <div class="input-group">
            <!-- Date input field -->
            <input type="date" class="form-control input-sm" id="date" name="date"/>
    
            <!-- making gap 0 -->
            <span class="input-group-btn" style="width:0px;"></span>
    
            <!-- Time input field -->
            <input type="time" class="form-control input-sm" id="time" name="time"/>
            <br>
        </div>
        
        <!-- Fee warning -->
        <div>
            <p class="text-danger">Please note that on high traffic days a $10 holding fee will be placed, and returned upon arrival. If you do not show up then it is not refunded</p>
        </div>

        <!-- Submit button -->
        <div>
            <button type="submit" class="btn btn-primary">Submit</button>  
        </div>
    </form>
</div>


<?php include_once 'include/page-end.php' ?>