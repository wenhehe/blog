<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once './lib/init.php';
if(!acc()){
	header('Location:login.php');
}
$db =new Mysql();

//查询所有栏目
$sql = "select * from cat";
$cat = $db->getAll($sql);

//判断文章是否存在！
$art_id = $_GET['art_id'];
if(($db->getOne("select count(*) from art where art_id =$art_id ")) ==0){
	error('文章不存在！');
}

//判断是否为POST提交
if(empty($_POST)){
	$sql = "select * from art where art_id = ".$art_id;
	$art = $db->getRow($sql);
	include_once (ROOT.'/view/public/headeradmin.html');
	include_once (ROOT.'/view/admin/artedit.html');
	include(ROOT.'/view/public/footer.html');
}else{
	//检测标题是否为空
	$art['title'] = trim($_POST['title']);
	if(empty($art['title'])){
		error('标题不能为空！');
	}

	//栏目
	$art['cat_id'] = $_POST['cat_id'];

	//检测内容是否为空
	$art['content'] = trim($_POST['content']);
	if(empty($art['content'])){
		error('内容不能为空！');
	}
	
	//插入tag
	//$art['arttag'] = $_POST['tag'];
	$art['arttag'] = trim($_POST['tag']);
	
	//图片
	//判断是否有图片上传，且上传error是否为0
	if(!($_FILES['pic']['name'] == '') && $_FILES['pic']['error'] ==0){
		$des = createDir().'/'.randStr().getExt($_FILES['pic']['name']);
		if(move_uploaded_file($_FILES['pic']['tmp_name'], ROOT . $des)){
			$art['pic'] = $des;
			//加上缩略图
			$art['thumb'] = makeThumb($des);
		}
	}

	//发布文章
	if(!$db->Exec($art, 'art','update',"art_id=".$art_id)){
		error('文章修改失败！');
	}else{
		//如果没有tag,则文章修改成功
		if(empty($art['arttag'])){
			succ('文章修改成功！');
		}else{
			//有tag,删除原来的
			if(($db->getOne("select count(*) from tag where art_id = $art_id"))>0){
				$sql = "delete from tag where art_id = $art_id";
				$db->query($sql);
			}
			
			//添加新标签
			//拆分tag字符串
			$tag = explode(',', $art['arttag']);
			
			//拼装sql
			$sql = "insert into tag (art_id,tag) values ";
			foreach ($tag as $v){
				$sql.= "(".$art_id.",'".$v."'),";
			}
			$sql = rtrim($sql,",");
			$res = $db->query($sql);
			if($res){
				succ('修改文章成功！');
			}else{
				error('修改文章失败！');
			}
		}
	}
}