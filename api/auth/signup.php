<?php
    include_once '../../include/signup-handler.php';
    include_once '../../include/auth.php';

    $flags = new SignUpFlags();

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        startSession();
        signup($flags);

        if (!$flags->signup_failed_msg && !$flags->form_invalid){
            header("Content-Type: application/json; charset=utf-8");
            echo json_encode(array(
                "ok" => true,
                "message" => "Sign Up successful"
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
    
    include '../../components/signup.php';
?>