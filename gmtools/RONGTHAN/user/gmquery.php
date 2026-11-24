<?php
include 'config.php';
function notiG100K($status, $msg, $type) {
    $json = [
        'status' => $status,
        'msg' => $msg,
        'type' => $type
    ];
    exit(json_encode($json));
}
session_start();
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
$time=time();
if(abs($time-(int)$_SESSION['lasttime'])<5){
		notiG100K(0, "Tools Quá Nhanh", "info");	
}
$_SESSION['lasttime']=$time;
if($_POST){
	//include 'config.php';	
	
	$quid=trim($_POST['qu']);
	if($quid==''){
		notiG100K(0, "Chưa Chọn Server", "info");
	}
	$qu=$quarr[$quid];
	if(!$qu['db_ip']){
		notiG100K(0, "Server Không Tồn Tại", "info");
	}
//	$uid=trim($_POST['uid']);
	$uid=$_POST['uid'];
	if($uid==''){
		notiG100K(0, "Chưa Nhập Tên Nhân Vật", "info");
	}
    //$act = trim($_POST['type']);
    $act=$_POST['type'];
//$user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
//$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];	
$date=date('Y-m-d H:i:s');
$time=time();
    $conn = @mysqli_connect($qu['db_ip'], $qu['db_user'], $qu['db_pswd']);
	if(!$conn){
		notiG100K(0, "Server Bảo Trì", "warning");
	}
	
	@mysqli_query("set names utf8");	
	mysqli_select_db($conn,$qu['db_name']);
	$sql="select * from `t_player` where `name`='{$uid}' limit 1";
	$result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);
	$activate = $row['activate'];
	if($row['playerId']==''){
	    mysqli_close($conn);
		notiG100K(0, "Nhân Vật Không Tồn Tại", "error");
	}
	$playerid=$row['playerId'];
	$name=$row['name'];
	switch($act){
	    
	    case 'ClearBag':
            $sql="delete from `t_mail` where `id`='{$playerid}'";
            $result = mysqli_query($conn,$sql);
            if ($result) {
                notiG100K(0, "Xóa Thư Thành Công", "success");
            } else {
                notiG100K(0, "Xóa Thư Thất Bại", "error");
            }
            
    	    //$return=array('errcode'=>1,'info'=>$res,);
    	    
    	
    
        break;
		
			case 'charge':

        $money1 = intval($_POST['chargenum']);
		$action='recharge';
		if($money1<1){
					notiG100K(0, "Số Lượng Phải > 1", "warning");
				}	
		$data=array(
			"action"=>$action,
			"playerid"=>$playerid, 
			"productid"=>intval($money1)
		);		
		$data=json_encode($data);
		$res=post_curl($qu['gmurl'], $data);	
        notiG100K(0, "Nạp Free Thành Công", "success");
	    //$return=array('errcode'=>1,'info'=>$res,);
	    
	

    break;
			case 'mail':
				$itemid=intval($_POST['mailid']);
				$num = intval($_POST['mailnum']);
				/*if($itemid<1){
					$return=array(
						'errcode'=>1,
						'info'=>'物品ID错误',
					);
					exit(json_encode($return));
				}*/
				if(in_array($itemid,$disables)){
					notiG100K(0, "Vật Phẩm Lỗi !", "info");
				}
				if($num<1 || $num>9999){
					notiG100K(0, "Số Lượng Từ 1-9999", "warning");
				}
        $items=$itemid.'_'.$num;//多个使用,分隔
		$action='mail';
		$data=array(
			"action"=>$action,
			"playerid"=>$playerid, 
			"mail"=>array(
				"sender"=>"G100K - TOOLS VIP",
				"title"=>"G100K - TOOLS VIP",
				"content"=>"G100K - TOOLS VIP",
				"reward"=>$items
			)
		);

		$data=json_encode($data);
		if($activate == 1) {
		$res=post_curl($qu['gmurl'], $data);	

	    //$return=array('errcode'=>1,'info'=>$res,);
	    notiG100K(0, "Gửi Vật Phẩm Thành Công", "success");
		} else {
			notiG100K(0, "Chưa Mua Tools", "erroe");
		}

   break;

		default:
			notiG100K(0, "Lỗi Hệ Thống", "error");
			break;
	}
}else{
	notiG100K(0, "Lỗi Hệ Thống", "error");
}