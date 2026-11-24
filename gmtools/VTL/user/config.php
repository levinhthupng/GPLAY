<?php
error_reporting(0);
session_start();
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
$gmcode='12082001Lvt';
$quarr = array (
 "10001" => array (
  "manageurl"=>"http://174.138.16.27:81/",//请以/结尾
  "gid"=>10000,
  "svid"=>"1",
  "host"=>"174.138.16.27",
  "dbname"=>"vtnemo_center_dev",
  "dbname1"=>"s10001_tl_gznemo",
  "user"=>"hk20",
  "pwd"=>"12082001Lvt",
  "name"=>"S1-G100K",
  "manageuser"=>"lyzwlkjvip",
  "managepwd"=>"lyzwlkj.vip",
  "hidde"=>false
 ),
 
  "10002" => array (
  "manageurl"=>"http://174.138.16.27:81/",//请以/结尾
  "gid"=>10000,
  "svid"=>"2",
  "host"=>"174.138.16.27",
  "dbname"=>"vtnemo_center_dev",
  "dbname1"=>"s10002_tl_gznemo",
  "user"=>"hk20",
  "pwd"=>"12082001Lvt",
  "name"=>"S2-G100K",
  "manageuser"=>"lyzwlkjvip",
  "managepwd"=>"lyzwlkj.vip",
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
?>