<?php
require_once('./lib/init.php');

		
if(!acc()){
	header('Location:login.php');
}

//连接数据库
$db = new Mysql();

if(empty($_POST)){
	include_once (ROOT.'/view/public/headeradmin.html');
	require_once(ROOT.'/view/admin/catadd.html');
}else{
	$cat['catname'] = trim($_POST['catname']);
	//判断栏目是否为空
	if($cat['catname'] == ''){
		//echo '栏目为空！';
		error('栏目为空！');
		exit;
	}
	
	//判断栏目是否存在
	$sql = "select count(*) from cat where catname='$cat[catname]'";
	if($db->getOne($sql) != 0){
		//echo '栏目已经存在！';
		error('栏目已经存在！');
		exit;
	}else{
		$res = $db->Exec($cat, 'cat');
		if(!$res){
			//echo '新建栏目失败！';
			error('新建栏目失败！');
		}else{
			//echo '新建栏目成功！';
			succ('新建栏目成功！');
		}
		}
}

