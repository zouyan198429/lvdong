<?php
/**
 * KindEditor PHP
 *
 * 本PHP程序是演示程序，建议不要直接在实际项目中使用。
 * 如果您确定直接使用本程序，使用之前请仔细确认相关安全设置。
 *
 */

require_once 'JSON.php';

/**
 * 循环创建目录
 *
 * @param string $dir 待创建的目录
 * @param  $mode 权限
 * @return boolean
 */
function makeDir($dir, $mode = '0777') {
	if (is_dir($dir) || @mkdir($dir, $mode))
		return true;
	if (!makeDir(dirname($dir), $mode))
		return false;
	return @mkdir($dir, $mode);
}

//判断数据不是JSON格式:
function isNotJson($str){
	return is_null(json_decode($str));
}
// 判断是否有权限

session_start(); // 初始化session
// $userInfo = $_SESSION['userInfo']?? [];
$redisKey = $_SESSION['loginKey'] ?? '';
$redis = new Redis();
//$redis->connect('127.0.0.1', 6379);
$redis->connect('localhost', 6379);
$redis->auth('ABCabc123456!@#');

$userInfo =  $redis->get($redisKey);

if (!isNotJson($userInfo)) {
	$userInfo = json_decode($userInfo, true);
}

// $userInfo = \App\Services\Tool::getSession(null, true, 'loginKey', 1);
if(empty($userInfo)) {
	//throws('非法请求！');
	alert('非法请求！');
//            if(isAjax()){
//                ajaxDataArr(0, null, '非法请求！');
//            }else{
//                redirect('login');
//            }
}
$company_id = $userInfo['company_id'] ?? 0;


// $php_path = dirname(__FILE__) . '/';
// $php_url = dirname($_SERVER['PHP_SELF']) . '/';

//文件保存目录路径
$save_path = '/data/kezhuisu.net/resource/';//$php_path . '../attached/';
//文件保存目录URL
$save_url = '/resource/';//$php_url . '../attached/';

$root_dir = 'kindeditor';
$save_path .= $root_dir . "/";
$save_url .= $root_dir . "/";
if (!file_exists($save_path)) {
	mkdir($save_path);
}

//定义允许上传的文件扩展名
$ext_arr = array(
	'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
	'flash' => array('swf', 'flv'),
	'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
	'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
);
//最大文件大小
$max_size = 1000000;

$save_path = realpath($save_path) . '/';

//PHP上传失败
if (!empty($_FILES['imgFile']['error'])) {
	switch($_FILES['imgFile']['error']){
		case '1':
			$error = '超过php.ini允许的大小。';
			break;
		case '2':
			$error = '超过表单允许的大小。';
			break;
		case '3':
			$error = '图片只有部分被上传。';
			break;
		case '4':
			$error = '请选择图片。';
			break;
		case '6':
			$error = '找不到临时目录。';
			break;
		case '7':
			$error = '写文件到硬盘出错。';
			break;
		case '8':
			$error = 'File upload stopped by extension。';
			break;
		case '999':
		default:
			$error = '未知错误。';
	}
	alert($error);
}

//有上传文件时
if (empty($_FILES) === false) {
	//原文件名
	$file_name = $_FILES['imgFile']['name'];
	//服务器上临时文件名
	$tmp_name = $_FILES['imgFile']['tmp_name'];
	//文件大小
	$file_size = $_FILES['imgFile']['size'];
	//检查文件名
	if (!$file_name) {
		alert("请选择文件。");
	}
	//检查目录
	if (@is_dir($save_path) === false) {
		alert("上传目录不存在。");
	}
	//检查目录写权限
	if (@is_writable($save_path) === false) {
		alert("上传目录没有写权限。");
	}
	//检查是否已上传
	if (@is_uploaded_file($tmp_name) === false) {
		alert("上传失败。");
	}
	//检查文件大小
	if ($file_size > $max_size) {
		alert("上传文件大小超过限制。");
	}
	//检查目录名
	$dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
	if (empty($ext_arr[$dir_name])) {
		alert("目录名不正确。");
	}
	//获得文件扩展名
	$temp_arr = explode(".", $file_name);
	$file_ext = array_pop($temp_arr);
	$file_ext = trim($file_ext);
	$file_ext = strtolower($file_ext);
	//检查扩展名
	if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
		alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
	}

	//创建文件夹
	if ($dir_name !== '') {
		$save_path .= $dir_name . "/";
		$save_url .= $dir_name . "/";
		if (!file_exists($save_path)) {
			mkdir($save_path);
		}
	}


	// 自定义的目录	
	$save_path .= $company_id . "/";
	$save_url .= $company_id . "/";
	if (!file_exists($save_path)) {
		mkdir($save_path);
	}
	//年
	$year = date("Y");
	$save_path .= $year . "/";
	$save_url .= $year . "/";
	if (!file_exists($save_path)) {
		mkdir($save_path);
	}
	//月
	$month = date("m");
	$save_path .= $month . "/";
	$save_url .= $month . "/";
	if (!file_exists($save_path)) {
		mkdir($save_path);
	}

	//日
	$day = date("d");
	$save_path .= $day . "/";
	$save_url .= $day . "/";
	if (!file_exists($save_path)) {
		mkdir($save_path);
	}

	// $ymd = date("Ymd");
	// $save_path .= $ymd . "/";
	// $save_url .= $ymd . "/";
	// if (!file_exists($save_path)) {
	// 	mkdir($save_path);
	// }
	//新文件名
	$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
	//移动文件
	$file_path = $save_path . $new_file_name;
	if (move_uploaded_file($tmp_name, $file_path) === false) {
		alert("上传文件失败。");
	}
	@chmod($file_path, 0644);
	$file_url = $save_url . $new_file_name;

	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 0, 'url' => $file_url));
	exit;
}

function alert($msg) {
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit;
}
