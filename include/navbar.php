
<?php include_once 'include/auth.php' ?>

<?php
function activeNavItem($_pageID, $className="active"){
    global $pageID;
    if (isset($pageID) && $_pageID == $pageID){
        echo $className;
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#"><?php echo $companyName ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php activeNavItem("index") ?>">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item <?php activeNavItem("reservations") ?>">
                    <a class="nav-link" href="/reservations.php">Reservations</a>
                </li>
                <?php
                    if (checkUserType(getCurrentUser($conn), "ADMIN")){
                        echo '<li class="nav-item ';
                        echo activeNavItem("admin");
                        echo '">
                            <a class="nav-link" href="/admin.php">Admin</a>
                        </li>';
                    }
                ?>
            </ul>
            <?php
            
                if(isset($_SESSION["username"]) && $_SESSION["username"]){
                    echo '<a href="/logout.php" class="btn btn-primary">Log Out</a>';
                }
                else
                {
                    echo '<a href="/login.php" class="btn btn-primary">Log In</a>';
                }
            ?>
        </div>
    </div>
</nav>