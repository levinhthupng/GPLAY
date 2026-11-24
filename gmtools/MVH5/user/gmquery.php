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
    $chargetype =  trim(poststr('chargetype'));
	$conn = new mysqli("152.42.221.136","hk20","12082001Lvt",$db,"3306") or notiG100K(0,"Server Bảo Trì!","error");
	$role = $uid;
    $roleid = $conn->query("SELECT * FROM `$dbname`.`account` WHERE name = '$role' LIMIT 1")->fetch_assoc()['id'];
	if ($roleid==''){
	    notiG100K(0,"Tài Khoản Không Tồn Tại!","error");
	}
    $time = time();
	//参数处理	

    if ($checknum == $gmcode) {
        if ($quid >= 1 || $quid != '') {
            if ($uid != '') {
                if ($_POST['type']) {
                    $type = trim($_POST['type']);
                    switch ($type) {
                        case 'charge':
                            
                            if ($chargetype==''){
                    			notiG100K(0,"Chưa Chọn Vật Phẩm!","error");
                    		}
                            $pay = explode('|', $chargetype);
                          
                            $cmd = "admin.processpayment";
                            $params = array(
                                'order_id' => createOrderNo(),
                                'gold_num' => (int)$pay[0],
                                'name'     => $pay[1],
                                'platform' => 'h5',
                                'cost'     => null
                            );
                            $request = '{"zoneid":1,"secret":"96e79218965eb72c92a549dd5a330112","cmd":"'.$cmd.'","params":'.json_encode($params).',"uid":'.$roleid.'}';
                            $ret = sockos("152.42.221.136", 15001, $request);
                            $ck = json_decode($json, true);
                                    if ($ck == 0){
                                        notiG100K(0,"Gửi Vật Phẩm Thành Công!","success");
                                    } else {
                                        notiG100K(0,"Gửi Vật Phẩm Thất Bại !!!","success");
                                    }
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
                                    $txts = explode('|', $line);
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
    						    $check = $conn->query("SELECT * FROM `$dbname`.`account` WHERE name = '$role' LIMIT 1")->fetch_assoc()['vip'];
    							if ($check=='0'){
    								$json['status'] = 0;
                                	$json['msg'] = "Tài Khoản Chưa Mua Tools !";
                                	$json['type'] = "warning";
                                	exit(json_encode($json));
    							} else {
                                    $item = trim($_POST['mailid']);
        							$itemnum = trim($_POST['mailnum']);
        							
        							$cmd = "mail.sendtosystemapi";
                                    $params = array(
                                        // FIX: Trả lại Tiếng Trung để không bị lỗi Encoding trên Server Game
                                        "title"   => 'G100K', 
                                        "content" => 'G100K', 
                                        "mtype"   => 2,
                                        "gmid"    => 1,
                                        "touch"   => '6_'.$item.'_'.$itemnum,
                                        "limit1"  => $roleid
                                    );
                                    $request = '{"zoneid":'.$zoneid.',"secret":"96e79218965eb72c92a549dd5a330112","cmd":"'.$cmd.'","params":'.json_encode($params).',"uid":'.$roleid.'}';
                                    $ret = sockos("152.42.221.136", 15001, $request);
                                    $ck = json_decode($json, true);
                                    if ($ck == 0){
                                        notiG100K(0,"Gửi Vật Phẩm Thành Công!","success");
                                    } else {
                                        notiG100K(0,"Gửi Vật Phẩm Thất Bại !!!","success");
                                    }
        							
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

// Hàm hỗ trợ Socket
function sockos($host, $port, $request) {
    $fp = @fsockopen($host, $port, $errno, $errstr, 3);
    if (!$fp) return 'Lỗi kết nối Server Game';
    fputs($fp, "1 $request\r\n");
    $len = 1024;
    $result = fread($fp, $len);
    $binary = substr($result, 1, 3);
    $header = unpack("v", $binary);
    $result_len = strlen($result);
    if (isset($header[1])) {
        do {
            $next_len = $header[1] - $result_len;
            if ($next_len > 0) {
                $next_len = $next_len > $len ? $len : $next_len;
                $result .= fread($fp, $next_len);
                $result_len += $next_len;
            }
        } while ($header[1] - $result_len > 0);
    }
    if (strlen($result) > 5) {
        $result = substr($result, 5);
    }
    fclose($fp);
    return $result;
}
function createOrderNo() {
    $date = date('Ymd');
    return $date . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}
