<?php
include("lib/init.php");

$tmp->load("templates/index.html");
$tmp->set_value("head", $tmp->loads("templates/head.html"));
$tmp->set_value("title", "Account Chooser");
$tmp->set_value("scripts", '<script src="js/main.js" type="text/javascript"></script>');

if (!$cookie->cookie_exists("dtr")) {
    $html = "<div>";
    $html .= 'There are no accounts saved.<br />Please do a <a href="login"><strong>Sign In</strong></a>, and make sure you check <strong>Remember me</strong>.';
    $html .= "</div>";
    $tmp->set_value("list_of_accounts", $html);
}
else {
    $data = $cookie->get_cookie("dtr");
    $data =  json_decode($crypto->decrypt($data), true);
    
    $html = '<ul class="accounts-list">';
    if (is_array($data)){
        foreach($data as $k => $v) {
            $html .= '<li data-id="'.$v['uid'].'" class="account-item"">
            <a class="" href="#">
            <div class="account">
            <span>'.$v['email'].'</span><i title="Remove account" class="remove-btn float-right"></i></div>
            </a>
        </li>';
        }
    }
    $html .= '<li>
        <a href="login">
        <div class="account">
            Use another account
        </div>
        </a>
    </li>';
    $html .= "</ul>";
    $tmp->set_value("list_of_accounts", $html);
}

$tmp->render();

?>