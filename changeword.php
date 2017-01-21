<?php
require './lib/init.php';
if(!acc()){
	header('Location:login.php');
}else{
	if(empty($_POST)){
		include_once (ROOT.'/view/admin/changeword.html');
	}elseif(empty($_POST['password'])){
		error('原密码不能为空！');
	}elseif(empty($_POST['newpassword'])){
		error('新密码不能为空！');
	}elseif(empty($_POST['text_newpassword'])){
		error('二次确认密码不能为空！');
	}else{
		$db = new Mysql();
		$sql = "select count(*) from user where name = '".$_COOKIE['name']. "' and password = ".$_POST['password'];
		$res = $db->getOne($sql);
		if($res == 0){
			error('原密码输入错误！');
		}else{
			$pass['password'] = $_POST['newpassword'];
			$re = $db->Exec($pass,'user','update',"name = '".$_COOKIE['name']."'");
			if($re){
				succ('密码修改成功！');
			}
		}
	}
	
}