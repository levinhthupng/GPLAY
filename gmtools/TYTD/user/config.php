<?php
//error_reporting(0);
session_start();
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
$gmcode='lyzwlkj.vip';
$gmkey='qianxunniubi';
$quarr = array (
 "10001" => array (
  "host"=>"139.59.253.149",
  "dbname"=>"ddg_1",
  "user"=>"hk20",
  "port"=>"3306",
  "pwd"=>"12082001Lvt",
  "zoneid"=>1,
  "mailurl"=>"http://139.59.253.149:3251/sendMail",
  "name"=>"S1-G100K",
  "hidde"=>false
 ),
 "10002" => array (
  "host"=>"127.0.0.1",
  "dbname"=>"ddg_2",
  "user"=>"root",
  "port"=>"3306",
  "pwd"=>"www.lyzwlkj.vip",
  "mailurl"=>"http://127.0.0.1:3253/sendMail",
  "zoneid"=>2,
  "name"=>"魔道2区",
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
function postFormRequest($url, $formData, $timeout = 10,$verifySSL = false) {
    // 初始化返回结构
    $result = [
        'status' => false,
        'code' => 0,
        'data' => '',
        'error' => ''
    ];

    try {
        $ch = curl_init();
        
        // 核心配置参数
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($formData), // 自动处理表单编码
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_SSL_VERIFYPEER => $verifySSL,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8'
            ]
        ];

        curl_setopt_array($ch, $options);
        
        $response = curl_exec($ch);
        $errorNo = curl_errno($ch);
        
        if ($errorNo) {
            $result['error'] = curl_error($ch);
        } else {
            $result['status'] = true;
            $result['code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $result['data'] = $response;
        }
        
    } catch (Exception $e) {
        $result['error'] = 'Exception: ' . $e->getMessage();
    } finally {
        if (is_resource($ch)) {
            curl_close($ch);
        }
    }

    return $result;
}
?>