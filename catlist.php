<?php
require './lib/init.php';
if(!acc()){
	header('Location:login.php');
}
$db = new Mysql();

//查询所有数据
$sql = "select * from cat";
$names = $db->getAll($sql);

include_once (ROOT.'/view/public/headeradmin.html');
include_once(ROOT.'/view/admin/catlist.html');
include(ROOT.'/view/public/footer.html');