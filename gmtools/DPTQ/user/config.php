<?php
declare(strict_types=1);
session_start();
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
// Hàm gửi item cho nhân vậ


function notiG100K($status, $msg, $type) {
    $json = [
        'status' => $status,
        'msg' => $msg,
        'type' => $type
    ];
    exit(json_encode($json));
}
$gmcode='lyzwlkj.vip';
$gmkey='qianxunniubi';

$PZ = array(
	'DB_HOST'=>'34.87.140.7',// 服务器地址
	'DB_NAME'=>'cdk',// 游戏数据库
	'DB_USER'=>'hk20',// 用户名
	'DB_PWD'=>'12082001Lvt',// 密码 - 修改为正确密码
	'DB_PORT'=>3306,// 端口
	'DB_CHARSET'=>'utf8',// 数据库字符集
);
$gm = "http://34.87.140.7:8809";
$quarr = array (
 "1" => array (
  "host"=>"34.87.140.7",
  "dbname"=>"cdk",
  "user"=>"hk20",
  "qu"=>"12",
  "fu"=>"120001",
  "port"=>"3306",
  "pwd"=>"12082001Lvt",
  "zoneid"=>"1",
  "mailurl"=>"http://34.87.140.7:8809",
  "name"=>"S1-G100K",
  "hidde"=>false
 ),
 "2" => array (
  "host"=>"34.87.140.7",
  "dbname"=>"tcg",
  "user"=>"hk20",
  "port"=>"3306",
  "pwd"=>"12082001Lvt",
  "mailurl"=>"http://34.87.140.7:81/zyht/api/send_mail",
  "zoneid"=>910002,
  "name"=>"魔道2区",
  "hidde"=>false
 ),
);

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


if (!function_exists('loginGetCookie')) {
function loginGetCookie($url,$user,$pswd){
         $ch = curl_init($url); 
		 $post = array(
		  "username" => "$user" ,
	      "password" =>  "$pswd",
		);
		
		  curl_setopt($ch, CURLOPT_HEADER, 1);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
          curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
		  $content=curl_exec($ch);
          preg_match('/Set-Cookie:(.*);/iU',$content,$str); 
          $cookie = $str[1]; //获得COOKIE
		  return $cookie;
}
}

if (!function_exists('sendMail')) {
function sendMail($url, $formData, $cookies = '', $timeout = 10, $verifySSL = false) {
    $result = [
        'status' => false,
        'code' => 0,
        'data' => null,
        'error' => null
    ];

    $ch = null;
    try {
        $ch = curl_init();
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($formData),
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_SSL_VERIFYPEER => $verifySSL,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8'
            ],
        ];

        // 如果有 cookie，则加入 CURLOPT_COOKIE
        if (!empty($cookies)) {
            $options[CURLOPT_COOKIE] = $cookies;  // 直接传入cookie字符串
        }

        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $errorNo = curl_errno($ch);

        if (!$errorNo) {
            $result['status'] = true;
            $result['code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $result['data'] = $response;
        } else {
            $result['error'] = curl_error($ch);
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
}


if (!function_exists('sendrechargeMail')) {
function sendrechargeMail($qu, $uid, $title, $content, $items ) {
    $mailData = ["param"=>
    array(
        "ac_id" => $uid,
        "os_type" => 1,
        "id" => $items,
        "type_key" => "1:$items"
    )];
    global $gm;
    $mailApi = $gm ."/api/virtual_pay/send";
    $result = get($mailApi, $mailData);
    return $result;
}
}
if (!function_exists('sendGameMail')) {
function sendGameMail($qu, $uid, $title, $content, $items = array()) {
    $mailData = ["param"=>
    array(
        "acid" => $uid,
        "expireTime" => 0,
        "sendTime" => time(),
        "titleParams" => $title ?: "G100K.NET - TOOLS VIP",
        "gmsGId" => $qu,
        "itemList" => $items,
        "contentParams" => $content ?: "Server Game Private Online: G100K.NET"
    )];
    global $gm;
    $mailApi = $gm ."/api/single_mail/add";
    $result = get($mailApi, $mailData);
    return $result;
}
}

if (!function_exists('get')) {
function get($url = '', $param = '') {
    $curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($param),
  CURLOPT_HTTPHEADER => [
    "content-type: application/json"
  ],
]);
$res = curl_exec($curl);
$err = curl_error($curl);
    curl_close($curl);
    if ($res === false) {
        return array('success' => false, 'error' => 'cURL执行失败: ' . $error);
    }

    $decoded = json_decode($res, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        return array('success' => true, 'data' => $decoded);
    } else {
      
        return array('success' => true, 'data' => array('result' => -1, 'message' => $res));
    }
}
}


if (!function_exists('queryRoleInfo')) {
function queryRoleInfo($uid) {
    try {
        global $PZ;
        $db = new mysqli($PZ["DB_HOST"], $PZ["DB_USER"], $PZ["DB_PWD"], $PZ["DB_NAME"], $PZ["DB_PORT"]);
        if ($db->connect_errno) {
            return false;
        }
        $db->set_charset('utf8');
        

        $sql = "SELECT * FROM `account` WHERE `account`='$uid'LIMIT 1";
        $result = $db->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
 
            $db->close();
            return $row;
        }
        
        $db->close();
        return false;
    } catch (Exception $e) {
        return false;
    }
}
}


?>