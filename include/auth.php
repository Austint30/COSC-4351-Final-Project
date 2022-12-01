<?php
include_once __DIR__.'/connect.php';

function getUser($username){
    global $conn;
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
function getCurrentUser(){

    if (isset($_SESSION["username"])){
        $user = getUser($_SESSION["username"]);
        return $user;
    }
    return null;
}

function requireUserAdmin(){
    $user = getCurrentUser();
    if ($user && checkUserType($user, "ADMIN")){
        return;
    }
    header("Location: /");
    die;
}

function requireUserStaffOrAdmin(){
    $user = getCurrentUser();
    if ($user && (checkUserType($user, "STAFF") || checkUserType($user, "ADMIN"))){
        return;
    }
    header("Location: /");
    die;
}

function hashPassword($sourcePswd){
    return password_hash($sourcePswd, PASSWORD_DEFAULT);
}

function startSession(){
    session_start([
        'cookie_lifetime' => 86400*30 // user will lose session after 1 month
    ]);
}

function storeSession($username, $name, $email, $restId){
    $_SESSION["username"] = $username;
    $_SESSION["name"] = $name;
    $_SESSION["email"] = $email;
    if ($restId){
        $_SESSION["restId"] = $restId;
    }
}

?>