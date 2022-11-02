<?php
    include 'include/connect.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userId = $_POST['username'];
        $password = $_POST["password"];

        $query = $conn->query("SELECT username, password 
                                FROM restaurant.user 
                                WHERE username = '$userId' AND password = '$password';");
        
        

        $hasResult = $query->fetch_array();
        if ($hasResult){
            setcookie("username", $userId, time() + (86400 * 30*2), "/"); // 86400 = 2 days
            header("Location: /");
        }
        else
        {
            header("Location: /login.php?errormsg=Password is incorrect.");
        }
    }
    else
    {
        $result = "YOU SHOULDN'T BE HERE!";
    }
?>
<html>
    <!--------------------------------------------------------------->
    <head>
        <?php include 'bootstrap.php' ?>
    </head>
    <body>
        <?php include 'headerbar-unauth.php' ?>
        <div class="container mt-5 text-center">
            <h3>Sign in failed</h3>
            <p>
                <?php echo $result ?>
            </p>
        </div>
    </body>
</html>