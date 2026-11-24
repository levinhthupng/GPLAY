<?php
error_reporting(0);
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
header("Content-type: text/html; charset=utf-8");
function notiG100K($status, $msg, $type) {
    $json = [
        'status' => $status,
        'msg' => $msg,
        'type' => $type
    ];
    exit(json_encode($json));
}
$config_mysql = array(
    'db_host' => '139.59.253.81',
    'db_user' => 'hk20',
    'db_pass' => '12082001Lvt',
);
$gmcode = 'toandaik'; //GM Pass

$quarr = array (
    '1'=>array(
        'url' => 'http://127.0.0.1:3030/mail/add',
        'db_name' => 'cdk',
        'name' => 'S1-G100K',
        'show' => 1,
        'id' => 1
    ),
    '2'=>array(
        'url' => 'http://127.0.0.1:3030/mail/add',
        'db_name' => 'cdk',
        'name' => 'S2-G100K',
        'show' => 1,
        'id' => 2
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
        notiG100K(0,"Hoạt động bất hợp pháp!","error");
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
    notiG100K(0,"Tham số bạn đã gửi là bất hợp pháp!","error");
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
function post($url,$post){
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt ($ch, CURLOPT_HEADER, false);
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($post));
    $result = curl_exec($ch);
    $errorCode = curl_errno($ch);
    curl_close($ch);
    if(0 !== $errorCode){
        return 'failed '.$errorCode;
    }
    return $result;
}
function sendPostRequest($url, $data) {
	
	// 初始化 cURL 会话
$ch = curl_init($url);

// 设置 cURL 选项
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        // 使用 POST 方法

$headers = array(
   "Content-Type: application/json",
);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // 设置 POST 数据
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// 执行请求并获取响应
$response = curl_exec($ch);

// 关闭 cURL 会话
curl_close($ch);

return $response;
}
?>