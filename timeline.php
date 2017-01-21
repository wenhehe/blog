<?php 
require_once './lib/init.php';

$db = new Mysql();

$sql = "select * from timeline order by date asc";
$line = $db->getAll($sql);

include_once (ROOT.'/view/public/header.html');
include_once (ROOT.'/view/front/timeline.html');
include(ROOT.'/view/public/footer.html');