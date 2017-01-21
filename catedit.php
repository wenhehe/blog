<?php
require_once('./lib/init.php');
if(!acc()){
	header('Location:login.php');
}

$db = new Mysql();
$cat_id = $_GET['cat_id'];

if(empty($_POST)){
	//判断id是否合法
	if(!is_numeric($cat_id)){
		//echo '栏目不合法';
		error('栏目不合法！');
		exit;
	}
	$sql = "select catname from cat where cat_id = $cat_id";
	$rs = $db->getOne($sql);
	include_once (ROOT.'/view/public/headeradmin.html');
	require_once (ROOT.'/view/admin/catedit.html');
	include(ROOT.'/view/public/footer.html');
}else{
	$catname = trim($_POST['catname']);
	//判断栏目是否为空
	if($catname == ''){
		//echo '栏目不能为空！';
		error('栏目不能为空');
		exit;
	}
	
	//判断栏目是否存在
	$sql = "select count(*) from cat where catname='$catname'";
	if($db->getOne($sql) != 0){
		//echo '栏目已经存在，不能修改为同名！';
		error('栏目已经存在，不能修改为同名！');
		exit;
	}
	
	//修改栏目名称！
	if($db->Exec(['catname'=>"$catname"],'cat','update',"cat_id = $cat_id")){
		//echo '修改栏目成功！';
		succ('修改栏目成功！');
	}else{
		//echo '修改栏目失败！';
		error('栏目修改失败！');
	}
}


