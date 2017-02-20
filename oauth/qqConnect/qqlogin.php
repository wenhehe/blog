<?php

require_once 'qqConnectAPI.php';

//访问qq登陆页面
$oauth = new Oauth();
$oauth->qq_login();