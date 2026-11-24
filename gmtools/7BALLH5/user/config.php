<?php
declare(strict_types=1);
session_start();
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
$gmcode='lyzwlkj.vip';
$gmkey='qianxunniubi';
$quarr = array (
 "1" => array (
  "host"=>"163.61.183.80",
  "dbname"=>"game_admin",
  "user"=>"hk20",
  "port"=>"3306",
  "pwd"=>"12082001Lvt",
  "zoneid"=>910001,
  "mailurl"=>"http://163.61.183.80:82",
  "name"=>"S1-G100K",
  "hidde"=>false
 ),
 "2" => array (
  "host"=>"163.61.183.80",
  "dbname"=>"game_admin",
  "user"=>"root",
  "port"=>"3306",
  "pwd"=>"www.lyzwlkj.vip",
  "mailurl"=>"http://163.61.183.80:82",
  "zoneid"=>910002,
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

if (!function_exists('db_con')) {
    function db_con() {
        // dùng biến config sẵn có của bạn
        global $dbip, $dbuser, $dbpwd, $dbname, $dbport;
        static $con = null;
        if (is_object($con)) return $con;

        // mặc định port nếu thiếu
        if (empty($dbport)) $dbport = 3306;

        // đảm bảo extension
        if (!extension_loaded('mysqli')) {
            if (function_exists('notiG100K')) notiG100K(0, "Thiếu extension mysqli", "error");
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(500);
            echo json_encode(['ok'=>false,'error'=>'EXT_MISSING_MYSQLI']);
            exit;
        }

        $con = @mysqli_connect($dbip, $dbuser, $dbpwd, $dbname, (int)$dbport);
        if (mysqli_connect_errno()) {
            if (function_exists('notiG100K')) notiG100K(0, "Không Thể Kết Nối Đến Server !", "error");
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(500);
            echo json_encode(['ok'=>false,'error'=>'DB_CONNECT_FAIL','msg'=>mysqli_connect_error()]);
            exit;
        }

        // charset
        if (!@mysqli_set_charset($con, 'utf8mb4')) {
            @mysqli_set_charset($con, 'utf8');
        }
        return $con;
    }
}


// ===== [ADD] cấu hình & hàm verify qua cURL (giữ nguyên như trước) =====
if (!defined('VERIFY_HOST'))    define('VERIFY_HOST', '163.61.183.80:82');
if (!defined('VERIFY_SESSID'))  define('VERIFY_SESSID', '2u2d6uec5m8spas1jebld6lpt111qi');
if (!defined('VERIFY_REFERER')) define('VERIFY_REFERER', 'http://163.61.183.80:82/admin/');
if (!defined('VERIFY_UA'))      define('VERIFY_UA', 'Mozilla/5.0');

if (!function_exists('verify_apply_goods')) {
    function verify_apply_goods(int $id, int $verifyResult = 1, array $opts = []): array {
        $host    = $opts['host']    ?? VERIFY_HOST;
        if (!isset($opts['sess'])) {
            $login = fetch_verify_sessid($opts);
            if (!$login['ok']) {
                return ['ok'=>false,'error'=>'LOGIN_FAIL'];
            }
            $sess = $login['sess'];
        } else {
            $sess = $opts['sess'];
        }
        $referer = $opts['referer'] ?? VERIFY_REFERER;
        $ua      = $opts['ua']      ?? VERIFY_UA;

        $url = "http://{$host}/module/pay/apply_goods_list.php?action=yes&id={$id}&verifyResult={$verifyResult}";
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_HEADER => true,
            CURLOPT_HTTPHEADER => [
                "Cookie: PHPSESSID={$sess}",
                "Referer: {$referer}",
                "X-Requested-With: XMLHttpRequest",
                "User-Agent: {$ua}",
            ],
        ]);
        $resp = curl_exec($ch);
        if ($resp === false) { $err=curl_error($ch); curl_close($ch); return ['ok'=>false,'error'=>'CURL_FAIL','msg'=>$err]; }
        $info       = curl_getinfo($ch);
        $httpCode   = (int)$info['http_code'];
        $headerSize = (int)$info['header_size'];
        curl_close($ch);

        $rawBody  = substr($resp, $headerSize);
        $bodyUtf8 = @mb_convert_encoding($rawBody, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5,ISO-8859-1');
        $isErr    = (mb_strpos($bodyUtf8, '提交错误') !== false);
        $ok       = ($httpCode >= 200 && $httpCode < 400) && !$isErr;

        return [
            'ok'   => $ok,
            'code' => $httpCode,
            'url'  => $url,
            'body' => mb_substr(trim(strip_tags($bodyUtf8 ?? '')), 0, 200),
        ];
    }
}

function fetch_verify_sessid(array $opts = []): array
{
    $host = $opts['host'] ?? VERIFY_HOST;
    $user = "admin";
    $pass = "12082001Lvt@@";
    $ua   = $opts['ua']   ?? VERIFY_UA;

    $loginUrl = "http://{$host}/module/login.php";

    $ch = curl_init($loginUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => true,
        CURLOPT_POST           => true,
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_HTTPHEADER     => [
            "User-Agent: {$ua}",
            "X-Requested-With: XMLHttpRequest",
        ],
        CURLOPT_POSTFIELDS => http_build_query([
            'username' => $user,
            'password' => $pass,
        ]),
    ]);

    $resp = curl_exec($ch);
    if ($resp === false) {
        return ['ok'=>false,'error'=>'CURL_FAIL','msg'=>curl_error($ch)];
    }

    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    curl_close($ch);

    $header = substr($resp, 0, $headerSize);

    if (preg_match('/PHPSESSID=([^;]+)/', $header, $m)) {
        return [
            'ok'   => true,
            'sess' => $m[1],
        ];
    }

    return ['ok'=>false,'error'=>'NO_SESSION'];
}


?>