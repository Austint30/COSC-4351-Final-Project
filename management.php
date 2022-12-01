<?php $pageTitle="Management"; $pageID="management"; ?>
<?php include_once 'include/page-begin.php' ?>


<?php
    include_once 'include/auth.php';
    requireUserStaffOrAdmin();

?>

<div class="container text-center page-body" style="min-width: 1521px;">
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
            <th class="text-left">Complete or Cancel</th>
        </tr></thead>
    <tbody>
        <?php
            $query = $conn->query('SELECT reservation.id AS resv_id, reservation.name as name, phone_number, reservation.email as email, date, time, num_guests, username, reservation.rest_id, GROUP_CONCAT(CONCAT(num_seats, \' Seat Table\') SEPARATOR \', \') as tables from restaurant.reservation 
                LEFT JOIN restaurant.reserved_table ON resv_id=reservation.id
                LEFT JOIN restaurant.r_table ON r_table.id=reserved_table.table_id
                LEFT JOIN restaurant.user ON user.username=reservation.user
                WHERE reservation.rest_id='.$restaurantId.'
                AND is_cancelled=0
                AND is_approved=0
                GROUP BY resv_id
                ORDER BY date, time ASC');
            
            // This query will return duplicate reservations with each table 

            while ($row = $query->fetch_assoc()){

                $username = $row["username"];

                echo '<tr>';
                echo '<td>'.$row['name'].'</td>';
                echo '<td>'.$row['phone_number'].'</td>';
                echo '<td>'.$row['email'].'</td>';
                echo '<td style=\'white-space: nowrap;\'>'.$row['date'].'</td>';
                echo '<td style=\'white-space: nowrap;\'>'.$row['time'].'</td>';
                echo '<td>'.$row['num_guests'].'</td>';
                echo '<td>'.str_replace(', ', '<br>', $row['tables']).'</td>';
                echo '<td style=\'white-space: nowrap; width: 400px;\'>';
                    echo '<form action="management-validate-response-server.php" method="POST" class="form-inline">';
                        echo '<input hidden name="id" value="'.$row['resv_id'].'">';
                        echo '<div class="form-group mb-2 mr-1">';
                        if ($username){
                            echo '<div class="input-group">';
                                echo '<div class="input-group-prepend">';
                                    echo '<span class="input-group-text" id="basic-addon1">$</span>';
                                echo '</div>';
                                echo '<input style="width: 80px;" class="form-control" name="dollars" type="number" min="1" value="1" max="100" />';
                                echo '<div class="input-group-append">';
                        }
                                    echo '<button title="Removes reservation from list and gives the user a point for every dollar." class="btn btn-success mr-1 text-white">Complete</button> ';
                        if ($username){
                                echo '</div>';
                            echo '</div>';
                        }
                        echo '</div>';
                        echo '<div class="form-group mb-2">';
                            echo ' <a title="Cancels the reservation and removes from list." class="btn btn-danger mr-1 text-white" href = "management-cancel-response-server.php?id='.$row['resv_id'].'"> Cancel </a>';
                        echo '</div>';
                    echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        ?>
        </tbody>
    </table>

</div>

<?php include_once 'include/page-end.php' ?>























