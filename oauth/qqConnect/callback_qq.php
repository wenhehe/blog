<?php

require_once 'qqConnectAPI.php';


// var_dump($_GET['code']);
// exit;

//请求accesstoken
$oauth = new Oauth;
$accesstoken = $oauth->qq_callback();

$openid = $oauth->get_openid();

// var_dump($accesstoken);
// var_dump($openid);


$_SESSION['openid'] = $openid;

header('location:../../artlist.php');
exit;


