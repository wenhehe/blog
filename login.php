<?php
error_reporting(E_ALL ^ E_NOTICE);
require './lib/init.php';

if(acc()){
	header('Location:artlist.php');
}

$db = new Mysql;



if(empty($_POST)){
	require_once (ROOT.'/view/front/login.html');
}else{

	$autoFlag = $_POST['autoFlag'];

	$user['name'] = trim($_POST['name']);
	if(empty($user['name'])){
		alert('用户名不能为空！','login.php');
	}

	session_start();
	
	$user['password'] = trim(md5($_POST['password']));
	if(empty($_POST['verify'])){
		alert('验证码不能为空！','login.php');
	}
	if(!($_SESSION['verify'] == $_POST['verify'])){
		alert('验证码输入错误！','login.php');
	}
	


	$sql = "select * from user where name = '$user[name]' and password = '$user[password]'";

	$res = $db->getRow($sql);
	if($res ==0 ){
		error('用户名或者密码错误！');
	}else{
		
		if($autoFlag){
			setcookie('user_id',$res['user_id'],time()+7*24*3600);
			setcookie('name' , $res['name'],time()+7*24*3600);
		}
		
		$_SESSION['user_id'] = $res['user_id'];
		$_SESSION['name'] = $res['name'];

		header('location:artlist.php');
	}
}

