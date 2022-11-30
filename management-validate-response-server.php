<?php

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = ($_GET['id']);
        echo $id;


        //for validation change is_approved to 1
        //award points to the user who booked the reservation and update it
        header("Location: management.php?successmsg=Successfully Validated");
    }

?>