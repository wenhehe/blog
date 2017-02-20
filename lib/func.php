<?php

/**
 * 
 * @param unknown $message  提示信息
 */
function succ($message){
	$res = 'succ';
	include_once (ROOT.'/view/public/headeradmin.html');
	include(ROOT.'/view/admin/info.html');
	include(ROOT.'/view/public/footer.html');
	exit;
}

function error($message){
	$res = 'error';
	include_once (ROOT.'/view/public/headeradmin.html');
	include(ROOT.'/view/admin/info.html');
	include(ROOT.'/view/public/footer.html');
	exit;
}

function alert($mes,$url){
	echo "<script>alert('{$mes}');</script>";
	echo "<script>window.location=('{$url}') ;</script>";
}

/**
 * 获取ip
 */
function getIP(){
	static $realip = NULL;
	if($realip !==NULL)
	{
		return $realip;
	}
	
	if(getenv('HTTP_X_FORWARDED_FOR')){
		$realip = getenv('HTTP_X_FORWARDED_FOR');
	}elseif(getenv('HTTP_CLIENT_IP')){
		$realip = getenv('HTTP_CLIENT_IP');
	}else{
		$realip = getenv('REMOTE_ADDR');
	}
	return $realip;
}

/**
 * 生成分页代码
 * @param int $num 总数
 * @param int $curr 当前页码数  $curr-2  $curr-1  $curr  $curr+1  $curr+1
 * @param int $cnt  每页显示的条数
*/
function getPage($num,$curr,$cnt){
	//最大页码数
	$max = ceil($num/$cnt);
	//最左侧页码
	$left = max(1,$curr-2);
	//最右侧页码
	$right = min($left+4,$max);
	//最左侧页码
	$left = max(1,$right-4);
	
	//将获取的5个页码数 放进数组里
	for($i=$left;$i<=$right;$i++){
		$_GET['page'] = $i;
		$page[$i] = http_build_query($_GET);
	}
	return $page;
}

//print_r(getPage(100, 5, 10));


/**
 * 生成随机字符串
 * @param  int $num  生成随机字符串的个数
 * @param str 生成的随机字符串
 */
function randStr($num = 6){
	$str = str_shuffle('abcdefghjkmnpqrstuvwxyzABCDEFGHGKLMNPQRSTUVWXYZ123456789');
	return $substr = substr($str,0,$num);
}

/**
 * 创建目录  ROOT.'uplode/2015/11/23/atgdsf.jpg
 * @param 
*/
function createDir(){
	$path = '/upload/'.date('Y/m/d');
	$fpath = ROOT.$path;
	if(is_dir($fpath) || mkdir($fpath,0777,true)){
		return $path;
	}else {
		return false;
	}
}

/**
 * 获取文件后缀
 * @param str $filename 文件名
 * @return str 文件的后缀名，且带点
 */
function getExt($filename){
	return strrchr($filename, '.');
}


/**
 * 等比例生成缩略图  比例不合适两边留白
 * @param str $ori 图片原始路径 eg./uplode/2015/08/11/asdfge.jpg
 * @param int $sw 缩略图的宽
 * @param int $sh 缩略图的高
 * @return $path 缩略图的路径
 */
// function makeThumb($ori,$sw = 200,$sh = 200){
// 	$path = dirname($ori).'/'.randStr().'.jpg';
	
// 	$opic = ROOT.$ori;//大图的绝对路径
// 	$opath = ROOT.$path;//小图的绝对路径
// 	//原始大图片
// 	if(!list($bw,$bh,$btype) = getimagesize($opic)){
// 		return false;
// 	}
// 	$map = array(
// 			1=>'imagecreatefromgif',
// 			2=>'imagecreatefromjpeg',
// 			3=>'imagecreatefrompng',
// 			6=>'imagecreatefromwbmp',
// 			15=>'imagecreatefromwbmp'
// 	);
// 	//如果图片传来的类型不在map里，无法处理，则return false
// 	if(!isset($map[$btype])){
// 		return false;
// 	}
// 	//原始大图
// 	$func = $map[$btype];
// 	$big = $func($opic);
// 	//创建小画布
// 	$small = imagecreatetruecolor($sw, $sh);
// 	$white = imagecolorallocate($small, 255, 255, 255);
// 	imagefill($small, 0, 0, $white);
	
// 	//计算缩略比
// 	$rate = min($sw/$bw,$sh/$bh);
	
// 	//真正粘到小图的宽高
// 	$rw = $bw * $rate;
// 	$rh = $bh * $rate;
// 	imagecopyresampled($small, $big, ($sw-$rw)/2, ($sh-$rh)/2, 0, 0, $rw, $rh, $bw, $bh);
// 	//保存缩略图
// 	imagepng($small,$opath);
	
// 	//销毁画布
// 	imagedestroy($big);
// 	imagedestroy($small);
// 	return $path;
	
// }

function makeThumb($ori , $sw=200 , $sh=200) {
	$path = dirname($ori) . '/' . randStr() . '.png';
	$opic = ROOT . $ori; //大图的绝对路径
	$opath = ROOT . $path;//小图的绝对路径
	//原始大图片
	if(!list($bw,$bh,$type) = getimagesize($opic)) {
		return false;
	}

	 $map = array(
	 1=>'imagecreatefromgif',
	 2=>'imagecreatefromjpeg',
	 3=>'imagecreatefrompng',
	 6=>'imagecreatefromwbmp',
	 15=>'imagecreatefromwbmp'
	 );
	//如果传来的图片类型不再map里 无法处理 则return false
	if( !isset($map[$type]) ) {
	return false;
	}
	//原始大图
	$func = $map[$type];
	$big = $func($opic);
	//创建小画布
	$small = imagecreatetruecolor($sw, $sh);
	$white = imagecolorallocate($small, 255, 255, 255);
	imagefill($small, 0, 0, $white);
	//计算缩略比
	$rate = min( $sw/$bw , $sh/$bh );
	/*imagecopyresampled ( $small , $big , int $dst_x , int $dst_y , 0 , 0 , int $dst_w , int $dst_h , $bw , $bh )*/
	//真正粘到小图上的宽高
	$rw = $bw*$rate;
	$rh = $bh*$rate;
	imagecopyresampled ( $small , $big , ($sw-$rw)/2 , ($sh-$rh)/2 , 0 , 0 , $rw , $rh , $bw , $bh );
	//保存缩略图
	imagepng($small , $opath);
	//销毁画布
	imagedestroy($big);
	imagedestroy($small);
	return $path;
}

/**
 * 检测是否登陆
 * 
 */
function acc(){
	return (isset($_COOKIE['user_id']) || isset($_SESSION['user_id']));
}


/*
 * 使用反斜线转义字符串
 * @param arr 待转义的数组
 * @return arr 被转义后的数组
 */
function _addslashes($arr) {
	foreach ($arr as $k=>$v) {
		if(is_string($v)) {
			$arr[$k] = addslashes($v);
		} else if(is_array($v)) {
			$arr[$k] = _addslashes($v);
		}
	}
	return $arr;
}

/*
 * 获取gravatar头像
*/
function getGravatar($email){
	return $img = "https://secure.gravatar.com/avatar/".md5($email)."?s=50&d=identicon&r=pg";
}

/*
*调试输出函数
*$val 调试输出源数据
*,$dump 是否开启var_dump调试
*$exit 是否在结束后设置断点
*/

function debug($val,$dump=false,$exit=true){
	if($dump){ 
		$func='var_dump';
	}else{
		$func=(is_array($val)||is_object($val))?'print_r':'printf';
	}
	//输出到html
	header("Content-type:text/html;charset=utf-8");
	echo '<pre>debug output:<hr/>';
	$func($val);
	echo '</pre>';
	if($exit) exit;
}