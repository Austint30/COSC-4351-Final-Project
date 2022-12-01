
<?php $pageTitle="Admin"; $pageID="admin"; ?>
<?php include_once 'include/page-begin.php' ?>

<?php
    include_once 'include/auth.php';
    requireUserAdmin($conn);

?>

<div class="container page-body">
    <h1 class="mt-3">Admin Add Staff Page</h1>
    <?php renderMsgs(); ?>

    <h3>Add a location:</h3>
    <form action="admin-staffadd-response-server.php" method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" name="username" placeholder="Enter Username" required>
            <small class="form-text text-muted">User name should not be the same as staff's real name</small>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" placeholder="Enter Email Address" required>
        </div>
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="name" placeholder="Enter First and Last Name" required>
        </div>
        <div class="form-group">
            <label>Mailing Address</label>
            <input type="text" class="form-control" name="mailingaddress" placeholder="Enter Mailing address" required>
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
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

    <br><br>
    <h3>View Staff:</h3>
    <h5>Staff</h5>
    <table class="table">
        <thead><tr>
            <th>Username</th>
            <th>Email</th>
            <th>Name</th>
            <th>Address</th>
        </tr></thead>
    <tbody>
        <?php
            $query = $conn->query('SELECT * FROM restaurant.user;');

            while ($row = $query->fetch_assoc()){
                echo '<tr>';
                echo '<td>'.$row['username'].'</td>';
                echo '<td>'.$row['email'].'</td>';
                echo '<td>'.$row['name'].'</td>';
                echo '<td>'.$row['mail_addr'].'</td>';
                echo '</tr>';
            }
        ?>
        </tbody>
    </table>
</div>

<?php include_once 'include/page-end.php' ?>