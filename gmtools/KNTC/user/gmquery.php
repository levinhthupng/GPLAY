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
                             $sql = "SELECT * FROM `$dbname1`.`t_player` where `name`= '$uid' AND `serverId` = '$svid' limit 1";
                            $result = mysqli_query($con,$sql);
                            $row = mysqli_fetch_array($result);

                            if ($row['id'] != '') {
                                $idcl = $row['id'];
                                $sql = "DELETE FROM `$dbname1`.`t_player_item` WHERE `playerId` = '$idcl'";
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
                                    notiG100K(0,"Không Thể Nạp!","error");
                                }
                        $chargenum = trim(poststr('chargenum'));
                        if ($chargenum == '' || $chargenum < 0 || $chargenum > 999999999) {
                            notiG100K(0,"Số Lượng < 999999999!","warning");
                        }
                        $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0,"Server Bảo Trì!","error");
                        mysqli_query("set names 'utf8'");
                        mysqli_select_db($dbname, $con);
                         $sql = "SELECT * FROM `$dbname`.`t_player` where `playerName`= '$uid' AND `serverId` = '$svid' limit 1";
                         
                        $result = mysqli_query($con,$sql);
                        $row = mysqli_fetch_array($result);
                        mysqli_close($con);
                        if ($row['playerName'] != '') {
                            $url = $manageurl;
                            $curl = curl_init($url);
                            curl_setopt($curl, CURLOPT_URL, $url);
                            curl_setopt($curl, CURLOPT_POST, true);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                            
                            $headers = array(
                               "Content-Type: application/x-www-form-urlencoded",
                            );
                            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                            
                            $data = "type=mail&checknum=25251325&uid=".$row['playerName']."&item=".$chargetype."&num=".$chargenum."&qu=1";
                            
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                            
                            //for debug only!
                            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                            
                            $resp = curl_exec($curl);
                            curl_close($curl);
                            $content = json_decode($resp, true);
                            if($content['errcode'] == 0){
									notiG100K(0,"Nạp Free Thành Công!","success");
								}else{
									notiG100K(0,"Thất Bại!","error");
								}
                            } else {
                                notiG100K(0,"Tài Khoản $uid Không Tồn tại!","error");
                            }
                        break;
                        case 'mail':
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
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0,"Server Bảo Trì1!","error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                             $sql = "SELECT * FROM `$dbname`.`t_player` where `playerName`= '$uid' AND `serverId` = '$svid' limit 1";
                             
                            $result = mysqli_query($con,$sql);
                            $row = mysqli_fetch_array($result);
                            //notiG100K(0,$sql,"error");
                            if ($row['activate'] != 1) {
                                notiG100K(0,"Chưa Mua Tools!","error");
                            }
							mysqli_close($con);
                            if ($row['playerName'] != '') {
                            $url = $manageurl;
                            $curl = curl_init($url);
                            curl_setopt($curl, CURLOPT_URL, $url);
                            curl_setopt($curl, CURLOPT_POST, true);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                            
                            $headers = array(
                               "Content-Type: application/x-www-form-urlencoded",
                            );
                            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                            
                            $data = "type=mail&checknum=25251325&uid=".$row['playerName']."&item=".$mailid."&num=".$mailnum."&qu=1";
                            
                            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                            
                            //for debug only!
                            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                            
                            $resp = curl_exec($curl);
                            curl_close($curl);
                            $content = json_decode($resp, true);
                            if($content['errcode'] == 0){
									notiG100K(0,"Gửi Vật Phẩm Thành Công!","success");
								}else{
									notiG100K(0,"Thất Bại!","error");
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
