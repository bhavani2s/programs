<?php
session_start();

function generate_captcha() {
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $captcha_string = '';
    for ($i = 0; $i < 6; $i++) {
        $captcha_string .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    $answer = strtolower($captcha_string);
    
    return array("question" => $captcha_string, "answer" => $answer);
}

$captcha_data = generate_captcha();
$_SESSION["captcha_answer"] = $captcha_data["answer"];
echo json_encode(array("question" => $captcha_data["question"]));
?>
