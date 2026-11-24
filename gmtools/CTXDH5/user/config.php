<?php
//error_reporting(0);
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
header("Content-type: text/html; charset=utf-8");


$PZ = array(
	'DB_HOST'=>'127.0.0.1',// 服务器地址
	'DB_GAME'=>'sglocal',// 账号数据库
	'DB_NAME'=>'cdk',// 游戏数据库
	'DB_USER'=>'root',// 用户名
	'DB_PWD'=>'123456',// 密码
	'DB_PORT'=>'3306',// 端口
	'DB_CHARSET'=>'utf8',// 数据库字符集
);
$gmcode='lyzwlkj.vip';
$gmkey='qianxunniubi';
$quarr = array (
 "1" => array (
  "host"=>"178.128.127.190",
  "dbname"=>"SgLocal",
  "user"=>"hk20",
  "port"=>"3306",
  "pwd"=>"12082001Lvt",
  "zoneid"=>1,
  "mailurl"=>"http://178.128.127.190:8500",
  "GAME_USER"=>"admin", // 后台账号
  "GAME_PSWD"=>"12082001Lvt@@", // 后台密码
  "name"=>"S1-G100K",
  "hidde"=>false
 ),
 "2" => array (
  "host"=>"178.128.127.190",
  "dbname"=>"SgLocal",
  "user"=>"hk20",
  "port"=>"3306",
  "pwd"=>"12082001Lvt",
  "mailurl"=>"http://178.128.127.190:8500",
  "GAME_USER"=>"admin", // 后台账号
  "GAME_PSWD"=>"12082001Lvt@@", // 后台密码
  "zoneid"=>2,
  "name"=>"S2-G100K",
  "hidde"=>false
 ),
);


$getfilter="'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$postfilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$cookiefilter="\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
function StopAttack($StrFiltKey,$StrFiltValue,$ArrFiltReq){
	if(is_array($StrFiltValue)){
		$StrFiltValue=implode($StrFiltValue);
	}
	if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue)==1){
		print "非法操作!";
		exit();
	}
}
foreach($_GET as $key=>$value){
	StopAttack($key,$value,$getfilter);
}
foreach($_POST as $key=>$value){
	StopAttack($key,$value,$postfilter);
}
foreach($_COOKIE as $key=>$value){
	StopAttack($key,$value,$cookiefilter);
}
function poststr($str){
 if(isset($_POST[$str])){
  return $_POST[$str];
 }
die("您提交的参数非法！");
}
function get($url,$postdata){
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url.'?'.http_build_query($postdata)); 
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = curl_exec($ch);
		$errorCode = curl_errno($ch);
		return $output;
	}
function exit_notice($message,$errno,$other=array()){
	if(is_array($message)) $message =json_encode($message,JSON_UNESCAPED_UNICODE);
	$rtn['message']=$message;
	$rtn['errno']=$errno;
	if(count($other)>0){
		foreach($other as $k=>$v){
			$rtn[$k]=$v;
		}
	}
	exit(json_encode($rtn,JSON_UNESCAPED_UNICODE));
}

?>