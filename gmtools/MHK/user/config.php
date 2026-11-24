<?php
error_reporting(0);
session_start();
date_default_timezone_set('PRC');
$gmip = 'http://139.59.107.189:8899/';
$gmcode='g100k';
define('DBHOST','139.59.107.189');
define('DBPORT',3306);
define('DBUSER','hk20');
define('DBPASS','12082001Lvt');
define('DBNAME','account');
define('DBNAMEA','backstage');
//gm后台操作地址
$rdb = backstage;
$url = 'http://139.59.107.189:89/center';
$gmuser = 'xiaowu';
$gmpass = 'a123456789';
$token = 'BEdspSE3Mu';
define('GMNAME','xiaowu');
define('GMPASS','a123456789');
define('TOKEN','BEdspSE3Mu');
define('XIAOWU','game_');
$game = 'backstage';
$gamequid = 'sf';

$quarr = array (
    '1' => array (
        'db_ip' => '139.59.107.189',
        'db_port' => 3306,
        'db_user' => 'hk20',
        'db_pswd' => '12082001Lvt',
        'db_name' => 'game_1',
        'db_name1' => 'backstage',
        'prefix' => 'S1.',
        'prebs' => 'sf1',
        'url' => 'http://139.59.107.189:8666',
        "username"=>"1",//账号
        "password"=>"12082001Lvt@@",//密码
        "login_token"=>"BEdspSE3Mu",  //token
        'name'=>'S1-G100K',
        'hidde'=>false
    ),
    '2' => array (
        'db_ip' => '139.59.107.189',
        'db_port' => 3306,
        'db_user' => 'hk20',
        'db_pswd' => '12082001Lvt',
        'db_name' => 'game_2',
        'db_name1' => 'backstage',
        'prefix' => 'S2.',
        'prebs' => 'sf2',
        'url' => 'http://139.59.107.189:8666',
        "username"=>"1",//账号
        "password"=>"12082001Lvt@@",//密码
        "login_token"=>"BEdspSE3Mu",  //token
        'name'=>'S2',
        'hidde'=>true
    ),

);

$account = array(
    "host" => "139.59.107.189",
    "dbname" => "account",
    "user" => "hk20",
    "pwd" => "12082001Lvt",
    "name" => "账号",
);
$qq_msg = array(
    "host" => "139.59.107.189",
    "dbname" => "qq_msg",
    "user" => "hk20",
    "pwd" => "12082001Lvt",
    "name" => "QQ消息",
);

$zh_quarr = array(
    "1" => array(
        "host" => "139.59.107.189",
        "dbname" => "game2_db_stat",
        "user" => "hk20",
        "pwd" => "hk20",
        "name" => "t1",
        "gm" => "http://139.59.107.189:81/fs/usercenter.php",
    ),
    "2" => array(
        "host" => "139.59.107.189",
        "dbname" => "game2_db_stat",
        "user" => "hk20",
        "pwd" => "hk20",
        "name" => "t2",
        "gm" => "http://139.59.107.189:81/fs/usercenter.php",
    )
);
$getfilter = "'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$postfilter = "\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$cookiefilter = "\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
$secretKey = "5Jqxjo10Yl2ElQCwJm";
//  下面游戏内购礼包注释说明：
//  [ 1 , 0 , 2 , 25, '超值月卡', ],
//  1为充值id，0是判断限购类型（0是不限购，1是角色终身限购，2是每日限购）
//  2是限购数量（当前面限购类型是0不限购模式，这个数量随意，不会判断，当为限购模式，此数据生效）
//  25就是价格了，没什么好说的（此价格不是实际扣款金额，实际扣款是：金额*100）
function getmoney() {
    $payinfo = [
        1  => [ 1 , 0 , 0 , 25, '超值月卡', ],
        2  => [ 2 , 0 , 0 , 88, '至尊特权', ],
        3  => [ 4 , 0 , 0 , 68, '聚宝盆', ],
        4  => [ 5 , 0 , 0 , 30, '太极神魔图', ],
        5  => [ 6 , 0 , 0 , 98, '轩辕神剑', ],
        6  => [ 14 , 2 , 1 , 8, '8元秒杀', ],
        7  => [ 15 , 0 , 0 , 68, '飞仙令', ],
        8  => [ 16 , 2 , 1 , 1, '1元抢购', ],
        9  => [ 17 , 0 , 0 , 648, '雷霆之刃', ],
        10  => [ 18 , 0 , 0 , 648, '雷霆之甲', ],
        11  => [ 19 , 0 , 0 , 648, '雷霆之戒', ],
        12  => [ 20 , 0 , 0 , 648, '雷霆之佩', ],
        13  => [ 21 , 0 , 0 , 198, '黄金圣剑', ],
        14  => [ 22 , 0 , 0 , 198, '黄金圣翼', ],
        15  => [ 23 , 0 , 0 , 198, '黄金圣衣', ],
        16  => [ 24 , 0 , 0 , 198, '黄金圣言', ],
        17  => [ 25 , 0 , 0 , 198, '黄金守护', ],
        18  => [ 26 , 0 , 0 , 198, '黄金天马', ],
        19  => [ 27 , 2 , 1 , 988, '998元秒杀', ],
        20  => [ 31 , 0 , 0 , 68, '土灵珠', ],
        21  => [ 32 , 0 , 0 , 68, '火灵珠', ],
        22  => [ 33 , 0 , 0 , 68, '雷灵珠', ],
        23  => [ 34 , 0 , 0 , 68, '木灵珠', ],
        24  => [ 35 , 0 , 0 , 68, '水灵珠', ],
        25  => [ 36 , 0 , 0 , 68, '风灵珠', ],
        26  => [ 37 , 0 , 0 , 198, '未来光剑', ],
        27  => [ 38 , 0 , 0 , 198, '未来机翼', ],
        28  => [ 39 , 0 , 0 , 198, '未来机甲', ],
        29  => [ 40 , 0 , 0 , 198, '未来守护', ],
        30  => [ 41 , 0 , 0 , 198, '未来战机', ],
        31  => [ 42 , 0 , 0 , 198, '机械飞龙', ],
        32  => [ 43 , 2 , 1 , 1, '1元礼包', ],
        33  => [ 44 , 2 , 1 , 30, '30元礼包', ],
        34  => [ 45 , 2 , 1 , 50, '50元礼包', ],
        35  => [ 46 , 2 , 1 , 30, '30元秒杀', ],
        36  => [ 101 , 0 , 0 , 6, '6', ],
        37  => [ 102 , 0 , 0 , 12, '12', ],
        38  => [ 103 , 0 , 0 , 30, '30', ],
        39  => [ 104 , 0 , 0 , 60, '60', ],
        40  => [ 105 , 0 , 0 , 98, '98', ],
        41  => [ 106 , 0 , 0 , 198, '198', ],
        42  => [ 107 , 0 , 6 , 328, '328', ],
        43  => [ 108 , 0 , 1 , 128, '128', ],
        44  => [ 109 , 0 , 0 , 648, '648', ],
        45  => [ 114 , 0 , 0 , 998, '998', ],
        46  => [ 115 , 0 , 0 , 1998, '1998', ],
        47  => [ 201 , 2 , 1 , 0, 'SVIP0礼包', ],
        48  => [ 202 , 2 , 1 , 6, 'SVIP1礼包', ],
        49  => [ 203 , 2 , 1 , 30, 'SVIP2礼包', ],
        50  => [ 204 , 2 , 1 , 68, 'SVIP3礼包', ],
        51  => [ 299 , 2 , 1 , 98, 'SVIP礼包一键购买', ],
        52  => [ 120 , 0 , 0 , 6, '合服首充6元', ],
        53  => [ 121 , 0 , 0 , 50, '合服首充50元', ],
        54  => [ 122 , 0 , 0 , 200, '合服首充200元', ],
        55  => [ 123 , 0 , 0 , 500, '合服首充500元', ],
        56  => [ 131 , 0 , 0 , 198, '绝版宠物', ],
        57  => [ 132 , 0 , 0 , 6, '麻痹BOSS', ],
        58  => [ 133 , 0 , 0 , 30, '灵兽增伤', ],
        59  => [ 301 , 2 , 1 , 0, '每日礼包1', ],
        60  => [ 302 , 2 , 1 , 6, '每日礼包2', ],
        61  => [ 303 , 2 , 1 , 12, '每日礼包3', ],
        62  => [ 304 , 2 , 1 , 30, '每日礼包4', ],
        63  => [ 305 , 2 , 1 , 68, '每日礼包5', ],
        64  => [ 306 , 2 , 1 , 168, '每日礼包一键购买', ],
        65  => [ 307 , 2 , 1 , 98, '每日礼包6', ],
        66  => [ 308 , 2 , 1 , 328, '328元每日特惠', ],
        67  => [ 309 , 2 , 1 , 648, '648元每日特惠', ],
        68  => [ 310 , 2 , 1 , 998, '998元每日特惠', ],
        69  => [ 311 , 2 , 1 , 198, '天书直购', ],
        70  => [ 401 , 0 , 0 , 68, 'RMB投资·寻宝投资', ],
        71  => [ 402 , 0 , 0 , 30, 'RMB投资·等级投资', ],
        72  => [ 403 , 0 , 0 , 98, 'RMB投资·粉装投资', ],
        73  => [ 404 , 0 , 0 , 98, 'RMB投资·天神投资', ],
        74  => [ 501 , 2 , 1 , 6, '白银天神礼包', ],
        75  => [ 502 , 2 , 1 , 12, '黄金天神礼包', ],
        76  => [ 503 , 2 , 1 , 30, '白金天神礼包', ],
        77  => [ 504 , 2 , 1 , 38, '钻石天神礼包', ],
        78  => [ 505 , 2 , 1 , 98, '一键购买全部礼包', ],
        79  => [ 599 , 0 , 0 , 328, '天神礼包', ],
        80  => [ 598 , 0 , 0 , 98, '天神特权', ],
        81  => [ 597 , 0 , 0 , 30, '天神觉醒礼包灵', ],
        82  => [ 596 , 0 , 0 , 68, '天神觉醒礼包仙', ],
        83  => [ 595 , 0 , 0 , 98, '天神觉醒礼包圣', ],
        84  => [ 594 , 0 , 0 , 198, '天神觉醒礼包神', ],
        85  => [ 601 , 0 , 0 , 8, '福利周卡', ],
        86  => [ 610 , 0 , 0 , 18, '仙玉周卡', ],
        87  => [ 611 , 0 , 0 , 50, '仙玉月卡', ],
        88  => [ 612 , 0 , 0 , 198, '仙玉无限卡', ],
        89  => [ 620 , 0 , 0 , 168, '主角光环', ],
        90  => [ 600 , 0 , 0 , 98, '周活动派对', ],
        91  => [ 602 , 0 , 0 , 98, '庆典活动派对', ],
        92  => [ 613 , 0 , 0 , 328, '至尊装备', ],
        93  => [ 614 , 0 , 0 , 648, '稀有至尊装备', ],
        94  => [ 621 , 0 , 0 , 648, '天帝助力特权', ],
        95  => [ 700 , 2 , 1 , 1, '1元商城', ],
        96  => [ 110 , 0 , 0 , 6, '首充6元', ],
        97  => [ 111 , 0 , 0 , 50, '首充50元', ],
        98  => [ 112 , 0 , 0 , 200, '首充200元', ],
        99  => [ 113 , 1 , 1 , 500, '首充500元', ],
    ];
    return $payinfo;
}
function GetRandStr($length)
{
    $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $len = strlen($str) - 1;
    $randstr = '';
    for ($i = 0; $i < $length; $i++) {
        $num = mt_rand(0, $len);
        $randstr .= $str[$num];
    }
    return $randstr;
}
function toData($data)
{
    exit(json_encode($data, JSON_UNESCAPED_UNICODE));
}
function back($code, $msg)
{
    toData(array('code' => $code, 'msg' => $msg));
}
function backData($code, $msg, $data)
{
    toData(array('code' => $code, 'msg' => $msg, 'data' => $data));
}

function stopAttack($StrFiltKey, $StrFiltValue, $ArrFiltReq)
{
    if (is_array($StrFiltValue)) {
        $StrFiltValue = implode($StrFiltValue);
    }
    if (preg_match("/" . $ArrFiltReq . "/is", $StrFiltValue) == 1) {
        back(1000, "非法操作！");
    }
}
foreach ($_GET as $key => $value) {
    stopAttack($key, $value, $getfilter);
}
foreach ($_POST as $key => $value) {
    stopAttack($key, $value, $postfilter);
}
foreach ($_COOKIE as $key => $value) {
    stopAttack($key, $value, $cookiefilter);
}
function poststr($str)
{
    if (isset($_POST[$str])) {
        return $_POST[$str];
    }
    back(1000, "非法参数！");
}
function get($url, $postdata)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($postdata));
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $output = curl_exec($ch);
    $errorCode = curl_errno($ch);
    curl_close($ch);
    return array('code' => $errorCode, 'data' => $output);
}
function post($url, $postdata)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, 'Content-Type: application/x-www-form-urlencoded');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $output = curl_exec($ch);
    $errorCode = curl_errno($ch);
    curl_close($ch);
    return array('code' => $errorCode, 'data' => $output);
}
function getMillisecond()
{
    list($t1, $t2) = explode(' ', microtime());
    return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
}
function getip()
{
    if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } elseif (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
        $ip = getenv('REMOTE_ADDR');
    }
    preg_match("/[\d\.]{7,15}/", isset($ip) ? $ip : NULL, $match);
    return isset($match[0]) ? $match[0] : 'unknown';
}
