<?php
require_once './lib/init.php';
if(!acc()){
	header('Location:login.php');
}
$db =new Mysql();

//删除文章
$sql = "update cat set num = num-1 where cat_id = (select cat_id from art where art_id = ".$_GET['art_id'].")";
$db->query($sql);
$sql = "delete from art where art_id = ".$_GET['art_id'];
if(!$db->query($sql)){
	error('文章删除失败！');
}else{
	header('Location:artlist.php');
}
