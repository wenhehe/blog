<?php
require_once 'config.php';
require_once 'saetv2.ex.class.php';

$code = $_GET['code'];


$keys['code'] = $code;
$keys['redirect_uri'] = CALLBACK ;

$oa = new SaeTOAuthV2(WB_KEY,WB_SEC);
$auth = $oa->getAccessToken($keys);

session_start();
$_SESSION['uid'] = $auth['uid'];

header('location:../../artlist.php');
exit;
?>