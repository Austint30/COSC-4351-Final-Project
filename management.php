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
            <th>Tables needed</th>
            <th>Approve or Cancel</th>
        </tr></thead>
    <tbody>
        <?php
            $query = $conn->query('SELECT reservation.id AS resv_id, name, phone_number, email, date, time, num_guests, user, reservation.rest_id, GROUP_CONCAT(CONCAT(num_seats, \' Seat Table\') SEPARATOR \', \') as tables from restaurant.reservation 
                LEFT JOIN restaurant.reserved_table ON resv_id=reservation.id
                LEFT JOIN restaurant.r_table ON r_table.id=reserved_table.table_id
                WHERE reservation.rest_id='.$restaurantId.'
                AND is_cancelled=0
                AND is_approved=0
                GROUP BY resv_id
                ORDER BY date, time ASC');
            
            // This query will return duplicate reservations with each table 

            while ($row = $query->fetch_assoc()){
                echo '<tr>';
                echo '<td>'.$row['name'].'</td>';
                echo '<td>'.$row['phone_number'].'</td>';
                echo '<td>'.$row['email'].'</td>';
                echo '<td style=\'white-space: nowrap;\'>'.$row['date'].'</td>';
                echo '<td style=\'white-space: nowrap;\'>'.$row['time'].'</td>';
                echo '<td>'.$row['num_guests'].'</td>';
                echo '<td>'.str_replace(', ', '<br>', $row['tables']).'</td>';
                echo '<td style=\'white-space: nowrap;\'>';
                    echo ' <a title="Removes reservation from list and gives the user a point." class="btn btn-success mr-1 text-white" href = "management-validate-response-server.php?id='.$row['resv_id'].'"> Approve </button> ';
                    echo ' <a title="Cancels the reservation and removes from list." class="btn btn-danger mr-1 text-white" href = "management-cancel-response-server.php?id='.$row['resv_id'].'"> Cancel </button> ';
                echo '</td>';
                echo '</tr>';
            }
        ?>
        </tbody>
    </table>

</div>

<?php include_once 'include/page-end.php' ?>























