<?php $pageTitle="Admin"; $pageID="admin"; ?>
<?php include_once 'include/page-begin.php' ?>

<?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $address = $_REQUEST['address'];
        $city = $_REQUEST['city'];
        $state = $_REQUEST['state'];

        echo "POST received. Values are below:";
        echo $address;
        echo $city;
        echo $state;
        
      
        $stmt = $conn->prepare("INSERT INTO restaurant.restaurant (street_address, city, state)
        VALUES (?,?,?)");
        
        $stmt->bind_param("sss", $address, $city, $state);
        $stmt->execute();
    }
?>