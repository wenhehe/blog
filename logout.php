<?php

session_start();

if(isset($_COOKIE['name'])){
	setcookie('name','',time()-1);
}
if(isset($_COOKIE['user_id'])){
	setcookie('user_id','',time()-1);
}
$_SESSION = array();

session_destroy();

header('Location:login.php');
