<?php
error_reporting(0);
//session_start();
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");
$gmcode='8890';
$quarr = array (
    "1" => array (
        "manageurl"=>"http://68.183.235.198:7200/",//请以/结尾
        "host"=>"68.183.235.198",
        "dbname"=>"wow-dldl_1",
        "user"=>"hk20",
        "pwd"=>"12082001Lvt",
        "zoneid"=>1,
        "servers"=>"dldl_1",
        "name"=>"S1-G100K",
        "manageuser"=>"admin",
        "managepwd"=>"12082001Lvt@@",
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
    die($str);
}
function timediff($begin_time,$end_time)

{

    if($begin_time < $end_time){

        $starttime = $begin_time;

        $endtime = $end_time;

    }else{

        $starttime = $end_time;

        $endtime = $begin_time;

    }

    //计算天数

    $timediff = $endtime-$starttime;

    $cha = date_diff(date_create(date('Ymd',$starttime)),date_create(date('Ymd',$endtime)));
    $days =  $cha->days;
    //$days = round($timediff/86400);

    //计算小时数

    $remain = $timediff%86400;

    $hours = intval($remain/3600);

    //计算分钟数

    $remain = $remain%3600;

    $mins = intval($remain/60);

    //计算秒数

    $secs = $remain%60;

    $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);

    return $res;

}
function SafeRequest($key, $mode, $type = 0) { //过滤post和get传递的参数
    $magic = get_magic_quotes_gpc();
    switch ($mode) {
        case 'post':
            $value = isset($_POST[$key]) ? $magic ? trim($_POST[$key]) : addslashes(trim($_POST[$key])) : NULL;
            break;
        case 'get':
            $value = isset($_GET[$key]) ? $magic ? trim($_GET[$key]) : addslashes(trim($_GET[$key])) : NULL;
            break;
    }
    return $type ? $value : htmlspecialchars(str_replace('\\' . '\\', '', $value), ENT_QUOTES, "UTF-8", false);
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
?>