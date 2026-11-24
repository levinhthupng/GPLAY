<?php
session_start(); 
function notiG100K($status, $msg, $type) {
    $json = [
        'status' => $status,
        'msg' => $msg,
        'type' => $type
    ];
    exit(json_encode($json));
}
$qu = $_POST['qu'];
$usr = $_POST['uid'];
$pay = $_POST['pay'];
$bao = $_POST['chargetype'];
$num = $_POST['mailnum'];
$num1 = $_POST['chargenum'];
$xgb=  $_POST['gb'];
$item = $_POST['mailid'];
$gnxz = $_POST['type'];
$qu == 0 && (notiG100K(0, "Chưa Chọn Server !", "error"));
$usr =='' && (notiG100K(0, "Chưa Nhập Tên Tài Khoản!", "error"));
include "config.php";
$mysql = mysqli_connect($PZ['DB_HOST'],$PZ['DB_USER'],$PZ['DB_PWD'],$d_ssdb,$PZ['DB_PORT']) or notiG100K(0, "Server Đã Đóng !", "error");
$mysql->query('set names utf8');
$xx = mysqli_fetch_assoc($mysql->query("SELECT rid,vip FROM role WHERE account = '$usr' limit 1"));
$xx['rid'] =='' && (notiG100K(0, "Tài Khoản ".$usr." Không Tồn Tại !", "error"));
$activate = $xx['vip'];
$rid = $xx['rid'];$TS = Order_id();$DD = "GZ{$TS}";
if($gnxz==1){
    $pay =='' && (die('请输入充值金额'));
    $ext = array('pay_channel' => "sszg",'channel' => "sszg",'package_id' => 0,'package_name' =>"钻石");
    $ret = erls('adm', 'pay', "[i, i, b, i, b, i, b, i, b]", array((int)$rid,2,$d_plat,(int)$d_zone,$DD,(int)$pay,'CNY',1,json_encode($ext)),$d_plat,$d_keys,$d_port);
    print_r($ret['message']);die;
}elseif($gnxz=="charge"){
    //notiG100K(0, $bao, "error");
    $bao =='0' && (notiG100K(0, "Chưa Chọn Vật Phẩm !", "error"));
	$num1 =='' && ($num1 = 1); 
	$num1 > 999999999 && ($num1 = 999999999);
	$info  = array($d_plat, (int)$d_zone, (int)$rid, (int)$bao, 1, (int)$num1);
    $ret = erls('adm', 'adm_assets_as', "[b,i,i,i,i,i]",$info,$d_plat,$d_keys,$d_port);
    if($ret['message']== "角色不在线") {
         notiG100K(0, "Nhân Vật Không Online", "error");
    } else {
         notiG100K(0, "Gửi Thành Công", "success");
    }
}elseif($gnxz=="mail"){
    if($activate == 0){
        notiG100K(0, "Chưa Mua Tools !", "error");
    }
    $item =='0' && (notiG100K(0, "Chưa Chọn Vật Phẩm !", "error"));
	$find=false;
	$file = fopen("item.txt", "r");
	while(!feof($file)){
		$line=fgets($file);
		$txts=explode(';',$line);
		if(trim($txts[0]) == trim($item)){
			$find=true;
			break;
		}		  
	}
	fclose($file);
	if($find==false){notiG100K(0, "Vật Phẩm Không Tồn Tại !", "error");}
	$num =='' && ($num = 1); 
	$num > 999999999 && ($num = 999999999);
	$info  = array($d_plat, (int)$d_zone, (int)$rid, (int)$item, 1, (int)$num);
    $ret = erls('adm', 'adm_assets_as', "[b,i,i,i,i,i]",$info,$d_plat,$d_keys,$d_port);
    if($ret['message']== "角色不在线") {
         notiG100K(0, "Nhân Vật Không Online", "error");
    } else {
         notiG100K(0, "Gửi Thành Công", "success");
    }
}elseif($gnxz==4){
    $item =='0' && (die('请选择需要删除的物品'));
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
	if($find==false){die('此物品您无权选择');}
	$num =='' && ($num = 1); 
	$num > 999999999 && ($num = 999999999);
	$info  = array($d_plat, (int)$d_zone, (int)$rid, (int)$item, 2, (int)$num);
    $ret = erls('adm', 'adm_assets_as', "[b,i,i,i,i,i]",$info,$d_plat,$d_keys,$d_port);
    print_r($ret['message']);die;
    
}elseif($gnxz==5){
	$bid=trim($_POST['bid']);
	$star=25;
	$blv=6;
	$lv=2000;
	
	$ret = erls('adm', 'set_plv', "[b,i, i, i, i, i, i]", array($d_plat,(int)$d_zone,(int)$rid,(int)$bid,(int)$star,(int)$blv,(int)$lv ),$d_plat,$d_keys,$d_port);
	
	print_r($ret['message']);die;
    
}elseif($gnxz==8){
    $xgb =='' && (die('请输入要添加的风暴币数量'));
    if($mysql->query("UPDATE role SET game_fzb = game_fzb + $xgb WHERE rid = '$rid' ;")){
		die('增加成功');
	}else{
		die('增加失败');
	}
}	
die('未选取功能');
?>