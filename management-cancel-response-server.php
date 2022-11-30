<?php $pageTitle="Admin"; $pageID="admin"; ?>
<?php include_once 'include/page-begin.php' ?>
<?php renderMsgs(); ?>

<?php

    //we are using GET because we are getting parameter ID from the URL, if we were not then POST would have been preferred.
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = ($_GET['id']);
        echo $id;

        $stmt = $conn->prepare("UPDATE restaurant.reservation 
                                    SET is_cancelled = 1
                                    WHERE id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        //for validation change is_approved to 1
        //award points to the user who booked the reservation and update it
        
        //^^^will need to use prepare statement^^^
        //SELECT username, points FROM restaurant.reservation JOIN restaurant.user ON reservation.user = restaurant.user.username WHERE reservation.id = ?;
        //if the fetch assoc is NULL^^, then the reservation is not attached to a user and isnt signed in therefore no points!
        
        header("Location: management.php?successmsg=Successfully Cancelled");
    }

?>