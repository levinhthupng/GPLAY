<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Ho_Chi_Minh');
session_start();
$conn = @mysqli_connect ('159.65.6.249', 'hk20', '12082001Lvt' ) or notiG100K(0, "Server Sập3","error");
mysqli_select_db ( 'game_1', $conn );
mysqli_query ( "SET NAMES utf8" );
//Mã GM
$gmcode='g100k';
function notiG100K($status, $msg, $type) {
    $json = [
        'status' => $status,
        'msg' => $msg,
        'type' => $type
    ];
    exit(json_encode($json));
}
$quarr = array (
 '1' => array (
  'db_ip' => '159.65.6.249',
  'db_port' => 3306,
  'db_user' => 'hk20',
  'db_pswd' => '12082001Lvt',
  'db_name' => 'game_1',
  'db_name1' => 'backstage', 
  'prefix' => 'S1.',  
  'prebs' => 'sf1',    
  'url' => 'http://159.65.6.249:8666',
  "username"=>"1",//账号
  "password"=>"1",//密码
  "login_token"=>"BEdspSE3Mu",  //token
  'name'=>'S1-G100K',
  'hidde'=>false
 ),
 '2' => array (
  'db_ip' => '159.65.6.249',
  'db_port' => 3306,
  'db_user' => 'hk20',
  'db_pswd' => '12082001Lvt',
  'db_name' => 'game_2',
  'db_name1' => 'backstage',
  'prefix' => 'S2.', 
  'prebs' => 'sf2',  
  'url' => 'http://159.65.6.249:8666',
  "username"=>"1",//账号
  "password"=>"1",//密码
  "login_token"=>"BEdspSE3Mu",  //token
  'name'=>'S2',
  'hidde'=>true
 ),

);
function getmoney() {
	$payinfo = [
	  1  => [ 101 , 6, '600NB', ],
	  2  => [ 102 , 12, '1200NB', ],
	  3  => [ 103 , 30, '3000NB', ],
	  4  => [ 104 , 60, '6000NB', ],
	  5  => [ 105 , 98, '10000NB', ],
	  6  => [ 106 , 198, '20000NB', ],
	  7  => [ 107 , 488, '50000NB', ],
	  8  => [ 108 , 998, '100000NB', ],
	  9  => [ 109 , 1998, '200000NB', ],
	  10  => [ 110 , 2998, '300000NB', ],	
	  11  => [ 1 , 28, 'Thẻ tháng', ],	
	  12  => [ 2 , 88, 'Thẻ VIP Chí tôn', ],	
	  13  => [ 4 , 68, 'Chiêu Tài Miêu', ],	
	  14  => [ 5 , 30, 'Chiến Lực Hộ Phù', ],	
	  15  => [ 6 , 98, 'Vô Hạn Thủ Sáo', ],	
	  16  => [ 11 , 1, 'Lễ bao 1K', ],	
	  17  => [ 12 , 3, 'Lễ bao 3K', ],	
	  18  => [ 13 , 6, 'Lễ bao 6K', ],
	  19  => [ 14 , 8, 'Lễ bao 8K', ],	  
	  20  => [ 31 , 68, 'Tâm Linh Nguyên Thạch', ],	
	  21  => [ 32 , 68, 'Thì Gian Nguyên Thạch', ],	
	  22  => [ 33 , 68, 'Linh Hồn Nguyên Thạch', ],
	  23  => [ 34 , 68, 'Không Gian Nguyên Thạch', ],
	  24  => [ 35 , 68, 'Lực Lượng Nguyên Thạch', ],	
	  25  => [ 36 , 68, 'Hiện Thực Nguyên Thạch', ],	  
	 ];
	return $payinfo;
}
function poststr($str){
 if(isset($_POST[$str])){
  return $_POST[$str];
 }
die("this link server do not exist".$str);
}
//封装
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