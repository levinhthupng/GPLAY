<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
session_start();
//==================================================
$key='// 版本 2020 Powered by 九零一起玩 QQ9851320';
//==================================================

function getHexGuid($a){
	$r='';
	while($a){
		$r = sprintf("%02X%s",bcmod($a,256),$r);
		$a = bcdiv($a,256);
	}
	return $r;
}

function mima($data,$key) {
    $signbb = md5($data.$key);
    return $signbb;
}
//更多资源下载www.qcymw.com
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
    $_SESSION['gmbt'] ='QCYMWCOM';
	$gmbt = '精灵球';  //标题	
	$gmcodeb = 'xpymw.com';  //GM码
	$gmkey="5d4917d3f17e2c846e8fae8c811969d6";
	$sa="%e7%89%88%e6%9c%ac+2021+Powered+by+%e4%b8%ad%e5%9b%bd%e6%ba%90%e7%a0%81%e7%bd%91+QQ76891828+%e5%8b%bf%e6%94%b9";
	$disables=array();
	$vip='tlbb_';
	$ucenter='user_center';	//用户中心库
	
    $title   = 'GM';
    $content = 'GM邮件';
	$yzfvip=array(//自行修改VIP权限
	'1'=>'VIP1只充值',   
	'2'=>'VIP2充值+邮件',
	);		

			
	$quarr=array(
		'1'=>array(
			'name'=>'S1-G100K',
			'db_ip'=>'167.99.4.170',
			'db_port'=>3306,
			'gmurl'=>'http://167.99.4.170:51011/hgame/background_api',			
			'db_name'=>'h_game',
			'db_user'=>'hk20',
			'db_pswd'=>'12082001Lvt',
            'hidde'=>false
		),
      	'2'=>array(
			'name'=>'精灵球二区',
			'db_ip'=>'127.0.0.1',
			'db_port'=>3306,
			'gmurl'=>'http://127.0.0.1:51011/hgame/background_api',			
			'db_name'=>'h_game',
			'db_user'=>'root',
			'db_pswd'=>'xpymw.com',
            'hidde'=>true
		),
      	'3'=>array(
			'name'=>'苍穹三区',
			'db_ip'=>'127.0.0.1',
			'db_port'=>3306,
			'gmurl'=>'http://127.0.0.1:51011/hgame/background_api',			
			'db_name'=>'h_game',
			'db_user'=>'root',
			'db_pswd'=>'xpymw.com',
            'hidde'=>true
		),
        '4'=>array(
			'name'=>'雄霸四区',
			'db_ip'=>'127.0.0.1',
			'db_port'=>3306,
			'gmurl'=>'http://127.0.0.1:51011/hgame/background_api',			
			'db_name'=>'h_game',
			'db_user'=>'root',
			'db_pswd'=>'xpymw.com',
            'hidde'=>true
		),
        '5'=>array(
			'name'=>'中秋五区',
			'db_ip'=>'127.0.0.1',
			'db_port'=>3306,
			'gmurl'=>'http://127.0.0.1:51011/hgame/background_api',			
			'db_name'=>'h_game',
			'db_user'=>'root',
			'db_pswd'=>'xpymw.com',
            'hidde'=>true
		),    
        '6'=>array(
			'name'=>'轩辕六区',
			'db_ip'=>'127.0.0.1',
			'db_port'=>3306,
			'gmurl'=>'http://127.0.0.1:51011/hgame/background_api',			
			'db_name'=>'h_game',
			'db_user'=>'root',
			'db_pswd'=>'xpymw.com',
            'hidde'=>true
		),      
	);

	

	
include_once 'conn.php';	