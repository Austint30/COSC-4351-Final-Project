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
            echo "<div>";
            echo json_encode($result->fetch_assoc());
            echo "</div>";
        }
        else
        {
            header("Location: /");
        }
        
    ?>
</div>

<?php include_once 'include/page-end.php' ?>