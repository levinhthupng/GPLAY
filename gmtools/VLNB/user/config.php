<?php
declare(strict_types=1);
session_start();
date_default_timezone_set('PRC');
header("Content-type: text/html; charset=utf-8");

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
$quarr = array (
 "1" => array (
  "host"=>"143.198.90.189",
  "dbname"=>"tcg",
  "user"=>"hk20",
  "port"=>"3306",
  "pwd"=>"12082001Lvt",
  "zoneid"=>"s1",
  "mailurl"=>"http://143.198.90.189:82",
  "name"=>"S1-G100K",
  "hidde"=>false
 ),
 "2" => array (
  "host"=>"143.198.90.189",
  "dbname"=>"tcg",
  "user"=>"hk20",
  "port"=>"3306",
  "pwd"=>"www.lyzwlkj.vip",
  "mailurl"=>"http://143.198.90.189:82",
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
function get_qu_list(){
    $quarr = array (
        "1" => array (
            "host"  =>"143.198.90.189",
            "dbname"=>"tcg",
            "user"  =>"hk20",
            "pwd"   =>"12082001Lvt",
            "name"  =>"1区",
            "code"  => 's1'
        ),
        "2" => array (
            "host"  =>"143.198.90.189",
            "dbname"=>"tcg",
            "user"  =>"hk20",
            "pwd"   =>"12082001Lvt",
            "name"  =>"2区",
            "code"  => 's2'
        ),
        "3" => array (
            "host"  =>"143.198.90.189",
            "dbname"=>"tcg",
            "user"  =>"hk20",
            "pwd"   =>"12082001Lvt",
            "name"  =>"3区",
            "code"  => 's3'
        ),
        "4" => array (
            "host"  =>"143.198.90.189",
            "dbname"=>"tcg",
            "user"  =>"hk20",
            "pwd"   =>"12082001Lvt",
            "name"  =>"4区",
            "code"  => 's4'
        ),
        "5" => array (
            "host"  =>"143.198.90.189",
            "dbname"=>"tcg",
            "user"  =>"hk20",
            "pwd"   =>"12082001Lvt",
            "name"  =>"5区",
            "code"  => 's5'
        ),
		"6" => array (
            "host"  =>"143.198.90.189",
            "dbname"=>"tcg",
            "user"  =>"hk20",
            "pwd"   =>"12082001Lvt",
            "name"  =>"6区",
            "code"  => 's6'
        ),
		"7" => array (
            "host"  =>"143.198.90.189",
            "dbname"=>"tcg",
            "user"  =>"hk20",
            "pwd"   =>"12082001Lvt",
            "name"  =>"7区",
            "code"  => 's7'
        ),
		"8" => array (
            "host"  =>"143.198.90.189",
            "dbname"=>"tcg",
            "user"  =>"hk20",
            "pwd"   =>"12082001Lvt",
            "name"  =>"8区",
            "code"  => 's8'
        ),
		"9" => array (
            "host"  =>"143.198.90.189",
            "dbname"=>"tcg",
            "user"  =>"hk20",
            "pwd"   =>"12082001Lvt",
            "name"  =>"9区",
            "code"  => 's9'
        ),
		"10" => array (
            "host"  =>"143.198.90.189",
            "dbname"=>"tcg",
            "user"  =>"hk20",
            "pwd"   =>"12082001Lvt",
            "name"  =>"10区",
            "code"  => 's10'
        ),
    );
    return $quarr;
}


function get_pay_item(){
    $con = @mysqli_connect('143.198.90.189', 'hk20', '12082001Lvt') or die(mysql_error());
    mysqli_query($con,"set names 'utf8'");
    mysqli_select_db($con,'tcg');
    $sql = "SELECT * FROM `charge_item`";
    $result = mysqli_query($con,$sql);
    $info = [];
    while ($one = mysqli_fetch_assoc($result)) {
        $info[] = $one;
    }
    return $info;
}

function get_wp_item(){
    $con = @mysqli_connect('143.198.90.189', 'hk20', '12082001Lvt') or die(mysql_error());
    mysqli_query($con,"set names 'utf8'");
    mysqli_select_db($con,'tcg');
    $sql = "SELECT * FROM `wp_code`";
    $result = mysqli_query($con,$sql);
    $info = [];
    while ($one = mysqli_fetch_assoc($result)) {
        $info[$one['key']] = $one['value'];
    }
    return $info;
}

function curlPost($url, $body) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Login-Token:eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdGFmZiI6IntcImlkXCI6MSxcInVzZXJuYW1lXCI6XCJhZG1pblwiLFwicGFzc3dvcmRcIjpcImExMjM0NTYuLi5hXCIsXCJuaWNrbmFtZVwiOlwi6LaF566hXCIsXCJjcmVhdGVUaW1lXCI6MTU5Mjc0OTI1OTAwMCxcImFkbWluXCI6dHJ1ZSxcInJvbGVJZFwiOjUsXCJkZXB0XCI6bnVsbCxcImNvbXBhbnlcIjpudWxsLFwic3lzXCI6ZmFsc2V9IiwicGVybWlzc2lvbiI6IntcInJvbGVJZFwiOjUsXCJhZG1pblwiOnRydWUsXCJwMFwiOnRydWUsXCJwMVwiOnRydWUsXCJwMlwiOnRydWUsXCJwM1wiOnRydWUsXCJwNFwiOnRydWUsXCJwNVwiOnRydWUsXCJwNlwiOnRydWUsXCJwN1wiOnRydWUsXCJwOFwiOnRydWUsXCJwOVwiOnRydWUsXCJwMTBcIjp0cnVlLFwicDExXCI6dHJ1ZSxcInAxMlwiOnRydWUsXCJwMTNcIjp0cnVlLFwicDE0XCI6dHJ1ZSxcInAxNVwiOnRydWUsXCJwMTZcIjp0cnVlLFwicDE3XCI6dHJ1ZSxcInAxOFwiOnRydWUsXCJwMTlcIjp0cnVlLFwicDIwXCI6dHJ1ZSxcInAyMVwiOnRydWUsXCJwMjJcIjp0cnVlLFwicDIzXCI6dHJ1ZSxcInAyNFwiOnRydWUsXCJwMjVcIjp0cnVlLFwicDI2XCI6dHJ1ZSxcInAyN1wiOnRydWUsXCJwMjhcIjp0cnVlLFwicDI5XCI6dHJ1ZSxcInAzMFwiOnRydWUsXCJwMzFcIjp0cnVlLFwicDMyXCI6dHJ1ZSxcInAzM1wiOnRydWUsXCJwMzRcIjpmYWxzZSxcInAzNVwiOmZhbHNlLFwicDM2XCI6ZmFsc2UsXCJwMzdcIjpmYWxzZSxcInAzOFwiOmZhbHNlLFwicDM5XCI6ZmFsc2UsXCJwNDBcIjpmYWxzZSxcInA0MVwiOmZhbHNlLFwicDQyXCI6ZmFsc2V9IiwiZXhwIjoxNjY1ODE3Mjk3LCJpYXQiOjE2NjMyMjUyOTd9.O5GVC5krVcMjZOlH40sbvhEHHxdZnKo_G0AbwFofx9k'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res=curl_exec($ch);
    curl_close($ch);

// curl_setopt($ch,CURLOPT_COOKIESESSION,true);
// $cookFile=dirname(__FILE__).'/cookie'.$quid.'.temp';
// curl_setopt($ch,CURLOPT_COOKIEFILE,$cookFile);
// curl_setopt($ch,CURLOPT_COOKIEJAR,$cookFile);
// curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
    return $res;
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
    curl_close($ch);
    $return=json_decode($output,true);
    if($return["status"]==200){
        return 'Thành công';
    }else{
        return '失败:'.$return["data"];
    }
}


//查询用户是否存在
function get_user_info($host,$db,$pwd,$dbname,$uid,$quname){
    $con = @mysqli_connect($host, $db, $pwd) or die(mysql_error());
    mysqli_query($con,"set names 'utf8'");
    mysqli_select_db($con,$dbname);
    $sql = "SELECT * FROM `account` where  `username` = '$uid' limit 1";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    $playerId = $row['uid'];
    if ($playerId == '') {
       notiG100K(0,"Tài Khoản $uid Không Tồn Tại","error");
    }
    return $playerId;
}

function file_log($str,$log_file){
    $time = date('Y-m-d H:i:s');
    $log_str = $time.'|'.$str."\n";
    file_put_contents($log_file,$log_str,FILE_APPEND);
}

//发送充值的用户
function send_charge($host,$db,$pwd,$dbname,$playerId,$chargetype,$chargenum,$s){
    $con = @mysqli_connect($host, $db, $pwd) or die(mysql_error());
    mysqli_query($con,"set names 'utf8'");
    mysqli_select_db($con,$dbname);
    $sql_master = "SELECT * FROM `account_master` where  `account_uid` = '$playerId' AND `srv_code` = '{$s}' limit 1";
    $result_master = mysqli_query($con,$sql_master);
    $row_master = mysqli_fetch_array($result_master);
    $playername = $row_master['master_name'];
    $master_id_hex = $row_master['master_id_hex'];
    $rand_platform = time().rand(1,9999);

    $sql_item = "SELECT * FROM `charge_item` where  `pay_id` = '$chargetype' limit 1";
    $result_item = mysqli_query($con,$sql_item);
    $row_item = mysqli_fetch_array($result_item);
    $itmename = $row_item['pay_name'];
    $item_amount = $row_item['pay_amount'];
    $date = date("Y-m-d H:i:s");
    $sql_insert = "INSERT INTO `pay_approval`(`order_type`, `status`, `platform_order_id`, `item_tid`, `item_count`, `item_name`, `pay_amount`, `srv_code`, `platform_code`, `channel_code`, `platform_open_id`, `account_uid`, `master_id_hex`, `master_name`, `submit_username`, `submit_nickname`, `submit_time`, `approve_username`, `approve_nickname`, `approve_time`, `currency_code`) VALUES (3, 1, $rand_platform, $chargetype, $chargenum, '$itmename','$item_amount', '$s', 'develop', NULL, '', '$playerId', '$master_id_hex', '$playername', 'admin', '超管', '$date', NULL, NULL,NULL , 'CNY')";
    mysqli_query($con,$sql_insert);
    $res_id = mysqli_insert_id($con);
    $url = "{$host}:9999/gm/pay/completeApproval";
    $bodys['status'] = 2;
    $bodys['id'] = $res_id;
    $body = json_encode($bodys);
    $result = curlPost($url, $body);
    mysqli_close($con);


    $log_str = '成功给'.$s.'区的玩家『' . $playername . '』充值【' . $itmename . '】成功';
    $log_file_url = './log/充值'.date('Y-m-d').'.log';
    file_log($log_str,$log_file_url);
    
    exit($log_str);
}

//发送给邮件用户
function send_email($host,$db,$pwd,$dbname,$playerId,$title,$content,$reward,$s){
    $con = @mysqli_connect($host, $db, $pwd) or die(mysql_error());
    mysqli_query($con,"set names 'utf8'");
    mysqli_select_db($con,$dbname);
    $sql_master = "SELECT * FROM `account_master` where  `account_uid` = '$playerId' AND `srv_code` = '{$s}' limit 1";
    $result_master = mysqli_query($con,$sql_master);
    $row_master = mysqli_fetch_array($result_master);
    $playername = $row_master['master_name'];
    $master_id_hex = $row_master['master_id_hex'];
    $date = date("Y-m-d H:i:s");
    $sql_insert = "INSERT INTO `gm_mail_approval`(`type`,`title`,`content`,`reward`,`operation`, `status`,  `submit_username`, `submit_nickname`, `submit_time`, `approve_username`, `approve_nickname`, `approve_time`, `invalid_time`,`schedule_time`,`mail_type`) VALUES (2, '$title', '$content', '$reward', 12, 1, 'admin', '超管', '$date', NULL,NULL,NULL,NULL,NULL,0)";
    $res = mysqli_query($con,$sql_insert);
    $res_id = mysqli_insert_id($con);
    if($res){
        $sql_inserts = "INSERT INTO `gm_mail_tar`(`mail_id`,`type`,`srv_code`,`master_id_hex`,`name`, `platform_code`) VALUES ('$res_id', 2, '$s', '$master_id_hex', '$playername', 'develop')";
        mysqli_query($con,$sql_inserts);
    }

    $url = "{$host}:9999/gm/mail/x/complete";
    $bodys['status'] = 2;
    $bodys['id'] = $res_id;
    $body = json_encode($bodys);
    $result = curlPost($url, $body);
    mysqli_close($con);
    
    //$code = substr($reward,0,strrpos($reward ,":"));
    //$codeList = get_wp_item();
    //$item_name = '';
    //foreach($codeList as $k=>$v){
    //    if($k == $code){
    //        $item_name = $v;
    //    }
    //}
    
    //$log_str = '成功给'.$s.'区的玩家『' . $playername . '』发送道具【'.$item_name.'】成功';
    //$log_file_url = './log/用户邮件'.date('Y-m-d').'.log';
    //file_log($log_str,$log_file_url);
    
    return($result);
}

//发送给全服的玩家
function send_all_email($host,$db,$pwd,$dbname,$title,$content,$reward,$servername,$s){
    $con = @mysqli_connect($host, $db, $pwd) or die(mysql_error());
    mysqli_query($con,"set names 'utf8'");
    mysqli_select_db($con,$dbname);
    $date = date("Y-m-d H:i:s");
    $sql_insert = "INSERT INTO `gm_mail_approval`(`type`,`title`,`content`,`reward`,`operation`, `status`,  `submit_username`, `submit_nickname`, `submit_time`, `approve_username`, `approve_nickname`, `approve_time`, `invalid_time`,`schedule_time`,`mail_type`) VALUES (1, '$title', '$content', '$reward', 12, 1, 'admin', '超管', '$date', NULL,NULL,NULL,NULL,NULL,0)";
    $res = mysqli_query($con,$sql_insert);
    $res_id = mysqli_insert_id($con);
    if($res){
        $sql_inserts = "INSERT INTO `gm_mail_tar`(`mail_id`,`type`,`srv_code`,`master_id_hex`,`name`, `platform_code`) VALUES ('$res_id', 2, '$s', '', '$servername', 'develop')";
        mysqli_query($con,$sql_inserts);
    }

    $url = "{$host}:9999/gm/mail/x/complete";
    $bodys['status'] = 2;
    $bodys['id'] = $res_id;
    $body = json_encode($bodys);
    $result = curlPost($url, $body);
    mysqli_close($con);
    
    $code = substr($reward,0,strrpos($reward ,":"));
    $codeList = get_wp_item();
    $item_name = '';
    foreach($codeList as $k=>$v){
        if($k == $code){
            $item_name = $v;
        }
    }
    
    $log_str = '成功给'.$s.'区的所有玩家发送道具【'.$item_name.'】成功';
    $log_file_url = './log/区服'.date('Y-m-d').'.log';
    file_log($log_str,$log_file_url);
    
    exit($log_str);
}
?>