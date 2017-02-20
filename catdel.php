<?php
require_once ('./lib/init.php');
session_start();
if(!acc()){
	header('Location:login.php');
}
$db = new Mysql();

$cat_id = $_GET['cat_id'];
//判断id是否合法
if(!is_numeric($cat_id)){
	//echo '栏目不合法';
	error('栏目不合法！');
	exit;
}


//查询栏目是否存在
if($db->getOne("select count(*) from cat where cat_id = $cat_id") == 0){
	//echo '栏目不存在！';
	error('栏目不存在！');
	exit;
}

//查询栏目下是否有文章，有文章则不能删除！
$sql = "select count(*) from art where cat_id=$cat_id";
if($db->getOne($sql) != 0){
	//echo '栏目下有文章，不能删除！';
	error('栏目下有文章,不能删除！');
	exit;
}

//删除文章
if($db->query("delete from cat where cat_id = $cat_id")){
	//echo '删除成功！';
	//将cat的num字段  当前栏目下的文章数减1
	$db->query("update cat set num = num-1 where cat_id =".$art['cat_id']);
	succ('删除成功！');
}else{
	//echo '删除失败！';
	error('删除失败！');
}