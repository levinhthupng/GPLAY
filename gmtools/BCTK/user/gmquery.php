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
                                    notiG100K(0,"Không Thể Nạp!","error");
                                }
                        $chargenum = trim(poststr('chargenum'));
                        if ($chargenum == '' || $chargenum < 0 || $chargenum > 10) {
                            notiG100K(0,"Số Lượng < 10!","warning");
                        }
                        $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0,"Server Bảo Trì!","error");
                        mysqli_query("set names 'utf8'");
                        mysqli_select_db($dbname, $con);
                         $sql = "SELECT * FROM `$dbname`.`player` where `accname`= '$uid' AND `server_id` = '$svid' limit 1";
                         
                        $result = mysqli_query($con,$sql);
                        $row = mysqli_fetch_array($result);
                        mysqli_close($con);
                        if ($row['role_id'] != '') {
                            $login_url = $manageurl . "login.php?ac=login";
                            $post_fields = array("passport" => $qu['manageuser'], "password" => $qu['managepwd'], "Submit" => "");
                            $ch = curl_init($login_url); //初始化
                            curl_setopt($ch, CURLOPT_HEADER, 1);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                            $content = curl_exec($ch);
                            preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                            $cookie = $str[1];
                            $role_id = (int)$row['role_id'];
                            $title = "G100K - TOOLS FREE";
                            $content = "G100K - TOOLS FREE";
                                $url = $manageurl . "action_gateway.php?ctl=mail&act=review_mail_action";
                                $post = array(
								"gid" =>  $gid,
								"sid" =>  $svid,
								"type" =>  0,
								"ids" =>  $role_id,
								"lv" =>  1,
								"good[goods_id][1]" =>  $chargetype,
								"good[num][1]" =>  $chargenum,
								"good[bind][1]" =>  0,
								"good[overTime][1]" =>  null,
								"good[goods_id][2]" =>  null,
								"good[num][2]" =>  1,
								"good[bind][2]" =>  1,
								"good[overTime][2]" =>  null,
								"good[goods_id][3]" =>  null,
								"good[num][3]" =>  1,
								"good[bind][3]" =>  1,
								"good[overTime][3]" =>  null,
								"good[goods_id][4]" =>  null,
								"good[num][4]" =>  1,
								"good[bind][4]" =>  1,
								"good[overTime][4]" =>  null,
								"good[goods_id][5]" =>  null,
								"good[num][5]" =>  1,
								"good[bind][5]" =>  1,
								"good[overTime][5]" =>  null,
								"title" =>  $title,
								"content" =>  $content,								
							);
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                            $content = curl_exec($ch);
                            if(strpos($content,'ok')){
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
                             $sql = "SELECT * FROM `$dbname`.`player` where `accname`= '$uid' AND `server_id` = '$svid' limit 1";
                             
                            $result = mysqli_query($con,$sql);
                            $row = mysqli_fetch_array($result);
                            //notiG100K(0,$sql,"error");
                            if ($row['activate'] != 1) {
                                notiG100K(0,"Chưa Mua Tools!","error");
                            }
							mysqli_close($con);
                            if ($row['role_id'] != '') {
                                $login_url = $manageurl . "login.php?ac=login";
                                $post_fields = array("passport" => $qu['manageuser'], "password" => $qu['managepwd'], "Submit" => "");
                                $ch = curl_init($login_url);
                                curl_setopt($ch, CURLOPT_HEADER, 1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                $content = curl_exec($ch); 
                                preg_match('/Set-Cookie:(.*);/iU', $content, $str); 
                                $cookie = $str[1]; 
                                $role_id = (int)$row['role_id'];
                                $title = 'G100K - TOOLS VIP';
                                $content ='G100K - TOOLS VIP';
                                $url = $manageurl . "action_gateway.php?ctl=mail&act=review_mail_action";
                                $post = array(
								"gid" =>  $gid,
								"sid" =>  $svid,
								"type" =>  0,
								"ids" =>  $role_id,
								"lv" =>  1,
								"good[goods_id][1]" =>  $mailid,
								"good[num][1]" =>  $mailnum,
								"good[bind][1]" =>  0,
								"good[overTime][1]" =>  null,
								"good[goods_id][2]" =>  null,
								"good[num][2]" =>  1,
								"good[bind][2]" =>  1,
								"good[overTime][2]" =>  null,
								"good[goods_id][3]" =>  null,
								"good[num][3]" =>  1,
								"good[bind][3]" =>  1,
								"good[overTime][3]" =>  null,
								"good[goods_id][4]" =>  null,
								"good[num][4]" =>  1,
								"good[bind][4]" =>  1,
								"good[overTime][4]" =>  null,
								"good[goods_id][5]" =>  null,
								"good[num][5]" =>  1,
								"good[bind][5]" =>  1,
								"good[overTime][5]" =>  null,
								"title" =>  $title,
								"content" =>  $content,
								);
                                $ch = curl_init($url); 
                                curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                                curl_setopt($ch, CURLOPT_HEADER, 0);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
                                $content = curl_exec($ch);
                                if(strpos($content,'ok')){
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
