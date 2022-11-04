<?php
    include 'include/connect.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST["password"];
        $rPassword = $_POST["retype-password"];
        $name = $_POST["name"];
        $mailing = $_POST["mailing-address"];
        $billing = $_POST["billing-address"];
        $payment = $_POST["pref-payment"];
        
        $stmt = $conn->prepare("INSERT INTO restaurant.user (username, password, email, name, mail_addr, billing_addr, pref_pay_method)
            VALUES (?,?,?,?,?,?,?)");
        
        $stmt->bind_param("sssssss", $email, $password, $email, $name, $mailing, $billing, $payment);

        try {
            $stmt->execute();
        }
        catch(mysqli_sql_exception $e){
            header("Location: /signup.php?errormsg=User already exists");
            exit;
        }
        
        header("Location: /");
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