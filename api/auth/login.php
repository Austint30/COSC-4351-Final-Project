<?php
    include_once '../../include/login-handler.php';
    include_once '../../include/auth.php';

    $flags = new LoginFlags();

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        startSession();
        login($flags);

        if (!$flags->login_failed && !$flags->form_invalid){
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode(array(
                "ok" => true,
                "message" => "Login successful"
            ));
            exit;
        }
    }

    if ($flags->login_failed){
        http_response_code(403);
    }

    if ($flags->form_invalid){
        http_response_code(400);
    }
    
    include '../../components/login.php';
?>