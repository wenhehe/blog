<?php 
require_once './lib/init.php';

if(!acc()){
	header('Location:login.php');
}

$db = new Mysql;


$sql = "select * from timeline order by date asc";
$line = $db->getAll($sql);

include_once (ROOT.'/view/public/headeradmin.html');
include_once (ROOT.'/view/admin/timelinelist.html');
include_once (ROOT.'/view/public/footer.html');
