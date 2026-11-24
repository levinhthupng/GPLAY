<?php
error_reporting(0);
function notiG100K($status, $msg, $type) {
    $json = [
        'status' => $status,
        'msg' => $msg,
        'type' => $type
    ];
    exit(json_encode($json));
}
$type = $_POST['type'];
$usr = $_POST['uid'];
$bao = $_POST['chargenum'];
$item = $_POST['mailid'];
$num = $_POST['mailnum'];
$task = $_POST['task'];
$usr == "" && (notiG100K(0, "Chưa Nhập Tên Tài Khoản !", "error"));
$mysql = mysqli_connect("157.245.205.167","hk20","12082001Lvt","server_4001",3306) or notiG100K(0, "Server Bảo Trì1 !", "error");
$xx = mysqli_fetch_assoc($mysql->query("SELECT delete_mark,userid,player_id FROM t_u_player WHERE account = '$usr' limit 1"));
$xx['userid'] == "" && (notiG100K(0, "Tài Khoản Không Tồn Tại !", "error"));
$acc = $xx['userid'];
$uid = $xx['player_id'];
$activate =  $xx['delete_mark'];
//$vip = $xx['vip'];
$cookie_file = dirname(__FILE__).'/igzs.txt';
$ch = curl_init();  
curl_setopt($ch, CURLOPT_URL, "http://157.245.205.167:8080/zjh/login.do");  
curl_setopt($ch, CURLOPT_POST, true);  
curl_setopt($ch, CURLOPT_POSTFIELDS,"userName=admin&pwd=loulxgame123");  
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR,$cookie_file);
curl_exec($ch);
curl_close($ch);
$qu = "5001";
//notiG100K(0, "Tài Khoản Không Tồn Tại adasd!", "error");
if($type=="charge"){
    //$vip != 0 && (die('Người dùng không phải là VIP không thể sử dụng được'));
    $bao == "" && (notiG100K(0, "Chưa Chọn Gói Nạp Free!", "success"));
    $data = "serverId={$qu}&mailInfo.title=G100k-TOOLS-FREE&mailInfo.outline=G100k-TOOLS-FREE&mailInfo.startTime=&mailInfo.endTime=&mailInfo.content=G100k-TOOLS-FREE&target={$uid}&mailInfo.attach=1,{$bao},1&fileAttach=";
	$ret = postData("http://157.245.205.167:8080/zjh/send_mail_to_player.do", $data,$cookie_file);
	notiG100K(0, "Nạp Free Thành Công!", "success");
}elseif($type=="mail"){
    //$vip != 0 && (die('Người dùng không phải là VIP không thể sử dụng được'));
	$find=false;
	$file = fopen("item.txt", "r");
	while(!feof($file)){
		$line=fgets($file);
		$txts=explode('|',$line);
		if(trim($txts[0]) == trim($item)){
			$find=true;
			break;
		}		  
	}
	fclose($file);
	if($find==false){die(notiG100K(0, "Vật Phẩm Không Tồn Tại!", "error"));}
	$its = explode('_',$item,2);
	$num == '' && ($num = 1);
	if($its[0] > 0){
		$num > 999 && ($num = 999);
		$items = "1,{$its[1]},{$num}";
	}else{
		$num > 9999 && ($num = 9999);
		$items = "{$its[1]},0,{$num}";
	}
	if ($activate == 1) {
    $data = "serverId={$qu}&mailInfo.title=G100k-TOOLS-VIPS&mailInfo.outline=G100k-TOOLS-VIPS&mailInfo.startTime=&mailInfo.endTime=&mailInfo.content=G100k-TOOLS-VIPS&target={$uid}&mailInfo.attach={$items}&fileAttach=";
	$ret = postData("http://157.245.205.167:8080/zjh/send_mail_to_player.do", $data,$cookie_file);
	notiG100K(0, "Gửi Vật Phẩm Thành Công!", "success");
	} else {
	    notiG100K(0, "Chưa Mua Tools!", "error");
	}
}elseif($type==3){
	//echo($acc);
	$data = "serverId={$qu}&userid={$acc}";
	$ret = postData("http://157.245.205.167:8080/zjh/kick_player.do", $data,$cookie_file);
	//echo($ret);
	if($ret){
		if($mysql->query("DELETE FROM t_u_goods_pack WHERE player_id = {$uid};")){
			die("Dọn dẹp túi nhân vật thành công và bạn có thể đăng nhập sau 5 phút");
		}else{
		    die('Dọn dẹp không thành công, hãy liên hệ với quản trị viên của bạn');
 		}
	}else{
		die('Dọn dẹp không thành công, hãy liên hệ với quản trị viên của bạn');
	}
	

}


function postData($url, $data,$cookie_file)  {  
    $ch = curl_init();  
    $timeout = 300;   
    curl_setopt($ch, CURLOPT_URL, $url);  
    curl_setopt($ch, CURLOPT_POST, true);  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch ,CURLOPT_COOKIEFILE,$cookie_file);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    $handles = curl_exec($ch);  
    curl_close($ch);  
    return $handles;  
}
?>