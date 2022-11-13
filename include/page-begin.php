<?php
    include_once "global.php";
    include_once "messages.php";
    // Always include_once this php file on the top of every page

    // Start user session (stores temporary stuff server side like username after login)
    session_start([
        'cookie_lifetime' => 86400*30 // user will lose session after 1 month
    ]);
?>

<?php require 'connect.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>

    <!-- Bootstrap stylesheet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/restaurant.css" >

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        <?php
            if (isset($pageTitle)){
                echo $companyName." | ".$pageTitle;
            }
            else
            {
                echo $companyName;
            }
        ?>
    </title>
    <script src="js/debounce.js"></script>
    <script src="js/util.js"></script>
</head>
<body>
<?php include_once 'navbar.php' ?>