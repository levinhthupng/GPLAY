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
$usr = $_POST['acc'];
$bao = $_POST['bao'];
$item = $_POST['item'];
$num = $_POST['num'];
$task = $_POST['task'];
$usr == "" && (notiG100K(0,"Chưa Nhập Tên Tài Khoản!","warning"));
$mysql = mysqli_connect("165.22.108.172","hk20","12082001Lvt","jhhd_s1",3306) or notiG100K(0,"Cơ sở dữ liệu được kết nối không chính xác!","error");
$xx = mysqli_fetch_assoc($mysql->query("SELECT userid,player_id,delete_mark FROM t_u_player WHERE account = '$usr' limit 1"));
if($xx['userid'] == "") {
    notiG100K(0,"Tài Khoản Không Tồn Tại!","error");;
}
$acc = $xx['userid'];
$uid = $xx['player_id'];
$activate = $xx['delete_mark'];
//$vip = $xx['vip'];
$cookie_file = dirname(__FILE__).'/igzs.txt';
$ch = curl_init();  
curl_setopt($ch, CURLOPT_URL, "http://165.22.108.172:8080/zjh/login.do");  
curl_setopt($ch, CURLOPT_POST, true);  
curl_setopt($ch, CURLOPT_POSTFIELDS,"userName=admin&pwd=loulxgame123");  
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR,$cookie_file);
curl_exec($ch);
curl_close($ch);
$qu = "4001";
if($type==1){
	
    //$vip != 0 && (die('Người dùng không phải là VIP không thể sử dụng được'));
    $bao == "" && (notiG100K(0,"Chưa Chọn Gói Nạp!","error"));
    $data = "serverId={$qu}&mailInfo.title=GM&mailInfo.outline=GM&mailInfo.startTime=&mailInfo.endTime=&mailInfo.content=mail&target={$uid}&mailInfo.attach=1,{$bao},1&fileAttach=";
	$ret = postData("http://165.22.108.172:8080/zjh/send_mail_to_player.do", $data,$cookie_file);
	notiG100K(0,"Nạp Free Thành Công!","success");
	
}elseif($type==2){
	if($activate == 1) {
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
	if($find==false){notiG100K(0,"Vật Phẩm Không Tồn Tại!","error");}
	$its = explode('_',$item,2);
	$num == '' && ($num = 1);
	if($its[0] > 0){
		$num > 999 && ($num = 999);
		$items = "1,{$its[1]},{$num}";
	}else{
		$num > 9999 && ($num = 9999);
		$items = "{$its[1]},0,{$num}";
	}
    $data = "serverId={$qu}&mailInfo.title=G100K-TOOLSVIP&mailInfo.outline=G100K-TOOLSVIP&mailInfo.startTime=&mailInfo.endTime=&mailInfo.content=mail&target={$uid}&mailInfo.attach={$items}&fileAttach=";
	$ret = postData("http://165.22.108.172:8080/zjh/send_mail_to_player.do", $data,$cookie_file);
	notiG100K(0,"Gửi Vật Phẩm Thành Công!","success");
} else {
    notiG100K(0,"Tài Khoản Chưa Mua Toosl!","warning");
}
}elseif($type==3){
	//echo($acc);
	$data = "serverId={$qu}&userid={$acc}";
	$ret = postData("http://165.22.108.172:8080/zjh/kick_player.do", $data,$cookie_file);
	//echo($ret);
	if($ret){
		if($mysql->query("DELETE FROM t_u_goods_pack WHERE player_id = {$uid};")){
			notiG100K(0,"Xóa Thành Công!","success");
		}else{
		    notiG100K(0,"Thoát Game Trước Khi Xóa!","warning");
 		}
	}else{
		notiG100K(0,"Xóa Thất Bại!","danger");
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