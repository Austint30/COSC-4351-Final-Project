
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
                    if (checkUserType(getCurrentUser(), "ADMIN")){
                        echo '<li class="nav-item ';
                        echo activeNavItem("admin");
                        echo '">
                            <a class="nav-link" href="/admin.php">Admin</a>
                        </li>';
                    }
                ?>
                <?php
                    if (checkUserType(getCurrentUser(), "STAFF") || checkUserType(getCurrentUser(), "ADMIN")){
                        echo '<li class="nav-item ';
                        echo activeNavItem("management");
                        echo '">
                            <a class="nav-link" href="/management.php">Management</a>
                        </li>';
                    }
                ?>
            </ul>
            <?php

                $user = getCurrentUser();

                if ($user && $user->type === "CUSTOMER"){
                    $points = $user->points;
                    echo '<div class="mr-3 text-white">'.$points.' Points</div>';
                }
            
                if(isset($_SESSION["username"]) && $_SESSION["username"]){
                    echo '<div class="dropdown">';
                    echo    '<button class="btn btn-primary dropdown-toggle" type="button" id="user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    echo        "Hello ".$_SESSION["name"];
                    echo    '</button>';
                    echo    '<div class="dropdown-menu" aria-labelledby="user-dropdown">';
                    echo        '<a class="dropdown-item" href="/logout.php">Log Out</a>';
                    echo    '</div>';
                    echo '</div>';
                }
                else
                {
                    echo '<a href="/login.php" class="btn btn-primary mr-2">Log In</a>';
                    echo '<a href="/signup.php" class="btn btn-primary">Sign Up</a>';
                }
            ?>
        </div>
    </div>
</nav>