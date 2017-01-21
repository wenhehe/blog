<?php
require './lib/init.php';
if(!acc()){
	header('Location:login.php');
}

$db = new Mysql();

$sql = 'select count(*) from art';
$num = $db->getOne($sql);
$cnt = 10;
$curr = isset($_GET['page'])?$_GET['page']:1;
$page = getPage($num, $curr, $cnt);



$sql = "select art_id,title,content,pubtime,comm,catname from art left join cat on art.cat_id = cat.cat_id order by art_id desc limit ".($curr-1)*$cnt.','.$cnt;
$art = $db->getAll($sql);

if(empty($_POST)){
	include_once (ROOT.'/view/public/headeradmin.html');
	include(ROOT.'/view/admin/artlist.html');
	include(ROOT.'/view/public/footer.html');
}