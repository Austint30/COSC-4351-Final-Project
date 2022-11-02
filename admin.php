<?php $pageTitle="Admin"; $pageID="admin"; ?>
<?php include 'include/page-begin.php' ?>

<div class="container page-body">
    <h1 class="mt-3">Hello! This is the admin page.</h1>
    <h5>Restaurants</h5>
    <table class="table">
        <thead><tr>
            <th>Street Address</th>
            <th>City</th>
            <th>State</th>
        </tr></thead>
    <tbody>
        <?php
            $query = $conn->query('SELECT * FROM restaurant.restaurant;');

            while ($row = $query->fetch_assoc()){
                echo '<tr>';
                echo '<td>'.$row['street_address'].'</td>';
                echo '<td>'.$row['city'].'</td>';
                echo '<td>'.$row['state'].'</td>';
                echo '</tr>';
            }
        ?>
        </tbody>
    </table>
</div>

<?php include 'include/page-end.php' ?>