<?php
include('./lib/init.php');
if(!acc()){
	header('Location:login.php');
}
$db = new Mysql();

$sql = "select * from comment";
$comms = $db->getAll($sql);

include_once (ROOT.'/view/public/headeradmin.html');
require(ROOT.'/view/admin/commlist.html');
include(ROOT.'/view/public/footer.html');