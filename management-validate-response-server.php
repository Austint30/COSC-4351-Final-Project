<?php

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = ($_GET['id']);
        echo $id;


        //for validation change is_approved to 1
        //award points to the user who booked the reservation and update it
        
        //^^^will need to use prepare statement^^^
        //SELECT username, points FROM restaurant.reservation JOIN restaurant.user ON reservation.user = restaurant.user.username WHERE reservation.id = ?;
        //if the fetch assoc is NULL^^, then the reservation is not attached to a user and isnt signed in therefore no points!
        
        header("Location: management.php?successmsg=Successfully Validated");
    }

?>