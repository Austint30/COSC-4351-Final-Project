<?php
include_once 'exceptions.php';


class LoginFlags {
    public bool $login_failed = false;
    public bool $form_invalid = false;
    public string $usernameMsg = "";
    public string $passwordMsg = "";
}

function login(LoginFlags &$flags){
    if ($_SERVER["REQUEST_METHOD"] != "POST"){
        throw InvalidMethodException("POST method is required");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userId = validateNotEmpty("username", $flags->$usernameMsg, "Username is required", $flags->$form_invalid);
        $password = validateNotEmpty("password", $flags->$passwordMsg, "Password is required", $flags->$form_invalid);

        if (!$flags->$form_invalid){
            $stmt = $conn->prepare("SELECT username, email, password, type, name
                                FROM restaurant.user 
                                WHERE (username = ? OR email = ?);");
        
            $stmt->bind_param("ss", $userId, $userId);

            $stmt->execute();

            $result = $stmt->get_result();

            while ($user = $result->fetch_object()){
                if (password_verify($password, $user->password)){
                    // Login successful! Add username to session.
                    storeSession($user->username, $user->name, $user->email);
                    if ($user->type === "ADMIN"){
                        header("Location: /admin.php?successmsg=You are now logged in as an admin.");
                    }
                    else
                    {
                        header("Location: /?successmsg=You are now logged in.");
                    }
                    exit;
                }
            }

            // No users found with that password.
            $flags->$login_failed = true;
        }

        
    }
}

?>