<?php $pageTitle="Admin"; $pageID="admin"; ?>
<?php include_once 'include/page-begin.php' ?>
    <?php renderMsgs(); ?>

<?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $location = $_REQUEST['rest-id']; 
        $address = $_REQUEST['address'];
        $city = $_REQUEST['city'];
        $state = $_REQUEST['state'];

        echo "POST received. Values are below:";
        echo $location;
        echo $address;
        echo $city;
        echo $state;
        
        //here we update address
        if (!empty($address)){
            $stmt = $conn->prepare("UPDATE restaurant.restaurant 
                                    SET street_address = ?
                                    WHERE id=?");
            $stmt->bind_param("ss", $address, $location);
            $stmt->execute();
        }
        
        //here we update city
        if (!empty($city)){
            $stmt = $conn->prepare("UPDATE restaurant.restaurant 
            SET city = ?
            WHERE id=?");
            $stmt->bind_param("ss", $city, $location);
            $stmt->execute();
        }
        
        //here we update state
        if (!empty($state)){
            $stmt = $conn->prepare("UPDATE restaurant.restaurant 
                                    SET state = ?
                                    WHERE id=?");
            $stmt->bind_param("ss", $state, $location);
            $stmt->execute();
        }


        header("Location: admin.php?successmsg=Successfully Edited");
    }
?>