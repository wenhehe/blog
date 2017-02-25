<?php
include_once "./lib/init.php";

if(empty($_POST)){
	include(ROOT.'/view/public/header.html');
	include(ROOT.'/view/front/signup.html');
	include_once(ROOT.'/view/public/footer.html');
	exit;
}





?>