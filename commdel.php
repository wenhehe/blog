<?php
require('./lib/init.php');
if(!acc()){
	header('Location:login.php');
}
$db = new Mysql();
$comment_id = $_GET['comment_id'];
$art_id = $db->getOne("select art_id from comment where comment_id = ".$comment_id);

//判断id是否合法

if(empty($comment_id)){
	error('评论id为空！');
}

if(!is_numeric($comment_id)){
	error('评论不合法');
}


if(($db->getOne("select count(*) from comment where comment_id= ".$comment_id)) == 0){
	error('评论不存在！');
}

//删除评论
if(!$db->query("delete from comment where comment_id = ".$comment_id)){
	error('删除评论失败！');
}else{
	//文章评论数减1
	if($db->query("update art set comm = comm-1 where art_id = ".$art_id)){
		//succ("删除评论成功！");
		//跳转到上一页
		$ref = $_SERVER['HTTP_REFERER'];
		header("Location:$ref");
	}
}