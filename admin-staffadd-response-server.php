<?php $pageTitle="Admin"; $pageID="admin"; ?>
<?php include_once 'include/page-begin.php' ?>
    <?php renderMsgs(); ?>

<?php
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $email = $_REQUEST['email'];
        $name = $_REQUEST['name'];
        $mail = $_REQUEST['mailingaddress'];
        $restID = $_REQUEST['rest-id'];

        echo "POST received. Values are below:";
        echo $username;
        echo $password;
        echo $email;
        echo $name;
        echo $mail;
        
      
        $stmt = $conn->prepare("INSERT INTO restaurant.user (username, email, password, type, name, mail_addr, employed_at_rest)
        VALUES (?,?,?,'Staff', ?,?,?)");
        
        $stmt->bind_param("ssssss",  $username, $email,  hashPassword($password), $name, $mail, $restID);
        $stmt->execute();

        header("Location: admin.php?successmsg=Successfully Added"); 
    }
?>