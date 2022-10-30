<?php
    // Always include this php file on the top of every page


?>

<?php require 'connect.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>
        <?php
            if (isset($pageTitle)){
                echo "Restaurant | " + $pageTitle;
            }
            else
            {
                echo "Restaurant";
            }
        ?>
    </title>
</head>