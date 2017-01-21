<?php 
include './lib/init.php';
$db = new Mysql();
$id = $_GET['id'];

if(!is_numeric($id)){
	error('ID不合法！');
}

if(($db->getOne("select count(*) from timeline where id =$id ")) ==0){
	error('时间轴不存在！');
}

$sql = "delete from timeline where id = $id";
if($db->query($sql)){
	succ('删除成功！');
}else{
	error("删除失败了呢！");
}