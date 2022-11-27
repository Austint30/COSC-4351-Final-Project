<?php $pageTitle="Admin"; $pageID="admin"; ?>
<?php include_once 'include/page-begin.php' ?>

<?php
    include_once 'include/auth.php';
    requireUserAdmin($conn);

?>

<div class="container text-center page-body">
    <h1>Admin Control Page</h1>
    <div>
        <a href="/admin-locationadd.php" class="btn btn-primary">Go to add location</a>
        <a href="/admin.php" class="btn btn-primary">Go to edit location</a>
        <a href="/admin.php" class="btn btn-primary">Go to delete location</a>
    </div>

    <br><br>

    <div>
        <a href="/admin.php" class="btn btn-primary">Go to add user</a>
        <a href="/admin.php" class="btn btn-primary">Go to edit user</a>
        <a href="/admin.php" class="btn btn-primary">Go to delete user</a>  
    </div>

</div>

<?php include_once 'include/page-end.php' ?>























