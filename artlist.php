<?php
require './lib/init.php';

$db = new Mysql();


//首次第三方登陆后绑定原有账户
if(!empty($_POST)){

	$user['name'] = trim($_POST['name']);
	if(empty($user['name'])){
		alert('用户名不能为空！','login.php');
	}
	
	$user['password'] = trim(md5($_POST['password']));

	$sql = "select * from user where name = '$user[name]' and password = '$user[password]'";

	$res = $db->getRow($sql);
	if($res ==0 ){
		error('用户名或者密码错误,请重新登陆！');
	}else{

		if(isset($_SESSION['openid'])){
			$sql = "update user set qq_openid = '".$_SESSION['openid']."' where name = '".$user['name']."'";
			if($db->query($sql)) ;
			unset($_SESSION['openid']);	
		}

		if(isset($_SESSION['uid'])){
			$sql = "update user set uid = '".$_SESSION['uid']."' where name = '".$user['name']."'";
			if($db->query($sql)) ;
			unset($_SESSION['uid']);	
		}


		$_SESSION['user_id'] = $res['user_id'];
		$_SESSION['name'] = $res['name'];
		header('Location:artlist.php');
	}
}


//存在cookie或session
if(acc()){
	$sql = 'select count(*) from art';
	$num = $db->getOne($sql);
	$cnt = 10;
	$curr = isset($_GET['page'])?$_GET['page']:1;
	$page = getPage($num, $curr, $cnt);



	$sql = "select art_id,title,content,pubtime,comm,catname from art left join cat on art.cat_id = cat.cat_id order by art_id desc limit ".($curr-1)*$cnt.','.$cnt;
	$art = $db->getAll($sql);

		include_once (ROOT.'/view/public/headeradmin.html');
		include(ROOT.'/view/admin/artlist.html');
		include(ROOT.'/view/public/footer.html');
}else{
	//判断是否为第三方登陆
	if(empty($_SESSION['openid']) && empty($_SESSION['uid'])){
		header('Location:login.php');
		exit;
	}

	//判断qq登陆还是微博登陆
	if(isset($_SESSION['openid'])){

		$sql = "select count(*) from user where qq_openid = '".$_SESSION['openid']."'";

		//判断是否首次使用qq账户登陆
		if($db->getOne($sql) == 0 ){
			$bond =1;
			require_once (ROOT.'/view/front/login.html');
		}else{
			$sql = "select * from user where qq_openid = '".$_SESSION['openid']."'";
			$res = $db->getRow($sql);
			$_SESSION['user_id'] = $res['user_id'];
			$_SESSION['name'] = $res['name'];
			header('Location:artlist.php');
		}

	}elseif (isset($_SESSION['uid'])) {

		$sql = "select count(*) from user where uid = '".$_SESSION['uid']."'";

		//判断是否首次使用微博账户登陆
		if($db->getOne($sql) == 0 ){
			$bond =1;
			require_once (ROOT.'/view/front/login.html');
		}else{
			$sql = "select * from user where uid = '".$_SESSION['uid']."'";
			$res = $db->getRow($sql);
			$_SESSION['user_id'] = $res['user_id'];
			$_SESSION['name'] = $res['name'];
			header('Location:artlist.php');
		}
	}



}


