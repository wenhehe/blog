<?php

function buildRandomString(	$type = 1 , $length = 4 ){
	
	if($type == 1 ){
		$chars = join("",range(0,9));

	}elseif($type ==2){
		$chars = join("", array_merge(range("a", "z"),range("A", "Z")));

	}elseif($type ==3){
		$chars = join("", array_merge(range("a", "z"),range("A", "Z"),range(0, 9)));

	}
	echo $length;
	if($length > strlen($chars)){
		exit('字符串长度不够');
	}
	$chars = str_shuffle($chars);
	return substr($chars, 0,$length);
}


function verifyImage($sess_name = 'verify',	$type = 1, $length = 4,	$pixel = 0,$line = 0){

	session_start();

	$width = 120;
	$height = 40;
	$image = imagecreatetruecolor($width, $height);
	
	$white = imagecolorallocate($image, 255, 255, 255);
	$black = imagecolorallocate($image, 0, 0, 0);
	
	imagefilledrectangle($image, 1, 1, $width-2, $height-2, $white);
	
	$chars = buildRandomString($type,$length);
	
	$_SESSION[$sess_name] = $chars;

	$fontfiles = array("LucidaSansDemiBold.ttf","LucidaSansRegular.ttf","LucidaTypewriterBold.ttf","LucidaTypewriterRegular.ttf","SIMYOU.TTF");
	
	//写字
	for($i = 0 ; $i<$length ; $i++){
		$size = mt_rand(15,20);
		$angle = mt_rand(-15,15);
		$x = 5 + $i*$size;
		$y = mt_rand(23,33);
		$color = imagecolorallocate($image, mt_rand(59,90),mt_rand(80,200),mt_rand(90,180));
		$fontfile = ROOT.'/fonts/'.$fontfiles[mt_rand(0,count($fontfiles)-1)];
		$text = substr($chars, $i,1);
		imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $text);
	}

	//干扰点
	if($pixel){
		for ($i = 0 ; $i<$pixel ; $i++){
			imagesetpixel($image, mt_rand(0,$width-1),mt_rand(0,$height-1) ,$black);
		}
	}
	
	//干扰线
	if($line){
		for ($i =1 ;$i<$line; $i++){
			imageline($image, mt_rand(0,$width-1),mt_rand(0,$height-1),mt_rand(0,$width-1),mt_rand(0,$height-1), $color = imagecolorallocate($image, mt_rand(59,90),mt_rand(80,200),mt_rand(90,180)));
		}
	}
	// var_dump($_SESSION);
	// exit;
	//输出图片
	ob_clean();
	header("content-type:image/gif");
	imagegif($image);
	imagedestroy($image);
}

?>
