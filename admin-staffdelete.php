
<?php $pageTitle="Admin"; $pageID="admin"; ?>
<?php include_once 'include/page-begin.php' ?>

<?php
    include_once 'include/auth.php';
    requireUserAdmin($conn);
    //$resDateMsg = null;
?>

<div class="container page-body">
    <h1 class="mt-3">Admin Delete Staff Page</h1>
    <?php renderMsgs(); ?>

    <!-- <h3>Select location to delete:</h3> -->
    <!-- Restaurant selection field-->

    <form action="admin-staffdelete-response-server.php" method="POST">
        <div>
            <label for="Staff-select" class="required-asterisk">Choose Staff member to Delete</label>
            <?php
                $query = $conn->query('SELECT * FROM restaurant.user LEFT JOIN restaurant.restaurant ON employed_at_rest = id;');
                echo'<select name="username" id="Staff-select" class="form-control"> ';
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
            <br>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Delete</button>
        </div>
    </form>
</div>

<?php include_once 'include/page-end.php' ?>