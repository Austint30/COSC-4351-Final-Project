
<?php $pageTitle="Admin"; $pageID="admin"; ?>
<?php include_once 'include/page-begin.php' ?>

<?php
    include_once 'include/auth.php';
    requireUserAdmin($conn);

?>

<div class="container page-body">
    <h1 class="mt-3">Admin Control Page</h1>
    <?php renderMsgs(); ?>

    <h3>Add a location:</h3>
    <form action="admin-addlocation.php" method="POST">
        <div class="form-group">
            <label>Street Address</label>
            <input type="text" class="form-control" name="address" placeholder="Enter street address">
            <small class="form-text text-muted">Address should not contain city, state, or country</small>
        </div>

        <div class="form-group">
            <label>City</label>
            <input type="text" class="form-control" name="city" placeholder="Enter city name">
        </div>

        <div>
            <label>State</label>
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
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

    <br><br>
    <h3>View Locations:</h3>
    <h5>Restaurants</h5>
    <table class="table">
        <thead><tr>
            <th>Street Address</th>
            <th>City</th>
            <th>State</th>
        </tr></thead>
    <tbody>
        <?php
            $query = $conn->query('SELECT * FROM restaurant.restaurant;');

            while ($row = $query->fetch_assoc()){
                echo '<tr>';
                echo '<td>'.$row['street_address'].'</td>';
                echo '<td>'.$row['city'].'</td>';
                echo '<td>'.$row['state'].'</td>';
                echo '</tr>';
            }
        ?>
        </tbody>
    </table>
</div>

<?php include_once 'include/page-end.php' ?>