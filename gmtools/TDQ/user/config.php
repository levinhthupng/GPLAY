<?php
error_reporting(0);
session_start();
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
$gmcode='g100k';
$quarr = array (
 "1" => array (
  "zoneid"=>1,
  "host"=>"188.166.189.107",
  "dbname"=>"xl_s1",
  "user"=>"hk20",
  "pwd"=>"12082001Lvt",
  "name"=>"S1-G100K",
  "hidde"=>false
 ),
  "2" => array (
  "zoneid"=>2,
  "host"=>"188.166.189.107",
  "dbname"=>"xl_s2",
  "user"=>"hk20",
  "pwd"=>"12082001Lvt",
  "name"=>"S2-G100K",
  "hidde"=>false
 ),
  "3" => array (
  "zoneid"=>3,
  "host"=>"188.166.189.107",
  "dbname"=>"xl_s3",
  "user"=>"hk20",
  "pwd"=>"12082001Lvt",
  "name"=>"S3-G100K",
  "hidde"=>false
 ),
  "4" => array (
  "zoneid"=>4,
  "host"=>"188.166.189.107",
  "dbname"=>"xl_s4",
  "user"=>"hk20",
  "pwd"=>"123456",
  "name"=>"S4",
  "hidde"=>true
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

  return $_POST[$str];

}

function strToHex($str){
    $hex="";
    for($i=0;$i<strlen($str);$i++)
        $hex.=dechex(ord($str[$i]));
    $hex=strtoupper($hex);
    return "0x".$hex;
}

?>