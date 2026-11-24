<?php
include 'config.php';
if ($_POST) {
    $checknum = "skt3.com";
    $quid = trim(poststr('qu'));
    $qu = $quarr[$quid];
    $uid = trim(poststr('uid'));
    $dbuser = $qu['user'];
    $dbname = $qu['dbname'];
    $dbpswd = $qu['pswd'];
    $addr   = $qu['addr'];
	$port   = $qu['port'];
    $time = time();
	$con = @mysqli_connect($addr, $dbuser, $dbpswd) or die(mysqli_error());
    mysqli_query("set names 'utf8'");
    mysqli_select_db($dbname, $con);
    $sql = "SELECT * FROM `$dbname`.`dbnamesrecord` where `Name`='$uid' limit 1";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    $activate = $row['activate'];
    $suid = $row['Uin'];
    $http_host = '159.223.35.143:81'; 
    $pdo = new PDO("mysql:host=$addr;dbname=$dbname;charset=utf8", $dbuser, $dbpswd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $tables = ["DbRoleData_0", "DbRoleData_1", "DbRoleData_2", "DbRoleData_3", "DbRoleData_4", "DbRoleData_5", "DbRoleData_6", "DbRoleData_7", "DbRoleData_8", "DbRoleData_9", "DbRoleData_10", "DbRoleData_11", "DbRoleData_12", "DbRoleData_13", "DbRoleData_14", "DbRoleData_15", "DbRoleData_16", "DbRoleData_17", "DbRoleData_18", "DbRoleData_19", "DbRoleData_20", "DbRoleData_21", "DbRoleData_22", "DbRoleData_23", "DbRoleData_24", "DbRoleData_25"];


    $roleExists = false;
    $user = null;
    
    foreach ($tables as $table) {
        $stmt = $pdo->prepare("SELECT roleid, uin FROM $table WHERE Uin = :Uin");
        $stmt->execute(['Uin' => $suid]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            $roleExists = true;
            break; // 如果找到用户，跳出循环
        }
    }
    
    // 如果没有找到用户，抛出异常
    if (!$user) {
        notiG100K(0, "Nhân Vật Không Tồn Tại !!!", "error");
    }
        $uin = $user['uin'];
    $roleid =$user['roleid'];
   // notiG100K(0, $roleid, "error");
    if ($checknum == $gmcode) {
        if ($quid >= 1 || $quid != '') {
            if ($uid != '') {
                if ($_POST['type']) {
                    $type = trim($_POST['type']);
                    switch ($type) {
                        case 'SendFree'://不计入累充
                            $chargetype = trim(poststr('chargetype'));
                            $chargenum  = trim(poststr('chargenum'));
							$name   = "";
							if ($chargenum == '' || $chargenum < 0 || $chargenum > 99999999) {
                                notiG100K(0, "Số Lượng Quá Lớn !!!", "error");
                            }
							$target = 1;
							$gm   = "addmoney $chargetype $chargenum";							
					        $msg_id = rand (0x1, 0x7fffffff);
                            $gm_req = array();
                            $gm_req['MsgID'] = $msg_id;
                            $gm_req['Cmd'] = 3;
                            $gm_req['MsgBody'] = array();
                            $gm_req['MsgBody']['TargetType'] = intval($target);
                            $gm_req['MsgBody']['TextMsg'] = $gm;
                            $gm_req['MsgBody']['TargetPlayer']['RoleID'] = $roleid;
                            $gm_req['MsgBody']['TargetPlayer']['RoleName'] = $name;
                            $udp_req_str = json_encode($gm_req);
                            $check = sendgm($addr,$port,$udp_req_str);
							notiG100K(0,$check, "error");
                        break;
						
						case 'gift'://不计入累充
                            $gifttype = trim(poststr('gifttype'));
							$name   = "";
							$target = 1;
							$gm   = "buygood $gifttype";							
					        $msg_id = rand (0x1, 0x7fffffff);
                            $gm_req = array();
                            $gm_req['MsgID'] = $msg_id;
                            $gm_req['Cmd'] = 3;
                            $gm_req['MsgBody'] = array();
                            $gm_req['MsgBody']['TargetType'] = intval($target);
                            $gm_req['MsgBody']['TextMsg'] = $gm;
                            $gm_req['MsgBody']['TargetPlayer']['RoleID'] = $uid;
                            $gm_req['MsgBody']['TargetPlayer']['RoleName'] = $name;
                            $udp_req_str = json_encode($gm_req);
                            sendgm($addr,$port,$udp_req_str);
							exit('发送成功');
                        break;
						
						
                        case 'mail':
						    $mailid = trim(poststr('item'));
                            if ($mailid == '') {
                                exit('物品ID错误');
                            }
                            $find = false;
                            $file = fopen("../gmitem.txt", "r");
                            while (!feof($file)) {
                                $line = fgets($file);
                                $txts = explode(';', $line);
                                if ($txts[0] == $mailid) {
                                    $find = true;
                                }
                            }
                            fclose($file);
                            if ($find == false) {
                                exit('物品ID不存在');
                            }
                            $mailnum = trim(poststr('num'));
                            if ($mailnum == '' || $mailnum < 0 || $mailnum > 999) {
                                exit('发送数量太大，不允许哦，人家受不鸟啦~！');
                            }
						    $gifttype = trim(poststr('gifttype'));
							$name   = "";
							$target = 1;
							$gm   = "additem $mailid $mailnum";							
					        $msg_id = rand (0x1, 0x7fffffff);
                            $gm_req = array();
                            $gm_req['MsgID'] = $msg_id;
                            $gm_req['Cmd'] = 3;
                            $gm_req['MsgBody'] = array();
                            $gm_req['MsgBody']['TargetType'] = intval($target);
                            $gm_req['MsgBody']['TextMsg'] = $gm;
                            $gm_req['MsgBody']['TargetPlayer']['RoleID'] = $roleid;
                            $gm_req['MsgBody']['TargetPlayer']['RoleName'] = $name;
                            $udp_req_str = json_encode($gm_req);
                            sendgm($addr,$port,$udp_req_str);
							exit('发送成功');
                        break;
						case 'sl':						
						    $typenum = trim(poststr('typenum'));
							$name   = "";
							$target = 1;
							$gm   = "sl $typenum";							
					        $msg_id = rand (0x1, 0x7fffffff);
                            $gm_req = array();
                            $gm_req['MsgID'] = $msg_id;
                            $gm_req['Cmd'] = 3;
                            $gm_req['MsgBody'] = array();
                            $gm_req['MsgBody']['TargetType'] = intval($target);
                            $gm_req['MsgBody']['TextMsg'] = $gm;
                            $gm_req['MsgBody']['TargetPlayer']['RoleID'] = $uid;
                            $gm_req['MsgBody']['TargetPlayer']['RoleName'] = $name;
                            $udp_req_str = json_encode($gm_req);
                            sendgm($addr,$port,$udp_req_str);
							exit('设置等级成功');
                        break;
						case 'passlevel':						
						    $typenum = trim(poststr('typenum'));
							$name   = "";
							$target = 1;
							$gm   = "passlevel " . (1000 + intval($typenum));
					        $msg_id = rand (0x1, 0x7fffffff);
                            $gm_req = array();
                            $gm_req['MsgID'] = $msg_id;
                            $gm_req['Cmd'] = 3;
                            $gm_req['MsgBody'] = array();
                            $gm_req['MsgBody']['TargetType'] = intval($target);
                            $gm_req['MsgBody']['TextMsg'] = $gm;
                            $gm_req['MsgBody']['TargetPlayer']['RoleID'] = $uid;
                            $gm_req['MsgBody']['TargetPlayer']['RoleName'] = $name;
                            $udp_req_str = json_encode($gm_req);
                            sendgm($addr,$port,$udp_req_str);
							exit('跳关成功');
                        break;
						case 'fenghao':						
						    $typenum = trim(poststr('typenum'));
							$name   = "";
							$target = 1;
							$gm   = "setblock $typenum";							
					        $msg_id = rand (0x1, 0x7fffffff);
                            $gm_req = array();
                            $gm_req['MsgID'] = $msg_id;
                            $gm_req['Cmd'] = 3;
                            $gm_req['MsgBody'] = array();
                            $gm_req['MsgBody']['TargetType'] = intval($target);
                            $gm_req['MsgBody']['TextMsg'] = $gm;
                            $gm_req['MsgBody']['TargetPlayer']['RoleID'] = $uid;
                            $gm_req['MsgBody']['TargetPlayer']['RoleName'] = $name;
                            $udp_req_str = json_encode($gm_req);
                            sendgm($addr,$port,$udp_req_str);
							exit('封号成功');
                        break;
						case 'qiangli':						
						    $typenum = trim(poststr('typenum'));
							$name   = "";
							$target = 1;
							$gm   = "clearbag";							
					        $msg_id = rand (0x1, 0x7fffffff);
                            $gm_req = array();
                            $gm_req['MsgID'] = $msg_id;
                            $gm_req['Cmd'] = 3;
                            $gm_req['MsgBody'] = array();
                            $gm_req['MsgBody']['TargetType'] = intval($target);
                            $gm_req['MsgBody']['TextMsg'] = $gm;
                            $gm_req['MsgBody']['TargetPlayer']['RoleID'] = $uid;
                            $gm_req['MsgBody']['TargetPlayer']['RoleName'] = $name;
                            $udp_req_str = json_encode($gm_req);
                            sendgm($addr,$port,$udp_req_str);
							exit('清理成功');
                        break;
						case 'xiaxian':						
						    $typenum = trim(poststr('typenum'));
							$name   = "";
							$target = 1;
							$gm   = "kickallplayer";							
					        $msg_id = rand (0x1, 0x7fffffff);
                            $gm_req = array();
                            $gm_req['MsgID'] = $msg_id;
                            $gm_req['Cmd'] = 3;
                            $gm_req['MsgBody'] = array();
                            $gm_req['MsgBody']['TargetType'] = intval($target);
                            $gm_req['MsgBody']['TextMsg'] = $gm;
                            $gm_req['MsgBody']['TargetPlayer']['RoleID'] = $uid;
                            $gm_req['MsgBody']['TargetPlayer']['RoleName'] = $name;
                            $udp_req_str = json_encode($gm_req);
                            sendgm($addr,$port,$udp_req_str);
							exit('强制下线成功');
                        break;
                        case 'addczvip':
                            $pwd = trim(poststr('pwd'));
                            if ($pwd == '') {
                                exit('玩家后台的授权密码不能为空');
                            }
                            $vipfile = 'Q12225150-' . $quid . '.json';
                            $fp = fopen($vipfile, "a+");
                            if (filesize($vipfile) > 0) {
                                $str = fread($fp, filesize($vipfile));
                                fclose($fp);
                                $vipjson = json_decode($str, true);
                                if ($vipjson == null) {
                                    $vipjson = array();
                                }
                            } else {
                                $vipjson = array();
                            }
                            if (!$vipjson[$uid]) {
                                $vipjson[$uid] = array('pwd' => $pwd, 'level' => 1, 'quid' => $quid);
                                file_put_contents($vipfile, json_encode($vipjson, 320));
                                exit('加入VIP成功.');
                            } else {
                                exit('该角色名已经是VIP了.');
                            }
                        break;
                        case 'addvip':
                            $pwd = trim(poststr('pwd'));
                            if ($pwd == '') {
                                exit('玩家后台的授权密码不能为空');
                            }
                            $vipfile = 'Q12225150-' . $quid . '.json';
                            $fp = fopen($vipfile, "a+");
                            if (filesize($vipfile) > 0) {
                                $str = fread($fp, filesize($vipfile));
                                fclose($fp);
                                $vipjson = json_decode($str, true);
                                if ($vipjson == null) {
                                    $vipjson = array();
                                }
                            } else {
                                $vipjson = array();
                            }
                            if (!$vipjson[$uid] || intval($vipjson[$uid]['level'] == 0)) {
                                $vipjson[$uid] = array('pwd' => $pwd, 'level' => 2, 'quid' => $quid);
                                file_put_contents($vipfile, json_encode($vipjson, 320));
                                exit('加入或升级VIP成功.');
                            } else {
                                exit('该角色名已经是VIP了.');
                            }
                        break;
                        case 'quxiaovip':
                            $vipfile = 'Q12225150-' . $quid . '.json';
                            $fp = fopen($vipfile, "a+");
                            if (filesize($vipfile) > 0) {
                                $str = fread($fp, filesize($vipfile));
                                fclose($fp);
                                $vipjson = json_decode($str, true);
                                if ($vipjson == null) {
                                    $vipjson = array();
                                }
                            } else {
                                $vipjson = array();
                            }
                            if ($vipjson[$uid]) {
                                unset($vipjson[$uid]);
                                file_put_contents($vipfile, json_encode($vipjson, 320));
                                exit('取消成功.');
                            } else {
                                exit('该角色名并未授权.');
                            }
                        break;
                        case 'editpwd':
                            $pwd = trim(poststr('pwd'));
                            if ($pwd == '') {
                                exit('玩家后台的授权密码不能为空');
                            }
                            $vipfile = 'Q12225150-' . $quid . '.json';
                            $fp = fopen($vipfile, "a+");
                            if (filesize($vipfile) > 0) {
                                $str = fread($fp, filesize($vipfile));
                                fclose($fp);
                                $vipjson = json_decode($str, true);
                                if ($vipjson == null) {
                                    $vipjson = array();
                                }
                            } else {
                                $vipjson = array();
                            }
                            if ($vipjson[$uid]) {
                                $vipjson[$uid] = array('pwd' => $pwd, 'level' => $vipjson[$uid]['level'], 'quid' => $quid);
                                file_put_contents($vipfile, json_encode($vipjson, 320));
                                exit('修改成功.');
                            } else {
                                exit('该角色并未授权.');
                            }
                        break;
						
                        default:
                            exit('系统异常，请重试!');
                        break;
                    }
                } else {
                    exit('请求类型不存在！');
                }
            } else {
                exit('角色名错误');
            }
        } else {
            exit('区号错误');
        }
    } else {
        exit('GM码不对');
    }
} else {
    exit('非法请求!请自重');
}
