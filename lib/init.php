<?php
header('Content-type:text/html;charset=utf8');
session_start();

define('ROOT',dirname(__DIR__));
require(ROOT.'/lib/Mysql.php');
require(ROOT.'/lib/func.php');
require(ROOT.'/lib/images.php');

// $_COOKIE = _addslashes($_COOKIE);
// $_GET = _addslashes($_GET);
// $_POST = _addslashes($_POST);
