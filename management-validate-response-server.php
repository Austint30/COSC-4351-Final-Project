<?php $pageTitle="Admin"; $pageID="admin"; ?>
<?php include_once 'include/page-begin.php' ?>
<?php renderMsgs(); ?>

<?php

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $id = ($_GET['id']);
        echo $id;

        //here we are approving the reservation
        $stmt = $conn->prepare("UPDATE restaurant.reservation 
                                SET is_approved = 1
                                WHERE id=?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        
        //now we want the username and the points needed
        $stmt2 = $conn->prepare("SELECT username, points FROM restaurant.reservation JOIN restaurant.user ON reservation.user = restaurant.user.username WHERE reservation.id = ?");
        $stmt2->bind_param("s", $id);
        $stmt2->execute();
        
        $result = $stmt2->get_result();
        $row = $result->fetch_assoc();  
        $username = $row['username'];
        $points = $row['points'];

        //check if the username is not empty, if it is not empty then we increase the points and update
        if (!empty($username)){
            $points++;
            $stmt3 = $conn->prepare("UPDATE restaurant.user 
                                    SET points = ?
                                    WHERE username=?");
            $stmt3->bind_param("is", $points, $username);
            $stmt3->execute();
        }


        header("Location: management.php?successmsg=Successfully Approved");
    }



    // //now we have to check if the reservation has a proper name associated with it
        // $email = $conn->prepare("SELECT email 
        //                          FROM restaurant.reservation
        //                          WHERE id=?");
        // $stmt->bind_param("s", $id);
        // $stmt->execute();

        // if(!empty($email)){
        // if(!empty($email)){
        //     echo "NOT EMPTY!";
        //     $points = $conn->prepare("SELECT points 
        //                               FROM restaurant.user
        //                               WHERE username=?");
        //     $points->bind_param("s", $email);
        //     $points->execute();
        //     $points = $points + 1;


        //     $upd = $conn->prepare("UPDATE restaurant.user 
        //                             SET points = ?
        //                             WHERE id=?");
        //     $upd->bind_param("ss", $points, $email);
        //     $upd->execute();
        // }

            


        //award points to the user who booked the reservation and update it        
        //SELECT username, points FROM restaurant.reservation JOIN restaurant.user ON reservation.user = restaurant.user.username WHERE reservation.id = ?;
        //if the fetch assoc is NULL^^, then the reservation is not attached to a user and isnt signed in therefore no points!

        //SELECT username, points 
        //FROM restaurant.reservation JOIN restaurant.user ON reservation.user = restaurant.user.username 
        //WHERE reservation.id = ?;
?>
<?php include_once 'include/page-end.php' ?>
