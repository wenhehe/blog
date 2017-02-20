<?php
//error_reporting(E_ALL ^ E_NOTICE);
error_reporting(0);
require('./lib/init.php');

$db = new Mysql();
$art_id = $_GET['art_id'];

//查询所有栏目
$sql = "select cat_id,catname,num from cat";
$cat = $db->getAll($sql);

//判断art_id是否合法
if(!is_numeric($art_id)){
	header('Location:index.php');
}

//判断文章是否存在
if(($db->getOne("select count(*) from art where art_id = $art_id")) ==0){
	header('Location:index.php');
}

//查询栏目数据
$sql = "select catname,title,content,pic,pubtime,comm,nick from art inner join cat on cat.cat_id = art.cat_id where art_id = $art_id";
$art = $db->getRow($sql);

//判断是否有评论提交
if(!empty($_POST)){
	$comm['art_id']=trim($_GET['art_id']);
	$comm['nick'] = trim($_SESSION['name']);
	$comm['content'] = trim($_POST['content']);
	$comm['pubtime'] = time();

	//获取来访者ip
	$comm['ip'] = sprintf('%u',ip2long(getIP()));

	$res = $db->Exec($comm, 'comment');

	if($res){
		//评论数加1
		$db->query("update art set comm = comm+1 where art_id = ".$comm['art_id']);
		
		//跳转到上一页
		$ref = $_SERVER['HTTP_REFERER'];
		header("Location:$ref");
	}
}

//取出所有评论
$comm = $db->getAll("select * from comment where art_id = $art_id");

//查询近期文章
$sql = "select art_id,title from art order by art_id desc limit 0,6";
$recart = $db->getAll($sql);


include(ROOT.'/view/public/header.html');
require(ROOT.'/view/front/art.html');
include_once(ROOT.'/view/public/frontright.html');
include(ROOT.'/view/public/footer.html');