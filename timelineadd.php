<?php 
require './lib/init.php';
if(!acc()){
	header('Location:login.php');
}
$db = new Mysql();

if(empty($_POST)){
	include_once (ROOT.'/view/public/headeradmin.html');
	include_once (ROOT.'/view/admin/addtimeline.html');
	include(ROOT.'/view/public/footer.html');
}else{

	$date['title'] = trim($_POST['title']);
	if(empty($date['title'])){
		error('标题不能为空');
	}
	
	$date['content'] = trim($_POST['content']);
	if(empty($date['content'])){
		error('内容不能为空');
	}
	
	$date['date'] = $_POST['date'];
	
	$res = $db->Exec($date, 'timeline');
	if(!$res){
		error('新建失败！');
	}else{
		succ('创建成功，爱你么么哒！');
	}
}