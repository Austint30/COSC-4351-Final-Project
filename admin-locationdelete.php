
<?php $pageTitle="Admin"; $pageID="admin"; ?>
<?php include_once 'include/page-begin.php' ?>

<?php
    include_once 'include/auth.php';
    requireUserAdmin($conn);
    //$resDateMsg = null;
?>

<div class="container page-body">
    <h1 class="mt-3">Admin Delete Location Page</h1>
    <?php renderMsgs(); ?>

    <!-- <h3>Select location to delete:</h3> -->
    <!-- Restaurant selection field-->

    <form action="admin-locationdelete-response-server.php" method="POST">
        <div>
            <label for="restaurant-select" class="required-asterisk">Choose Location to Delete</label>
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

        <div>
            <button type="submit" class="btn btn-primary">Delete</button>
        </div>
    </form>
</div>

<?php include_once 'include/page-end.php' ?>