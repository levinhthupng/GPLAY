<?php
/**
 *==============================
 QQ:692000321 by 山城
 *==============================
 */
include 'config.php';
function notiG100K($status, $msg, $type) {
    $json = [
        'status' => $status,
        'msg' => $msg,
        'type' => $type
    ];
    exit(json_encode($json));
}
if (!$_POST) {
 notiG100K(0,"Chưa Chọn Chức Năng!","error");
}
$checknum = '123123';
$quid     = trim(poststr('qu'));
$name      = trim(poststr('uid'));
if ($quid < 1) {
  notiG100K(0,"Chưa Chọn Server!","error");
}
if ($name == '') {
  notiG100K(0,"Chưa Nhập Tên Nhân Vật Hoặc UID!","error");
}
$qu = $YZF_CONFIG[$quid];
$dbip = $YZF_CONFIG['db_host'];
$dbuser = $YZF_CONFIG['db_username'];
$dbpwd = $YZF_CONFIG['db_password'];
$dbname = $qu['dbgame'];
$con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0,"Server Bảo Trì!","error");
mysqli_query("set names 'utf8'");
mysqli_select_db($dbname, $con);
$sql= "SELECT * FROM `$dbname`.`player` WHERE name = '{$name}' or id = '{$name}' limit 1";
$result = mysqli_query($con,$sql);
if($result&&mysqli_num_rows($result)>0){
$row = mysqli_fetch_array($result);
}
//mysqli_close($con);
$uid    = $row['id'];		
$activate = $row['activate'];
$username    = $row['username'];
$server_id    = $row['server_id'];
if (empty($uid)){
			 notiG100K(0,"Nhân Vật Không Tồn Tại !!!","error");
		   }
$sql2 = "SELECT * FROM `center`.`player_white_center` WHERE player_id = '{$uid}'";
$result2 = mysqli_query($con,$sql2);
if($result2&&mysqli_num_rows($result2)>0){
$row2 = mysqli_fetch_array($result2);
}

if(empty($row2['player_id'])){
    $sql3= "INSERT INTO `center`.`player_white_center` (`player_id`, `player_name`, `zone_id`, `server_id`, `server_name`, `w_status`, `remark`, `c_time`) VALUES ('{$row['id']}', '{$row['name']}', '{$row['server_id']}', '{$row['server_id']}', (SELECT name  FROM `center`.`server`  WHERE zone_id = '{$row['server_id']}'), '1', '', NOW());";
	$result3 = mysqli_query($con,$sql3);
	//$result3 = mysqli_query("INSERT INTO `jtyl_center`.`player_white_center` (`player_id`, `player_name`, `zone_id`, `server_id`, `server_name`, `w_status`, `remark`, `c_time`) VALUES ('{$row['id']}', '{$row['name']}', '{$row['server_id']}', '{$row['server_id']}', (SELECT name  FROM `jtyl_center`.`server`  WHERE zone_id = '{$row['server_id']}'), '1', '', NOW());");
}
		   
 // notiG100K(0,$sql3,"error");		   
if (!in_array($_POST['type'], $typearr)) {
  notiG100K(0,"Chức Năng Không Tồn Tại !!!","error");
}
//echo md5($key);
if(md5($key)==$YZF_CONFIG['gmkey']){ 
if($checknum==$YZF_CONFIG['gmcode']){
 if ($quid >= 1 || $quid != '') {	
$ch=curl_init();
$Ldate='username='.$YZF_CONFIG['admin'].'&password='.$YZF_CONFIG['password'].'&remember=on';
$header=array('Content-Type: application/x-www-form-urlencoded');
curl_setopt($ch,CURLOPT_URL,$YZF_CONFIG['url'].'/admin/login.do');curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS,$Ldate);
curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
curl_setopt($ch,CURLOPT_COOKIESESSION,true);
$cookFile=dirname(__FILE__).'/cook.txt';
curl_setopt($ch,CURLOPT_COOKIEFILE,$cookFile);
curl_setopt($ch,CURLOPT_COOKIEJAR,$cookFile);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
$res=curl_exec($ch);
 $type = trim($_POST['type']);
 switch ($type) {
		  //充值
		case 'clearbag':
                            $sql1 = "DELETE FROM `$dbname`.`item` where `position`= '$uid'";
                            $sql2 = "DELETE FROM `$dbname`.`pet` where `player_id`= '$uid'";
                            $sql3 = "DELETE FROM `$dbname`.`pet_battle` where `player_id`= '$uid'";
                            $sql4 = "DELETE FROM `$dbname`.`pet_buy_record` where `player_id`= '$uid'";
                            $sql5 = "DELETE FROM `$dbname`.`pet_chou_active` where `player_id`= '$uid'";
                            $sql6 = "DELETE FROM `$dbname`.`pet_ext_attr` where `player_id`= '$uid'";
                            $sql7 = "DELETE FROM `$dbname`.`pet_law` where `player_id`= '$uid'";
                            $sql8 = "DELETE FROM `$dbname`.`pet_law_attr` where `player_id`= '$uid'";
                            $sql9 = "DELETE FROM `$dbname`.`pet_skill` WHERE `player_id` = '$uid'";
                            $resultclear1 = mysqli_query($con,$sql1);
                            $resultclear2 = mysqli_query($con,$sql2);
                            $resultclear3 = mysqli_query($con,$sql3);
                            $resultclear4 = mysqli_query($con,$sql4);
                            $resultclear5 = mysqli_query($con,$sql5);
                            $resultclear6 = mysqli_query($con,$sql6);
                            $resultclear7 = mysqli_query($con,$sql7);
                            $resultclear8 = mysqli_query($con,$sql8);
                            $resultclear9 = mysqli_query($con,$sql9);
                            if($resultclear1){
									notiG100K(0,"Xóa Balo Thành Công!","success");
								}else{
									notiG100K(0,"Xóa Balo Thất Bại !","error");
								}
                            mysqli_close($con);
                            break;  
		  
	   case 'charge':
			mysqli_close($con);
			$chargeid = trim($_POST['chargetype']);	
			
			$find = false;
            $file = fopen("charge.txt", "r");
                            while (!feof($file)) {
                                $line = fgets($file);
                                $txts = explode(';', $line);
                                if ($txts[0] == $chargeid) {
                                    $find = true;
                                }
                            }
                            fclose($file);
                            if ($find == false) {
                                notiG100K(0,"Vật Phẩm Không Tồn tại!","error");
                            }
			//notiG100K(0,"Vật Phẩm Không Tồn Tại","error");
			$postdata='server_id='.$server_id.'&player_id='.$uid.'&recharge_id='.$chargeid;
			//notiG100K(0,$postdata,"error");
			curl_setopt($ch,CURLOPT_URL,$YZF_CONFIG['url'].'/admin/gm/recharge_increase.do');
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
			$ret=curl_exec($ch);
			curl_close($ch);				 
			if ($ret[1] == 0) {
			//$log='../log/charge_'.date('Y-m-d').'.log';	
			//file_put_contents($log,$date."\t".$server_id."\t"."区 玩家".$name."\t".$chargeid."\t"."充值成功\t".$user_IP.PHP_EOL,FILE_APPEND);
			notiG100K(0,"Nạp Free Thành Công","success");
			} else {
			notiG100K(0,"Nạp Tiền Thất Bại","error");
			}
			break;
				   	   
				   
  //发送邮件
		case 'mail':
			mysqli_close($con);
			$mailid    = poststr('mailid');
			$itemnum = poststr('mailnum');
			// 分割字符串
			if ($mailid == '') {
				notiG100K(0,"Chưa Chọn Vật Phẩm!","error");
			}
			if ($itemnum == '') {
				notiG100K(0,"Chưa Nhập Số Lượng!","error");
			}
			$find = false;
			$file = fopen("item.txt", "r");
			while (!feof($file)) {
				$line = fgets($file);
				$txts = explode(';', $line);
				if ($txts[0] == $mailid) {
					$find = true;
					break;
				}
			}
			fclose($file);
			if ($find == false) {
				 notiG100K(0,"Vật Phẩm Không Tồn tại!","error");
			}
			if ($activate == 1) {
			$postdata = 'sp1=1&server_id='.$server_id.'&player_id='.$uid.'&title='.$YZF_CONFIG['title'].'&content='.$YZF_CONFIG['content'].'&sp1_id='.$mailid.'&sp1_num='.$itemnum;
			curl_setopt($ch,CURLOPT_URL,$YZF_CONFIG['url'].'/admin/mail/send_player_id.do');
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
			$ret=curl_exec($ch);
			curl_close($ch);				 
			if ($ret[1] == 0) {
			//$log='../log/mail_'.date('Y-m-d').'.log';	
			//file_put_contents($log,$date."\t".$server_id."\t"."区 玩家".$name."\t物品ID:".$mailid."\t数量:".$itemnum."\t"."邮件发送成功\t".$user_IP.PHP_EOL,FILE_APPEND);
			notiG100K(0,"Gửi Mail Thành Công","success");
			} else {
			notiG100K(0,"Gửi Mail Thất Bại","error");
			}
			} else {
			    notiG100K(0,"Chưa Mua Tools","info");
			}
			break;
	//发送邮件
		case 'allmail':
			mysqli_close($con);
			$mailid = poststr('item');
			$itemnum = poststr('num');
			$level = poststr('level');
			$stime = poststr('stime');
			$etime = poststr('etime');
			$title = poststr('title');
			$content = poststr('content');
			// 分割字符串
			if ($mailid == '') {
				exit('请选择物品！！');
			}
			if ($itemnum == '') {
				exit('请输入数量!');
			}
			$find = false;
			$file = fopen("../item.txt", "r");
			while (!feof($file)) {
				$line = fgets($file);
				$txts = explode(';', $line);
				if ($txts[0] == $mailid) {
					$find = true;
					break;
				}
			}
			fclose($file);
			if ($find == false) {
				exit('物品ID不存在');
			}
			$postdata = 'sp1=1&server_id='.$server_id.'&title='.$title.'&content='.$content.'&level='.$level.'&start_time='.$stime.'&end_time='.$etime.'&sp1_id='.$mailid.'&sp1_num='.$itemnum;
			curl_setopt($ch,CURLOPT_URL,$YZF_CONFIG['url'].'/admin/mail/send_all.do');
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
			$ret=curl_exec($ch);
			curl_close($ch);				 
			if ($ret[1] == 0) {
			$log='../log/allmail_'.date('Y-m-d').'.log';	
			file_put_contents($log,$date."\t".$server_id."\t"."区 玩家".$name."\t物品ID:".$mailid."\t数量:".$itemnum."\t"."全服邮件发送成功\t".$user_IP.PHP_EOL,FILE_APPEND);
			exit('全服邮件发送成功');
			} else {
			exit('全服邮件发送失败');
			}
			break;
		//角色封禁
		case 'fenghao':
			mysqli_close($con);
		   $fhtime = poststr('fhtime');
		   $reason   = poststr('reason');
		   $postdata = 'server_id='.$server_id.'&role_id='.$uid.'&time='.$fhtime.'&desc='.$reason;
			curl_setopt($ch,CURLOPT_URL,$YZF_CONFIG['url'].'/admin/gm/ban_role_increase.do');
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
			$ret=curl_exec($ch);
			curl_close($ch);				 
			if ($ret[1] == 0) {
			$log='../log/fenghao_'.date('Y-m-d').'.log';	
			file_put_contents($log,$date."\t".$server_id."\t"."区 玩家".$name."\封号原因:".$reason."\t时间:".$fhtime."分钟\t"."封号成功\t".$user_IP.PHP_EOL,FILE_APPEND);
			exit('封号成功');
		   } else {
			exit('封号失败！！');
		   }
		   break;
		//解封角色
		case 'jiefeng':
			$sql = "DELETE  FROM `jtyl_center`.`ban_role` WHERE `player_id` ='{$uid}' and server_id = {$server_id}";
			$result = mysqli_query($sql,$con);			
			if ($result){
			$log='../log/jiefeng_'.date('Y-m-d').'.log';	
			file_put_contents($log,$date."\t".$server_id."\t"."区 玩家".$name."\t"."解封成功\t".$user_IP.PHP_EOL,FILE_APPEND);
			exit('解封角色成功');
			} else {
			exit('解封角色失败！！');
			}
			break;

		//禁言
		case 'jinyan':
			mysqli_close($con);
			$fhtime = poststr('fhtime');
			$reason   = poststr('reason');
			$postdata = 'server_id='.$server_id.'&role_id='.$uid.'&time='.$fhtime.'&desc='.$reason;
			curl_setopt($ch,CURLOPT_URL,$YZF_CONFIG['url'].'/admin/gm/shutup.do');
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
			$ret=curl_exec($ch);
			curl_close($ch);				 
			if ($ret[1] == 0) {
			$log='../log/jinyan_'.date('Y-m-d').'.log';	
			file_put_contents($log,$date."\t".$server_id."\t"."区 玩家".$name."\禁言原因:".$reason."\t时间:".$fhtime."分钟\t"."禁言成功\t".$user_IP.PHP_EOL,FILE_APPEND);
			exit('禁言成功');
			} else {
			exit('禁言失败！！');
			}
			break;
   
   //解除禁言
		case 'unjinyan':
			$sql = "DELETE  FROM `jtyl_center`.`ban_gag` WHERE `player_id` ='{$uid}' and server_id = {$server_id}";
			$result = mysqli_query($sql,$con);			
			if ($result){
			$log='../log/unjinyan_'.date('Y-m-d').'.log';	
			file_put_contents($log,$date."\t".$server_id."\t"."区 玩家".$name."\t"."解除禁言成功\t".$user_IP.PHP_EOL,FILE_APPEND);
			exit('解除禁言成功');
			} else {
			exit('解除禁言失败！！');
			}
			break;
   
  //清理背包
		case 'clearbag':
			$itemid = poststr('itemid');
			$itemnum  = poststr('itemnum');		
			$postdata = 'server_id='.$server_id.'&role_id='.$uid.'&item_type='.$itemid.'&item_num='.$itemnum;
			curl_setopt($ch,CURLOPT_URL,$YZF_CONFIG['url'].'/admin/gm/dec_res.do');
			curl_setopt($ch,CURLOPT_POSTFIELDS,$postdata);
			$ret=curl_exec($ch);
			curl_close($ch);				 
			if ($ret[1] == 0) {
			$log='../log/clearbag_'.date('Y-m-d').'.log';	
			file_put_contents($log,$date."\t".$server_id."\t"."区 玩家".$name."\物品ID:".$itemid."\t数量:".$itemnum."\t"."清理物品成功\t".$user_IP.PHP_EOL,FILE_APPEND);
			exit('清理成功');
			} else {
			exit('清理失败');
			}
			break;
			case 'quxiao':
                $vipfile='QQ692000321_'.$quid.'.json';
				$vipfile = iconv('UTF-8', 'GB18030', $vipfile);
				$fp = fopen($vipfile,"a+");
				if(filesize($vipfile)>0){
					$str = fread($fp,filesize($vipfile));
					fclose($fp);
					$vipjson=json_decode($str,true);
					if($vipjson==null){
						$vipjson=array();
					}
				}else{
					$vipjson=array();
				}
				if($vipjson[$uid]){
					unset($vipjson[$uid]);
					file_put_contents($vipfile,json_encode($vipjson));
               exit('取消成功');
				}else{
               exit('此id未授权了');
				}
				break;
			case 'addvip1':
				$pswd=trim($_POST['pswd']);
				if($pswd==''){
               exit('后台密码不能为空');
				}
                $vipfile='QQ692000321_'.$quid.'.json';
				$vipfile = iconv('UTF-8', 'GB18030', $vipfile);
				$fp = fopen($vipfile,"a+");
				if(filesize($vipfile)>0){
					$str = fread($fp,filesize($vipfile));
					fclose($fp);
					$vipjson=json_decode($str,true);
					if($vipjson==null){
						$vipjson=array();
					}
				}else{
					$vipjson=array();
				}
				if(!$vipjson[$uid]){
					$vipjson[$uid]=array('pswd'=>$pswd,'level'=>0);
					file_put_contents($vipfile,json_encode($vipjson));
               exit('充值权限开通成功');
				}else{
               exit('该角色已经是最高权限了');
				}
				break;
			case 'addvip2':
				$pswd=trim($_POST['pswd']);
				if($pswd==''){
               exit('后台密码不能为空');
				}
                $vipfile='QQ692000321_'.$quid.'.json';
				$vipfile = iconv('UTF-8', 'GB18030', $vipfile);
				$fp = fopen($vipfile,"a+");
				if(filesize($vipfile)>0){
					$str = fread($fp,filesize($vipfile));
					fclose($fp);
					$vipjson=json_decode($str,true);
					if($vipjson==null){
						$vipjson=array();
					}
				}else{
					$vipjson=array();
				}
				if(!$vipjson[$uid] || intval($vipjson[$uid]['level']==0)){
					$vipjson[$uid]=array('pswd'=>$pswd,'level'=>1);
					file_put_contents($vipfile,json_encode($vipjson));
               exit('全功能权限开通成功');
				}else{
               exit('该角色已经是最高权限了');
				}
				break;  
  default:
   exit('系统异常，请重试!');
   break;
}
}else{
          exit('区号错误');
}
}else{
		  exit('GM码错误!');
}
}else{
		exit($eff);
}
?>