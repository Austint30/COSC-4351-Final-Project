<?php

function getUser($conn, $username){
    $stmt = $conn->prepare("SELECT * FROM restaurant.user WHERE user.username = ?;");

    $stmt->bind_param("s", $username);

    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_object();
}

/*
Usage:
    checkUserType($user, "ADMIN"); // Check if admin
    checkUserType($user, "STAFF"); // Check if staff
    checkUserType($user, "CUSTOMER"); // Check if customer

$user object should come from getUser()
*/
function checkUserType($user, $userType){
    if (!$user){
        return null;
    }
    return $user->type === $userType;
}

// Gets the current user from the session
function getCurrentUser($conn){
    if (isset($_SESSION["username"])){
        $user = getUser($conn, $_SESSION["username"]);
        return $user;
    }
    return null;
}

function requireUserAdmin($conn){
    $user = getCurrentUser($conn);
    if ($user && checkUserType($user, "ADMIN")){
        return;
    }
    header("Location: /");
    die;
}

function hashPassword($sourcePswd){
    return password_hash($sourcePswd, PASSWORD_DEFAULT);
}

?>