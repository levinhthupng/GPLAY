<?php
declare(strict_types=1);
session_start();
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
$gmcode='lyzwlkj.vip';
$gmkey='qianxunniubi';
$quarr = array (
 "1" => array (
  "host"=>"160.250.180.158",
  "dbname"=>"game_admin",
  "user"=>"hk20",
  "port"=>"3306",
  "pwd"=>"12082001Lvt",
  "zoneid"=>910001,
  "mailurl"=>"http://139.59.253.149:82",
  "name"=>"S1-G100K",
  "hidde"=>false
 ),
 "2" => array (
  "host"=>"160.250.180.158",
  "dbname"=>"game_admin",
  "user"=>"root",
  "port"=>"3306",
  "pwd"=>"www.lyzwlkj.vip",
  "mailurl"=>"http://160.250.180.158:82",
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

// ===== [ADD] helpers nhỏ gọn (tuỳ chọn, chỉ tạo nếu chưa có) =====
if (!function_exists('jexit')) {
    function jexit(array $payload, int $code = 200): void {
        if (!headers_sent()) { header('Content-Type: application/json; charset=utf-8'); http_response_code($code); }
        echo json_encode($payload, JSON_UNESCAPED_UNICODE); exit;
    }
}
if (!function_exists('inparam')) {
    function inparam(string $key, $default=null) {
        static $json=null;
        if ($json===null){ $raw=@file_get_contents('php://input'); $json=json_decode($raw,true)?:[]; }
        return $json[$key] ?? $_POST[$key] ?? $_GET[$key] ?? $default;
    }
}

// ===== [ADD] cấu hình & hàm verify qua cURL (giữ nguyên như trước) =====
if (!defined('VERIFY_HOST'))    define('VERIFY_HOST', '160.250.180.158:82');
if (!defined('VERIFY_SESSID'))  define('VERIFY_SESSID', 'dpo3mk8b2vjickmd1tbkv8l013');
if (!defined('VERIFY_REFERER')) define('VERIFY_REFERER', 'http://160.250.180.158:82/admin/');
if (!defined('VERIFY_UA'))      define('VERIFY_UA', 'Mozilla/5.0');

if (!function_exists('verify_apply_goods')) {
    function verify_apply_goods(int $id, int $verifyResult = 1, array $opts = []): array {
        $host    = $opts['host']    ?? VERIFY_HOST;
        $sess    = $opts['sess']    ?? VERIFY_SESSID;
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



/* =====================[ LOGIN + COOKIE MANAGEMENT ]===================== */
/* cấu hình: chỉnh user/pass và tên field theo form thật của bạn */
if (!defined('LOGIN_URL'))        define('LOGIN_URL', 'http://160.250.180.158:82/module/login.php');
if (!defined('CHECK_URL'))        define('CHECK_URL', 'http://160.250.180.158:82/admin/'); // trang cần đăng nhập mới vào được
if (!defined('COOKIE_FILE'))      define('COOKIE_FILE', __DIR__ . '/cookie.txt');

/* --- credentials (đổi cho đúng) --- */
if (!defined('LOGIN_USER'))       define('LOGIN_USER', 'admin');
if (!defined('LOGIN_PASS'))       define('LOGIN_PASS', '12082001Lvt@@');

/* --- tên field POST đúng với form login của bạn --- */
if (!defined('LOGIN_USER_FIELD')) define('LOGIN_USER_FIELD', 'username'); // ví dụ: username / adminname / user
if (!defined('LOGIN_PASS_FIELD')) define('LOGIN_PASS_FIELD', 'password'); // ví dụ: password / adminpass / pwd
// có thể thêm field khác nếu form cần (vd token/captcha...) trong hàm login_save_cookie() ở dưới

/* tiện ích nhỏ: đọc JSON body / POST / GET */
if (!function_exists('inparam')) {
  function inparam(string $k, $d=null){ static $j=null; if($j===null){$raw=@file_get_contents('php://input');$j=json_decode($raw,true)?:[];} return $j[$k]??($_POST[$k]??($_GET[$k]??$d)); }
}

/* Lưu response error JSON */
if (!function_exists('jexit')) {
  function jexit(array $p, int $code=200){ if(!headers_sent()){header('Content-Type: application/json; charset=utf-8'); http_response_code($code);} echo json_encode($p, JSON_UNESCAPED_UNICODE); exit; }
}

/* Gọi HTTP có gắn cookie jar/file (tái sử dụng) */
if (!function_exists('curl_with_cookie')) {
  function curl_with_cookie(string $url, array $opt=[]): array {
    $ch = curl_init($url);
    $base = [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HEADER         => true,
      CURLOPT_TIMEOUT        => 20,
      CURLOPT_COOKIEJAR      => COOKIE_FILE,
      CURLOPT_COOKIEFILE     => COOKIE_FILE,
      CURLOPT_USERAGENT      => 'Mozilla/5.0',
    ];
    foreach ($opt as $k=>$v) { $base[$k]=$v; }
    curl_setopt_array($ch, $base);
    $resp = curl_exec($ch);
    if ($resp === false) {
      $err = curl_error($ch); curl_close($ch);
      return ['ok'=>false,'http_code'=>0,'headers'=>'','body'=>'','error'=>$err];
    }
    $info = curl_getinfo($ch);
    $headerSize = (int)$info['header_size'];
    curl_close($ch);
    return [
      'ok'        => true,
      'http_code' => (int)$info['http_code'],
      'headers'   => substr($resp, 0, $headerSize),
      'body'      => substr($resp, $headerSize),
    ];
  }
}

/* Lấy PHPSESSID từ cookie.txt (định dạng Netscape) */
if (!function_exists('cookie_get_phpsessid')) {
  function cookie_get_phpsessid(string $cookieFile = COOKIE_FILE): ?string {
    if (!is_file($cookieFile)) return null;
    $lines = @file($cookieFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!$lines) return null;
    $val = null;
    foreach ($lines as $ln) {
      if ($ln === '' || $ln[0] === '#') continue;
      $cols = explode("\t", $ln);
      if (count($cols) >= 7 && trim($cols[5]) === 'PHPSESSID') {
        $val = trim($cols[6]);
      }
    }
    return $val ?: null;
  }
}

/* Đăng nhập và lưu cookie.txt; trả về PHPSESSID mới */
if (!function_exists('login_save_cookie')) {
  function login_save_cookie(?string $user=null, ?string $pass=null): ?string {
    $user = $user ?? LOGIN_USER;
    $pass = $pass ?? LOGIN_PASS;

    // B1: GET login page để server tạo PHPSESSID ban đầu (nếu cần)
    curl_with_cookie(LOGIN_URL);

    // B2: POST form login (đổi field đúng với form thực tế)
    $post = [
      LOGIN_USER_FIELD => $user,
      LOGIN_PASS_FIELD => $pass,
      'submit'         => 'Login' // nếu form có nút submit name khác, đổi tại đây
    ];
    $res = curl_with_cookie(LOGIN_URL, [
      CURLOPT_POST       => true,
      CURLOPT_POSTFIELDS => http_build_query($post),
      CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded', 'Referer: '.LOGIN_URL],
    ]);

    // Kiểm tra đăng nhập có chuyển hướng ra trang quản trị hay không
    $sid = cookie_get_phpsessid();
    if (!$sid) return null;

    // Một số site trả 200 nhưng body chứa "登录/请先登录" → coi như fail
    $body = @mb_convert_encoding($res['body'], 'UTF-8', 'UTF-8,GBK,GB2312,BIG5,ISO-8859-1');
    if (preg_match('/登录|請先登錄|请先登录/i', $body)) {
      return null;
    }
    return $sid;
  }
}

/* Kiểm tra session còn hạn (truy cập CHECK_URL) */
if (!function_exists('session_is_valid')) {
  function session_is_valid(): bool {
    if (!is_file(COOKIE_FILE)) return false;
    $res = curl_with_cookie(CHECK_URL);
    if (!$res['ok']) return false;
    $body = @mb_convert_encoding($res['body'], 'UTF-8', 'UTF-8,GBK,GB2312,BIG5,ISO-8859-1');
    $hdrs = $res['headers'];

    // 302 về login.php hoặc body chứa từ khóa login => hết hạn
    if (preg_match('~/module/login\.php~i', $hdrs)) return false;
    if (preg_match('/登录|請先登錄|请先登录/i', $body)) return false;

    // 200/3xx và không có dấu hiệu login ⇒ hợp lệ
    return $res['http_code'] >= 200 && $res['http_code'] < 400;
  }
}

/* Đảm bảo luôn có session hợp lệ: nếu hết hạn thì login lại; trả về PHPSESSID */
if (!function_exists('ensure_session')) {
  function ensure_session(): ?string {
    $sid = cookie_get_phpsessid();
    if ($sid && session_is_valid()) return $sid;

    // login lại
    $sid = login_save_cookie();
    return $sid;
  }
}
?>