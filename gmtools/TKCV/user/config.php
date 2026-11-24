<?php
error_reporting(0);
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
header("Content-type: text/html; charset=utf-8");
$PZ = array(
    'DB_HOST'=>'188.166.243.140',// 服务器地址
    'DB_NAME'=>'tzj_gm',// 游戏数据库
    'DB_USER'=>'hk20',// 用户名
    'DB_PWD'=>'12082001Lvt',// 密码
    'DB_PORT'=>'3306',// 端口
    'DB_CHARSET'=>'utf8',// 数据库字符集
);

function notiG100K($status, $msg, $type) {
    $json = [
        'status' => $status,
        'msg' => $msg,
        'type' => $type
    ];
    exit(json_encode($json));
}
$config_mysql = array(
    'db_host' => '188.166.243.140',
    'db_user' => 'hk20',
    'db_pass' => '12082001Lvt',
);
$gmcode = 'toandaik'; //GM Pass

$quarr = array (
    '1'=>array(
        'url' => 'http://188.166.243.140:3030/mail/add',
        'db_name' => 'tzj_gm',
        'name' => 'S1-G100K',
        'show' => 1,
        'id' => 1001
    ),
    '2'=>array(
        'url' => 'http://188.166.243.140:3030/mail/add',
        'db_name' => 'tzj_gm',
        'name' => 'S2-G100K',
        'show' => 1,
        'id' => 1002
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
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // 返回响应体
curl_setopt($ch, CURLOPT_POST, true);            // 使用 POST 方法
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // 设置 POST 数据

// 执行请求并获取响应
$response = curl_exec($ch);

// 关闭 cURL 会话
curl_close($ch);

return $response;
}

function curl_https($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    $cnt = curl_exec($ch);
    curl_close($ch);
    return $cnt;
}
function post_curl($url, $params=[], $headers=[]){
    $httpInfo = array();
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );

    curl_setopt( $ch , CURLOPT_POST , true );
    curl_setopt( $ch , CURLOPT_POSTFIELDS , http_build_query($params));
    curl_setopt( $ch , CURLOPT_URL , $url );


    $response = curl_exec( $ch );
    if ($response === FALSE) {
        return false;
    }

    curl_close( $ch );
    return $response;
}
function curl_login() {
    $url = "http://188.166.243.140:8080/TzjBackend/user/login";
    $username = "admin";
    $password = 'admin';
    $params = [
        'username' => $username,
        'password' => $password
    ];
    $response = post_curl($url, $params);
    if (!$response) {
        return false;
    }
    list($header, $body) = explode("\r\n\r\n", $response, 2);
    preg_match("/set\-cookie:([^\r\n]*)/i", $header, $matches);
    $cookie = explode(';', $matches[1])[0];
    return $cookie;
}

function curl_http_post($url, $data) {
    $cookie = curl_login();
    if (!$cookie) {
        return "Login failed, cannot get cookie.";
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
function gmmail($serverid, $uuid, $item, $itemnum, $mysql) {
    $res = $mysql->query("INSERT INTO `tzj_backend`.`t_mail` ( `groupName`, `serverId`, `roleIds`, `title`, `content`, `items`, `reason`, `createDate`, `createUser`, `adminUser`, `adminDate`, `adminState`, `sendState`, `sendErrorMess`, `isDelete`, `sended`) VALUES ( 'qx', '$serverid', '$uuid', 'G100K - TOOLS GM', 'G100K - TOOLS GM', '$item,$itemnum,0,9', 'G100K - TOOLS GM', '".date("Y-m-d H:i:s", time())."', 'admin', NULL, NULL, '1', '0', NULL, '0', '0')");
    if (!$res) {
        notiG100K(0,"Database insert failed: " . $mysql->error,"success");
    }
    $last_id = $mysql->insert_id;
    $url = "http://188.166.243.140:8080/TzjBackend/mail/adminMail";
    $data = [
        'id' => $last_id,
        'type' => 1
    ];
    return curl_http_post($url, $data);
}
?>