<?php
include("../lib/init.php");
$request = json_decode($_POST['data'], true) ?? null;

if ($cookie->cookie_exists("dtr")) {
    $data = $cookie->get_cookie("dtr");
    $data =  json_decode($crypto->decrypt($data), true);
    if (is_array($data)){
        foreach($data as $k => $v){
            if($v['uid'] == $request['user_id']){
                unset($data[$k]);
            }
        }
    }

    if(count($data) == 0){
        $cookie->clear($cookie_name);
    }
    else {
        $cookie->set_cookie($cookie_name, $crypto->encrypt(json_encode($data)), -1, "/", $_SERVER['SERVER_ADDR'], true, false, "strict");
        echo json_encode($request['user_id']);
    }
}
?>