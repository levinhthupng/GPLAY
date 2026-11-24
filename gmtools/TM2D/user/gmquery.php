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
if ($_POST) {
    $checknum = '12082001Lvt';
    $quid = trim(poststr('qu'));
    $qu = $quarr[$quid];
    $uid = trim(poststr('uid'));
    $gid = $qu['gid'];
    $svid = $qu['svid'];
    $manageurl = $qu['manageurl'];
    $dbip = $qu['host'];
    $dbname = $qu['dbname'];
    $dbname1 = $qu['dbname1'];
    $dbuser = $qu['user'];
    $dbpwd = $qu['pwd'];
    $quname = $qu['name'];
    $token='IwY#UGJqJWxB8xZs';
    if ($checknum == $gmcode) {
        if ($quid >= 1 || $quid != '') {
            if ($uid != '') {
                if ($_POST['type']) {
                    $type = trim($_POST['type']);
                    switch ($type) {
                        
                        case 'clearbag':
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0,"Server Bảo Trì!","error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                             $sql = "SELECT * FROM `$dbname`.`player` where `accname`= '$uid' AND `server_id` = '$svid' limit 1";
                            $result = mysqli_query($con,$sql);
                            $row = mysqli_fetch_array($result);

                            if ($row['role_id'] != '') {
                                $idcl = $row['role_id'];
                                $sql = "DELETE FROM `$dbname1`.`role_items` WHERE `role_id` = '$idcl'";
                                $resultclear = mysqli_query($con,$sql);
                                if($resultclear){
									notiG100K(0,"Xóa Balo Thành Công!","success");
								}else{
									notiG100K(0,"Xóa Balo Thất Bại!","error");
								}
                            } else {
                                notiG100K(0,"Tài Khoản $uid Không Tồn tại!","error");
                            }
                            mysqli_close($con);
                            break;
                        
                        
                        case 'charge':
					    $chargetype = trim(poststr('chargetype'));
							if ($chargetype == '') {
                                    notiG100K(0,"Chưa Chọn Vật Phẩm!","error");
                                }
                       
                        $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0,"Server Bảo Trì!","error");
                        mysqli_query("set names 'utf8'");
                        mysqli_select_db($dbname, $con);
                        $sql1="select * from $dbname1.t_account where accountId='".$uid."'";
                        $result1 = mysqli_query($con,$sql1);
                        $row1 = mysqli_fetch_array($result1);
                        $playerId = $row1['uid'];
                        $sql="select * from $dbname1.t_player where accountUid='".$playerId."'";
                        $result = mysqli_query($con,$sql);
                        $row = mysqli_fetch_array($result);
                        mysqli_close($con);
                        if ($row['playerId'] != '') {
                            $action='recharge';
                    		$playerid=$row['playerId'];
                    		$productid=$chargetype;
                    		$data=array(
                    			"action"=>$action,
                    			"playerid"=>$playerid, 
                    			"productid"=>intval($productid),
                    			"token"=> $token
                    		);		
                    		$data=json_encode($data);
                    		$res=post_curl($manageurl, $data);
                    		$dataArray = json_decode($res, true);
                            if($dataArray["code"] == 0){
									notiG100K(0,"Nạp Free Thành Công!","success");
								}else{
									notiG100K(0,"Thất Bại!","error");
								}
                            } else {
                                notiG100K(0,"Nhân Vật $uid Không Tồn tại!","error");
                            }
                        break;
                        case 'mail':
                            $title="G100K.NET - TOOLS GM VIP";
                    		$context="G100K.NET - TOOLS GM VIP";
                            $mailid = trim(poststr('mailid'));
                            if ($mailid == '') {
                                notiG100K(0,"Chưa Chọn Vật Phẩm!","warning");
                            }
                            $find = false;
                            $file = fopen("item.txt", "r");
                            while (!feof($file)) {
                                $line = fgets($file);
                                $txts = explode(';', $line);
                                if ($txts[0] == $mailid) {
                                    $find = true;
                                }
                            }
                            fclose($file);
                            if ($find == false) {
                                notiG100K(0,"Vật Phẩm Không Tồn tại!","error");
                            }
                            $mailnum = trim(poststr('mailnum'));
                            if ($mailnum == '' || $mailnum < 0 || $mailnum > 1000000) {
                                notiG100K(0,"Số Lượng Từ 0-1000000!","error");
                            }
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0,"Server Bảo Trì!","error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                            $sql1="select * from $dbname1.t_account where accountId='".$uid."'";
                            $result1 = mysqli_query($con,$sql1);
                            $row1 = mysqli_fetch_array($result1);
                            $playerId = $row1['uid'];
                            $sql="select * from $dbname1.t_player where accountUid='".$playerId."'";
                            $result = mysqli_query($con,$sql);
                            $row = mysqli_fetch_array($result);
                            mysqli_close($con);
                            $items=$mailid.'_'.$mailnum;
                            $activate = $row1['isforbid'];
                            if ($row['playerId'] != '') {
                                $action='mail';
                        		$playerid=$row['playerId'];
                        		$data=array(
                        			"action"=>$action,
                        			"playerid"=>$playerid, 
                        			"mail"=>array(
                        				"sender"=>"G100K.NET",
                        				"title"=>$title,
                        				"content"=>$context,
                        				"reward"=>$items
                        			),
                        			"token"=> $token
                        		);
                                
                        		$data=json_encode($data);
                        		if ($activate == 1) {
                            		$res=post_curl($manageurl, $data);
                            		$dataArray = json_decode($res, true);
                                    if($dataArray["code"] == 0){
    									notiG100K(0,"Gửi Vật Phẩm Thành Công!","success");
    								}else{
    									notiG100K(0,"Thất Bại!","error");
    								}
                        		} else {
                        		     notiG100K(0,"Nhân Vật $uid Chưa Mua Tools!","error");
                        		}
                            } else {
                                notiG100K(0,"Tài Khoản $uid Không Tồn tại!","error");
                            }
                        break;
                        
                        default:
                            notiG100K(0,"Server Bảo Trì!","error");
                        break;
                    }
                } else {
                    notiG100K(0,"Chức Năng Không Tồn Tại!","error");
                }
            } else {
                notiG100K(0,"Chưa Nhập Tài Khoản Game!","error");
            }
        } else {
            notiG100K(0,"Chưa Chọn Máy Chủ!","error");
        }
    } else {
        notiG100K(0,"Mã GM Sai!","error");
    }
} else {
    notiG100K(0,"Server Bảo Trì!","error");
}
