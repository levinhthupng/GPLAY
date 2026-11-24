<?php
header('Content-Type: text/html; cahrset=utf8');
ini_set('date.timezone','Asia/Shanghai');
//========================================================================
$key='//Powered by山城(QQ692000321) 可加后台研究群号：754404107  勿删';
//========================================================================
/*
	 GM管理地址  http://域名或IP/gm/gm.php
	 GM码请修改 20行
	 玩家地址    http://域名或IP/gm/
*/
//error_reporting(0);
$htname = '一剑问情';
$YZF_CONFIG = array(	
		"gmcode" => "123123",             //GM码
		"db_host" => "157.245.207.28",          //数据库IP
		"db_username" => "hk20",			//数据库帐号
		"db_password" => "12082001Lvt",		//数据库密码
		"dbport" => 3306,
		"url"=>"http://157.245.207.28:8090", //运营后台地址
		"admin"	=>"admin",    //运营后台账号 
		"password"	=>"123456",    //运营后台密码  
		"gmkey"	=>"1a88373f7ab2ec0800401064c67e1651",
		"title"	=>"G100K.NET - GM TOOLS",     
		"content"	=>"G100K.NET - GM TOOLS",
		"sa" => "%E7%89%88%E6%9C%AC Powered by %E5%B1%B1%E5%9F%8E %E5%8B%BF%E6%94%B9",
//==============by    山城    QQ692000321==========================
/**
 * 分区
 */
	 "1" => array (
			  "name"=>"S1-G100K",
			  "dbgame"=>"s1",
			  "hidde"=>false,
			 ),
	 "2" => array (
			  "name"=>"S1-G100K",
			  "dbname"=>"s2",
			  "hidde"=>false,
			 ),

);
$con = @mysqli_connect($YZF_CONFIG['db_host'],$YZF_CONFIG['db_username'],$YZF_CONFIG['db_password'],$YZF_CONFIG['dbport']);	
$user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];	
$eff = urldecode($YZF_CONFIG['sa']);
$typearr = array('quxiao','addvip1','addvip2','charge','mail','fenghao','jiefeng','jinyan','unjinyan','clearbag','allmail');
$typearrplayer = array('charge','daoju');
function poststr($str)
{
 if (isset($_POST[$str])) {
  return $_POST[$str];
 }
 die("this link server do not exist");
}
?>