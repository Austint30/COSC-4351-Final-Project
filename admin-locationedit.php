
<?php $pageTitle="Admin"; $pageID="admin"; ?>
<?php include_once 'include/page-begin.php' ?>

<?php
    include_once 'include/auth.php';
    requireUserAdmin($conn);

?>

<div class="container page-body">
    <h1 class="mt-3">Admin Edit Location Page</h1>
    <p class="text-danger">Fields which do not need editing should remain empty!</p>
    <?php renderMsgs(); ?>

    <!-- <h3>Select location to delete:</h3> -->
    <!-- Restaurant selection field-->

    <form action="admin-locationedit-response-server.php" method="POST">
        <div>
            <label for="restaurant-select" class="required-asterisk">Choose Location to Edit</label>
            <?php
                $query = $conn->query('SELECT * FROM restaurant.restaurant;');
                echo'<select name="rest-id" id="restaurant-select" class="form-control ';
                echo '<option value="">Select a restaurant</option>';
                while ($row = $query->fetch_assoc()){
                    echo "<option ";
                    if ($row['id'] === ($restId ?? '')){
                        echo "selected ";
                    }
                    echo "value='".$row['id']."'>" .$row['street_address'].", ".$row["city"].", ".$row["state"]."</option>";
                }
                echo'</select>';
            ?>
            <br>
        </div>
        
        <div class="form-group">
            <label>New Street Address (if needed)</label>
            <input type="text" class="form-control" name="address" placeholder="Enter street address">
            <small class="form-text text-muted">Address should not contain city, state, or country</small>
        </div>
                
        <div class="form-group">
            <label>New City (if needed)</label>
            <input type="text" class="form-control" name="city" placeholder="Enter city name">
        </div>

        <div>
            <label>New State (if needed)</label>
            <select class="form-control" name="state">
                <option value="" selected="selected">Select a State</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District Of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
            </select>
        </div>

        <br>

        <div>
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </form>
</div>

<?php include_once 'include/page-end.php' ?>