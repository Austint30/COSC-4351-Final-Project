<?php $pageTitle="Admin"; $pageID="admin"; ?>
<?php include_once 'include/page-begin.php' ?>


<?php
    include_once 'include/auth.php';
    requireUserAdmin();

?>

<div class="container text-center page-body">
    <h1>Admin Control Page</h1>
    <?php renderMsgs(); ?>
    <div>
        <a href="/admin-locationadd.php" class="btn btn-primary">Add Location</a>
        <a href="/admin-locationedit.php" class="btn btn-primary">Edit Location</a>
        <a href="/admin-locationdelete.php" class="btn btn-primary">Delete Location</a>
    </div>

    <br><br>

    <div>
        <a href="/admin-add.php" class="btn btn-primary">Add Staff</a>
        <a href="/admin.php" class="btn btn-primary">Edit Staff</a>
        <a href="/admin.php" class="btn btn-primary">Delete Staff</a>  
    </div>

</div>

<?php include_once 'include/page-end.php' ?>























