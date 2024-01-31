<?php
declare(strict_types=1);
include("lib/init.php");

$users = null;
$cookie_name = "dtr";

// Extract POST
$email = $_POST['email'] ?? null; 
$passowrd = $_POST['password'] ?? null; 
$remember = $_POST['remember'] ?? false; 

$tmp->load("templates/login.html");
$tmp->set_value("head", $tmp->loads("templates/head.html"));
$tmp->set_value("title", "Sign In: Account Chooser");

if ($cookie->cookie_exists($cookie_name)) {
    $users = $cookie->get_cookie($cookie_name);
    $users = json_decode($crypto->decrypt($users), true);
}

if ($email != null && $passowrd != null) {
    if ($remember == true) {

        $account_credentials = [
            'email' => $_POST['email'],
            'remember' => $_POST['remember'],
            'timestamp' => date("Y-m-d H:i:s") 
        ];
        
        if($users != null){
            foreach($users as $k => $v) {
                if ($v['email'] == $account_credentials['email']){
                    $tmp->render();
                    return;
                }
            }
        }
    
        $users[] = $account_credentials;
        $cookie->set_cookie($cookie_name, $crypto->encrypt(json_encode($users)), -1, "/", $_SERVER['SERVER_ADDR'], true, false, "strict");
        header("Location: /account-chooser/");
    }
}

$tmp->render();

?>