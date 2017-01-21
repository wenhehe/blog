<?php 
include './lib/init.php';
if(!acc()){
	header('Location:login.php');
}

$db = new Mysql();
$id = $_GET['id'];

if(!is_numeric($id)){
	error('ID不合法！');
}

if(($db->getOne("select count(*) from timeline where id =$id ")) ==0){
	error('时间轴不存在！');
}

	
if(empty($_POST)){	

	$sql = "select * from timeline where id = $id";
	$line = $db->getRow($sql);
	include_once (ROOT.'/view/public/headeradmin.html');
	include_once (ROOT.'/view/admin/timelineedit.html');
}else{
	$line['title'] = $date['title'] = trim($_POST['title']);
	if(empty($date['title'])){
		error('标题不能为空');
	}
	
	$date['content'] = trim($_POST['content']);
	if(empty($date['content'])){
		error('内容不能为空');
	}
	
	$date['date'] = $_POST['date'];
	
	$res = $db->Exec($date, 'timeline','update',"id =$id");
	if(!$res){
		error('修改失败！');
	}else{
		succ('修改成功，爱你么么哒！');
	}
}