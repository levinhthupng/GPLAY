<?php
error_reporting(1);
session_start();
date_default_timezone_set('HCM');
header("Content-type: text/html; charset=utf-8");
$gmcode='skt3.com';
function notiG100K($status, $msg, $type) {
    $json = [
        'status' => $status,
        'msg' => $msg,
        'type' => $type
    ];
    exit(json_encode($json));
}
$quarr = array (
 "1" => array (
  "user" =>"hk20",
  "pswd" =>"12082001Lvt",
  "dbname"=>"agame_10_999",
  "addr"    => "178.128.113.108",//发货地址
  "port"    => "19992",//发货端口
  "name"    => "S1-G100K",//发货端口
  "hidde"=>false
 ),
 "2" => array (
  "user" =>"hk20",
  "pswd" =>"agame#1234",
  "dbname"=>"agame_11_999",
  "addr"    => "159.223.35.14",//发货地址
  "port"    => "19992",//发货端口
  "name"    => "墨迹大侠2区",//发货端口
  "hidde"=>false
 )
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
function check_connection($ip, $port, $timeout = 5) {
    $socket = @fsockopen($ip, $port, $errno, $errstr, $timeout);
    if ($socket) {
        fclose($socket);
        return true;
    }
    return false;
}
function sendgm($dst_addr, $dst_port, $msg){
    // Giả sử dịch vụ có hỗ trợ HTTP
    $url = "http://$dst_addr:81";

    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'content' => $msg,
            'timeout' => 5
        ]
    ];

    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);

    if ($result === FALSE) {
        return "Không thể kết nối đến $url";
    }

    return $result;
}

?>