
<?php $pageTitle="Admin"; $pageID="admin"; ?>
<?php include_once 'include/page-begin.php' ?>

<?php
    include_once 'include/auth.php';
    requireUserAdmin($conn);

?>

<div class="container page-body">
    <h1 class="mt-3">Admin Edit Staff Page</h1>
    <p class="text-danger">Fields which do not need editing should remain empty!</p>
    <?php renderMsgs(); ?>

    <!-- <h3>Select location to delete:</h3> -->
    <!-- Restaurant selection field-->

    <form action="admin-staffedit-response-server.php" method="POST">
    <div class="form-group">
    <label for="Staff-select" class="required-asterisk">Choose Staff member to Edit</label>
            <?php
                $query = $conn->query('SELECT * FROM restaurant.user LEFT JOIN restaurant.restaurant ON employed_at_rest = id;');
                echo'<select name="username" id="Staff-select" class="form-control ';
                echo '<option value="">Select a staff member</option>';
                while ($row = $query->fetch_assoc()){
                    echo "<option ";
                    if ($row['username'] === ($username ?? '')){
                        echo "selected ";
                    }
                    echo "value='".$row['username']."'>" .$row['name'].", ".$row["email"].", Employed At: ".$row['street_address'].", ".$row["city"].", ".$row["state"]."</option>";
                }
                echo'</select>';
            ?>
</div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter Password">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" placeholder="Enter Email Address">
        </div>
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name" placeholder="Enter First and Last Name">
        </div>
        <div class="form-group">
            <label>Mailing Address</label>
            <input type="text" class="form-control" name="mailingaddress" placeholder="Enter Mailing address">
        </div>
        <div class="form-group">
            <label for="restaurant-select" class="required-asterisk">Employed at restaurant </label>
            <?php
                $query = $conn->query('SELECT * FROM restaurant.restaurant;');
                echo'<select name="rest-id" id="restaurant-select" class="form-control"> ';
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
        <div>
            <button type="submit" class="btn btn-primary">Edit</button>
        </div>
    </form>
</div>

<?php include_once 'include/page-end.php' ?>