<?php $pageTitle="Reservations"; $pageID="reservations" ?>
<?php include_once 'include/page-begin.php' ?>

<div class="container page-body" style="max-width: 800px">
    <h5 class="border-bottom pb-3 lead text-center">RESERVATION PLACED</h5>
    <?php
        if (isset($_GET["res_id"])){
            $stmt = $conn->prepare("SELECT * FROM restaurant.reservation WHERE id=?");
            $res_id = intval($_GET["res_id"]);
            $stmt->bind_param("i", $res_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $res = $result->fetch_assoc();

            if (!$res){
                header("Location: /");
                exit;
            }

            $date = DateTime::createFromFormat("Y-m-d", $res["date"]);
            $time = DateTime::createFromFormat("H:i:s", $res["time"]);

            $date = $date->format("l, F j");
            $time = $time->format("g:i A");

            echo '<h4 class="load">Your reservation for '.$date.' at '.$time.' has been successfully placed.</h4>';
            echo '<p>See you there!</p>';
        }
        else
        {
            header("Location: /");
        }
        
    ?>
</div>

<?php include_once 'include/page-end.php' ?>