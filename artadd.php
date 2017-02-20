<?php
require_once './lib/init.php';

if(!acc()){
	header('Location:login.php');
}
$db =new Mysql();

$sql = "select * from cat";
$cat = $db->getAll($sql);

if(empty($_POST)){
	include_once (ROOT.'/view/public/headeradmin.html');
	include_once (ROOT.'/view/admin/artadd.html');
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
	
	//print_r($_FILES);exit;
	//判断是否有图片上传，且上传error是否为0
	if(!($_FILES['pic']['name'] == '') && $_FILES['pic']['error'] ==0){
		$des = createDir().'/'.randStr().getExt($_FILES['pic']['name']);
		if(move_uploaded_file($_FILES['pic']['tmp_name'], ROOT . $des)){
			$art['pic'] = $des;
			//加上缩略图
			$art['thumb'] = makeThumb($des);
		}
	}
	
	//插入tag
	$art['arttag'] = trim($_POST['tag']);
	
	//插入时间
	$art['pubtime'] = time();
	
	//插入作者
	$sql = "select nick from user where name = "."'".$_SESSION['name']."'";
	$nick = $db->getOne($sql);
	$art['nick'] = $nick; 
	
	//发布文章
	if($db->Exec($art, 'art')){
		//判断是否存在tag
		$tag = trim($_POST['tag']);
		if($tag == ""){
			//将cat的num字段  当前栏目下的文章数加1
			$db->query("update cat set num = num+1 where cat_id =".$art['cat_id']);
			succ('新建文章成功！');
		}else{
			//获取上一个id
			$art_id = $db->lastId();
			
			//拆分tag字符串
			$tag = explode(',', $tag);
			
			//拼装sql
			$sql = "insert into tag (art_id,tag) values ";
			foreach ($tag as $v){
				$sql.= "(".$art_id.",'".$v."'),";
			}
			$sql = rtrim($sql,",");
			$res = $db->query($sql);
			if($res){
				//将cat的num字段  当前栏目下的文章数加1
				$db->query("update cat set num = num+1 where cat_id =".$art['cat_id']);
				succ('新建文章成功！');
			}else{
				$sql = "delete from art where art_id = $art_id";
				$res = $db->query($sql);
				if($res){
					//将cat的num字段  当前栏目下的文章数减1
					$db->query("update cat set num = num-1 where cat_id =".$art['cat_id']);
					error('文章新建失败！');
				}
			}	
		}
	}else{
		error('新建文章失败！');
	}
	
}