<?php 
require_once 'config.php';
require_once 'saetv2.ex.class.php';

$oa = new SaeTOAuthV2(WB_KEY,WB_SEC);

$oauth = $oa->getAuthorizeURL(CALLBACK);
header('Location:'.$oauth);


?>