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
    $type = trim(poststr('type'));
    $checknum = 'g100k';
    $quid = trim(poststr('qu'));
    $qu = $quarr[$quid];
    $uid = trim(poststr('uid'));
    $dbip = $qu['host'];
    $zoneid = $qu['zoneid'];
    $dbname = $qu['dbname'];
    $dbuser = $qu['user'];
    $dbpwd = $qu['pwd'];
    $quname = $qu['name'];
    $db=$dbname;
    $chargenum =  trim(poststr('chargenum'));
	$conn = new mysqli("nk3d.g100k.net","hk20","12082001Lvt",$db,"3306") or notiG100K(0,"Server Bảo Trì!","error");
	$role = $uid;
    $roleid = $conn->query("SELECT * FROM $dbname.role WHERE role_name = '$role' LIMIT 1")->fetch_assoc()['role_id'];
	if ($roleid==''){
	    notiG100K(0,"Tên Nhân Vật Không Tồn Tại!","error");
	}
    $chargenum =  trim(poststr('chargenum'));
    $time = time();
	//参数处理	
    if ($checknum == $gmcode) {
        if ($quid >= 1 || $quid != '') {
            if ($uid != '') {
                if ($_POST['type']) {
                    $type = trim($_POST['type']);
                    switch ($type) {
                        case 'charge':
                            if ($chargenum==''){
                    			$json['status'] = 0;
                        	    $json['msg'] = "Chưa Nhập Số Lượng KNB!";
                        	    $json['type'] = "warning";
                        	    exit(json_encode($json));
                    		}
                            $conn->query("INSERT INTO $dbname.systemmail(uid, recv_time, kind, gold, subject) VALUES ($roleid, $time, 2, $chargenum, 0xB3E4D6B5)");
							$cmd = strToHex("CmdToRole $roleid 4 $chargenum 0");
							$conn->query("INSERT INTO $dbname.command(creator, createtime, type, cmd) VALUES (0x74757475, $time, 2, $cmd)");
							$cmd = strToHex("newnotice 2 $roleid");
							$conn->query("INSERT INTO $dbname.command(creator, createtime, type, cmd) VALUES (0x74757475, $time, 2, $cmd)");
							$json['status'] = 0;
                    	    $json['msg'] = "Thành Công !";
                    	    $json['type'] = "success";
                    	    exit(json_encode($json));
                        break;
						case 'bag' ://清包
							 $conn->query("DELETE FROM $dbname.itemlist WHERE role_id={$roleid} and itemlist_index<400");
							 $json['status'] = 0;
                        	 $json['msg'] = "Xóa Thành Công !";
                        	 $json['type'] = "success";
                        	 exit(json_encode($json));
						break;
                        case 'mail':
						//防止f12
    						$mailid = trim(poststr('mailid'));
                                if ($mailid == '') {
                                    $json['status'] = 0;
                            	    $json['msg'] = "Chưa Chọn Vật Phẩm !";
                            	    $json['type'] = "warning";
                            	    exit(json_encode($json));
                                }
                                $find = false;
                                $file = fopen("../item.txt", "r");
                                while (!feof($file)) {
                                    $line = fgets($file);
                                    $txts = explode(';', $line);
                                    if ($txts[0] == $mailid) {
                                        $find = true;
                                    }
                                }
                                fclose($file);
                                if ($find == false) {
                                    $json['status'] = 0;
                            	    $json['msg'] = "Chưa Chọn Vật Phẩm !";
                            	    $json['type'] = "warning";
                            	    exit(json_encode($json));
                                }
                                $mailnum = trim(poststr('mailnum'));
                                if ($mailnum == '' || $mailnum < 0 || $mailnum > 9999) {
                                    $json['status'] = 0;
                            	    $json['msg'] = "Số Lượng Quá Lớn !";
                            	    $json['type'] = "warning";
                            	    exit(json_encode($json));
                                }
    						//防止f12
    						    $check = $conn->query("SELECT * FROM $dbname.role WHERE role_name = '$role' LIMIT 1")->fetch_assoc()['activate'];
    							if ($check=='0'){
    								$json['status'] = 0;
                                	$json['msg'] = "Nhân Vật Chưa Mua Tools !";
                                	$json['type'] = "warning";
                                	exit(json_encode($json));
    							} else {
                                    $item = trim($_POST['mailid']);
        							$itemnum = trim($_POST['mailnum']);
        							$conn->query("INSERT INTO $dbname.systemmail(uid, recv_time, kind, item_id1,item_num1, subject) VALUES ($roleid, $time, 2, $item,$itemnum, 0xB3E4D6B5)");
        							$cmd = strToHex("newnotice 2 $roleid");
        							$conn->query("INSERT INTO $dbname.command(creator, createtime, type, cmd) VALUES (0x74757475, $time, 2, $cmd)");
        							$json['status'] = 0;
                                	$json['msg'] = "Gửi Vật Phẩm Thành Công !";
                                	$json['type'] = "success";
                                	exit(json_encode($json));
    							}
                        break;
						
                        case 'allmail':
                            $mailid = trim(poststr('item'));
                            if ($mailid == '') {
                                exit('ID Sai !!!');
                            }
                            $find = false;
                            $file = fopen("../item.txt", "r");
                            while (!feof($file)) {
                                $line = fgets($file);
                                $txts = explode(';', $line);
                                if ($txts[0] == $mailid) {
                                    $find = true;
                                }
                            }
                            fclose($file);
                            if ($find == false) {
                                exit('ID Không Tồn Tại');
                            }
                            $mailnum = trim(poststr('num'));
                            if ($mailnum == '' || $mailnum < 0 || $mailnum > 2000000000) {
                                exit('Gửi Tiền Nhiều Hông Được !!!');
                            }
									$check = $conn->query("SELECT * FROM $dbname.role WHERE role_name = '$role' LIMIT 1")->fetch_assoc()['activate'];
							if ($check=='0'){
								  exit('Nhan Vat Chua Mua TOOL！');
							} else {
                            $title = trim(poststr('title'));
                            $content = trim(poststr('content'));
                            $con = @mysql_connect($dbip, $dbuser, $dbpwd) or die(mysql_error());
                            mysql_query("set names 'utf8'");
                            mysql_select_db($dbname, $con);
                            $sql = "select * from `charbase`";
                            $result = mysql_query($sql, $con);
                            if ($result && mysql_num_rows($result) > 0) {
								$arr = array();
								while ($row = mysql_fetch_assoc($result)) {
                                $arr[] = $row;
                                }
								foreach($arr as $key=>$value){
								    $roleid = $value['CHARID'];
                                    $rolename = $value['NAME'];
                                    mysql_query("insert into `$dbname`.`gift` (`CHARID`,`ZONE`,`NAME`,`ITEMID1`,`ITEMID2`,`ITEMID3`,`ITEMNUM1`,`ITEMNUM2`,`ITEMNUM3`,`BIND1`,`BIND2`,`BIND3`,`MAILFROM`,`MAILTITLE`,`MAILTEXT`) values('$roleid','$zoneid','$rolename','$mailid','0','0','$mailnum','0','0','1','0','0','系统','$title','$content')", $con);
                                    $SN = md5(uniqid(rand(), true));
                                    $OptTimeStamp = time();
                                    $gm_code = 'loadgift';
                                    $Command = ltrim($gm_code, '/');
                                    $CmdLength = strlen($Command);
                                    $sql = "insert into `$extdbname`.`gm_command` (SN,FromIP,ServerID,Command,Status,OptTimeStamp,FlagId,CmdLength,ADMIN) values('" . $SN . "','127.0.0.1','" . $zoneid . "','" . $gm_code . "','1','" . $OptTimeStamp . "','" . $OptTimeStamp . "','" . $CmdLength . "','admin')";
                                    $result = mysql_query($sql, $con);
                                    usleep(100000);	
								}
                            } else {
                                mysql_close($conn);
                                exit('Chưa Có Dữ Liệu !!!');
                            }
                            mysql_close($con);
                            exit("Don Send ! Please Check Mail :D");
							}
                        break;
                        default:
                            $json['status'] = 0;
                    	    $json['msg'] = "Lỗi Hệ Thống !";
                    	    $json['type'] = "error";
                    	    exit(json_encode($json));
                        break;
                    }
                } else {
                    $json['status'] = 0;
                    $json['msg'] = "Loại Yêu Cầu Không Tồn Tại！";
                    $json['type'] = "error";
                    exit(json_encode($json));
                }
            } else {
                $json['status'] = 0;
                $json['msg'] = "Lỗi Tên Vai Trò";
                $json['type'] = "error";
                exit(json_encode($json));
            }
        } else {
            $json['status'] = 0;
            $json['msg'] = "Mã VP Sai";
            $json['type'] = "error";
            exit(json_encode($json));
        }
    } else {
        $json['status'] = 0;
        $json['msg'] = "Mã GM Không Đúng !!!";
        $json['type'] = "error";
        exit(json_encode($json));
    }
} else {
    $json['status'] = 0;
    $json['msg'] = "Bug Con Cặt !!! CÚT !!!!";
    $json['type'] = "error";
    exit(json_encode($json));
}
