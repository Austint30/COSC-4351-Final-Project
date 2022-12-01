<?php $pageTitle="Admin"; $pageID="admin"; ?>
<?php include_once 'include/page-begin.php' ?>
    <?php renderMsgs(); ?>

<?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $x = $_REQUEST['username'];

        echo "POST received. Values are below:";
        echo $x;        
      
        
        $stmt = $conn->prepare("DELETE FROM restaurant.user WHERE username=?");
        
        $stmt->bind_param("s", $x);
        $stmt->execute();

        header("Location: admin.php?successmsg=Successfully Deleted");
    }
?>