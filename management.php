<?php $pageTitle="Management"; $pageID="management"; ?>
<?php include_once 'include/page-begin.php' ?>


<?php
    include_once 'include/auth.php';
    requireUserStaffOrAdmin($conn);

?>

<div class="container text-center page-body">
    <h1>Management Page</h1>
    <?php renderMsgs(); ?>

    <!-- Page content goes here! -->
    <?php
    
        if (isset($_SESSION["restId"])){
            $restaurantId = $_SESSION["restId"];
            echo "Your restaurant ID is ".$restaurantId;
        }

    ?>


    <table class="table">
        <thead><tr>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Date</th>
            <th>Time</th>
            <th>Number of Guests</th>
            <th>Approve or Cancel</th>
        </tr></thead>
    <tbody>
        <?php
            $query = $conn->query('SELECT * from restaurant.reservation 
                                   WHERE rest_id='.$restaurantId.'
                                   AND is_cancelled=0 
                                   AND is_approved=0');

            while ($row = $query->fetch_assoc()){
                echo '<tr>';
                echo '<td>'.$row['name'].'</td>';
                echo '<td>'.$row['phone_number'].'</td>';
                echo '<td>'.$row['email'].'</td>';
                echo '<td>'.$row['date'].'</td>';
                echo '<td>'.$row['time'].'</td>';
                echo '<td>'.$row['num_guests'].'</td>';
                echo '<td>';
                    echo ' <a class="btn btn-success mr-1 text-white" href = "management-validate-response-server.php?id='.$row['id'].'"> Validate </button> ';
                    echo ' <a class="btn btn-danger mr-1 text-white" href = "management-cancel-response-server.php?id='.$row['id'].'"> Cancel </button> ';
                echo '</td>';
                echo '</tr>';
            }
        ?>
        </tbody>
    </table>

</div>

<?php include_once 'include/page-end.php' ?>























