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
        
        //here we update name
        if (!empty($name)){
            $stmt = $conn->prepare("UPDATE restaurant.user
                                    SET name = ?
                                    WHERE username=?");
            $stmt->bind_param("ss", $name, $username);
            $stmt->execute();
        }
        
        //here we update password
        if (!empty($password)){
            $stmt = $conn->prepare("UPDATE restaurant.user
                                    SET password = ?
                                    WHERE username=?");
            $stmt->bind_param("ss",  hashPassword($password), $username);
            $stmt->execute();
        }
                
        //here we update email
        if (!empty($email)){
            $stmt = $conn->prepare("UPDATE restaurant.user
                                    SET email = ?
                                    WHERE username=?");
            $stmt->bind_param("ss", $email, $username);
            $stmt->execute();
        }
        if (!empty($mail)){
            $stmt = $conn->prepare("UPDATE restaurant.user
                                    SET mail_addr = ?
                                    WHERE username=?");
            $stmt->bind_param("ss", $mail, $username);
            $stmt->execute();
        }
        if (!empty($restID)){
            $stmt = $conn->prepare("UPDATE restaurant.user
                                    SET employed_at_rest = ?
                                    WHERE username=?");
            $stmt->bind_param("ss", $restID, $username);
            $stmt->execute();
        }
        


        header("Location: admin.php?successmsg=Successfully Edited");
    }
?>