<?php $pageTitle="Management"; $pageID="management"; ?>
<?php include_once 'include/page-begin.php' ?>


<?php
    include_once 'include/auth.php';
    requireUserStaffOrAdmin($conn);

?>

<div class="container text-center page-body">
    <h1>Management Page</h1>
    <?php renderMsgs(); ?>

    <!-- Page content goes here! -->
    <?php
    
        if (isset($_SESSION["restId"])){
            $restaurantId = $_SESSION["restId"];
            echo "Your restaurant ID is ".$restaurantId;
        }

    ?>
</div>

<?php include_once 'include/page-end.php' ?>























