<?php
error_reporting(0);
session_start();
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
$gmcode='12082001Lvt';
$quarr = array (
 "10001" => array (
  "manageurl"=>"http://146.190.83.72:19001/hgame/background_api",//请以/结尾
  "gid"=>10000,
  "svid"=>"1",
  "host"=>"146.190.83.72",
  "dbname"=>"lyz_webgame",
  "dbname1"=>"lyz_webgame",
  "user"=>"hk20",
  "pwd"=>"12082001Lvt",
  "name"=>"S1-G100K",
  "manageuser"=>"bl20166",
  "managepwd"=>"bl201666",
  "hidde"=>false
 ),
 
  "10002" => array (
  "manageurl"=>"http://159.223.43.85:9090/",//请以/结尾
  "gid"=>10000,
  "svid"=>"2",
  "host"=>"146.190.83.72",
  "dbname"=>"lyz_webgame",
  "dbname1"=>"lyz_webgame",
  "user"=>"hk20",
  "pwd"=>"12082001Lvt",
  "name"=>"S2-G100K",
  "manageuser"=>"bl20166",
  "managepwd"=>"bl201666",
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
function post_curl($url, $data_string) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 1);	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	$result = curl_exec($ch);
	if(curl_errno($ch)){
		print_r(curl_error($ch));
	}
	curl_close($ch);
	return $result;	
}	
function apiLogin(){
    $urllogin = "http://146.190.83.72:668/api/login";
    $datalogin = [
                                        'username' => 'admin',
                                        'password' => 'lyzwlkj.vip',
                                    ];
    
    // 初始化cURL会话
    $chlogin = curl_init();
    
    // 设置cURL选项
    curl_setopt($chlogin, CURLOPT_URL, $urllogin);
    curl_setopt($chlogin, CURLOPT_POST, true);
    curl_setopt($chlogin, CURLOPT_POSTFIELDS, http_build_query($datalogin));
    curl_setopt($chlogin, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($chlogin, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
    ]);
    
    // 执行cURL请求
    $responselogin = curl_exec($chlogin);
    
    // 检查错误
    if (curl_errno($chlogin)) {
        echo 'Error: ' . curl_error($chlogin);
    } else {
        // 解析JSON响应
        $responseData = json_decode($responselogin, true);
        
        if (isset($responseData['success']) && $responseData['success'] === true) {
            // 登录成功，保存信息到文件
            $loginData = [
                'username' => $responseData['data']['username'],
                'nickname' => $responseData['data']['nickname'],
                'accessToken' => $responseData['data']['accessToken'],
                'refreshToken' => $responseData['data']['refreshToken'],
                'roles' => implode(',', $responseData['data']['roles']),
            ];
            file_put_contents('login_info.txt', json_encode($loginData, JSON_PRETTY_PRINT));
           // echo '登录成功，信息已保存到文件！';
        } else {
           notiG100K(0,"Lỗi Login Admin","error");
        }
    }
    
    // 关闭cURL会话
    curl_close($chlogin);
}
function notiG100K($status, $msg, $type) {
    $json = [
        'status' => $status,
        'msg' => $msg,
        'type' => $type
    ];
    exit(json_encode($json));
}	
?>