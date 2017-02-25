<?php
include('./lib/init.php');
$db = new Mysql();

//查询所有栏目
$sql = "select cat_id,catname,num from cat";
$cat = $db->getAll($sql);


//判断是否有GET
if(isset($_GET['cat_id'])){
	$where = " and art.cat_id=$_GET[cat_id]";
} else {
	$where = "";
}

//判断栏目下是否有文章
if($db->getOne("select count(*) from art inner join cat on art.cat_id = cat.cat_id where 1 ".$where) ==0 ){
	header("Location:index.php");	
}


//分页代码

$sql = "select count(*) from art where 1 ".$where; ////获取总文章数
$num = $db->getOne($sql); //获取总文章数目
$curr = isset($_GET['page'])?$_GET['page']:1;  //当前页码数
$cnt = 5; //每页显示条数
$page = getPage($num, $curr, $cnt);
$max = ceil($num/$cnt);//总页数

//查询所有文章
$sql = "select art_id,title,pubtime,content,nick,thumb,comm,catname,num from art inner join cat on art.cat_id = cat.cat_id where 1 ".$where. ' order by art_id desc limit '.($curr-1)*$cnt.','.$cnt;

$art = $db->getAll($sql);

//查询近期文章
$sql = "select art_id,title from art order by pubtime desc limit 0,6";
$recart = $db->getAll($sql);


include(ROOT.'/view/public/header.html');
include(ROOT.'/view/front/index.html');
include_once(ROOT.'/view/public/frontright.html');
include_once(ROOT.'/view/public/footer.html');

?>