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
    $checknum = "ruankor.com";
    $quid = trim(poststr('qu'));
    $qu = $quarr[$quid];
    $uid = trim(poststr('uid'));
    $dbip = $qu['host'];
    $zoneid = $qu['zoneid'];
    $quname = $qu['name'];
    $url = $qu['url'];
	$quid      =  trim(poststr('qu'));
    $qu        =  $quarr[$quid];
    $uid       =  trim(poststr('uid'));
    $url       =  $qu['url'];
    $srv_name  =  $qu['srv_name'];
    $adm_user  =  $qu['user'];
	$adm_pswd  =  $qu['pswd'];
    $time = time();
    $getacti = 	mysqli_fetch_assoc($mysql2->query("SELECT * FROM `gm` WHERE `idnv` = '{$uid}'"));
    $activate =   $getacti['activate'] ;   
    if ($checknum == $gmcode) {
        if ($quid >= 1 || $quid != '') {
            if ($uid != '') {
                if ($_POST['type']) {
                    $type = trim($_POST['type']);
                    switch ($type) {
                        case 'charge':
                        $cookie     =  loginGetCookie($url,$adm_user,$adm_pswd);
                        $chargetype = trim(poststr('chargetype'));
                        $chargenum  = trim(poststr('chargenum'));
                        //$test = getUID($url,$cookie,"G100KZ",$srv_name);
							sendMail($url,$uid,$cookie,$chargetype,$chargenum,$srv_name);
						notiG100K(0,"Thành Công","success");
                        break;
                        case 'mail':
                            if ($activate == 0) {
                                notiG100K(0,"Chưa Mua Tools","error");
                            }
						//防止f12
						$cookie     =  loginGetCookie($url,$adm_user,$adm_pswd);
							
						    $mailid = trim(poststr('mailid'));
                            if ($mailid == '') {
                                exit('Chưa Chọn Vật Phẩm');
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
                                exit('Vật Phẩm Không Tồn Tại');
                            }
                            $mailnum = trim(poststr('mailnum'));
                            if ($mailnum == '' || $mailnum < 0 || $mailnum > 99999999) {
                                exit('Số Lượng Từ 1-99999999！');
                            }
						//防止f12
                            $item = trim($_POST['mailid']);
							$itemnum = trim($_POST['mailnum']);
							$title =  trim($_POST['title']);
							$content = trim($_POST['content']);
							$result = sendMail($url,$uid,$cookie,$item,$itemnum,$srv_name,$title,$content);
							if ($result){
							    notiG100K(0,"Gửi Vật Phẩm Thành Công","success");
							} else {
							    notiG100K(0,"Gửi Vật Phẩm Thất Bại","error");
							}
                        break;
                        case 'SendHero':
                            if ($activate == 0) {
                                notiG100K(0,"Chưa Mua Tools","error");
                            }
                            $jl = trim(poststr('heroid'));
                 
                            if ($jl == '') {
                                notiG100K(0,"Chưa Chọn Vật Phẩm","error");
                                }
                                $find = false;
                                $file = fopen("../jl.txt", "r");
                                while (!feof($file)) {
                                    $line = fgets($file);
                                    $txts = explode('|', $line);
                                    if ($txts[0] == $jl) {
                                        $find = true;
                                    }
                                }
                                fclose($file);
                                if ($find == false) {
                                    notiG100K(0,"Vật Phẩm Không Tồn Tại","error");
                                }
                                 $chargetype = trim(poststr('heroid'));
    						     $result = sendMailHero($url,$uid,$cookie,$chargetype,$chargenum,$srv_name);
    							 if ($result){
							    notiG100K(0,"Gửi Vật Phẩm Thành Công","success");
        							} else {
        							    notiG100K(0,"Gửi Vật Phẩm Thất Bại","error");
        							}
                            break;
                            
                        case 'SendDaocu';
                        if ($activate == 0) {
                                notiG100K(0,"Chưa Mua Tools","error");
                            }
                            $chargetype3 = trim(poststr('daocuid'));
                            $chargenum3 = trim(poststr('daocunum'));
                                if ($chargetype3 == '') {
                                         notiG100K(0,"Chưa Chọn Vật Phẩm","error");
                                    }
                                    $find = false;
                                    $file = fopen("../charge3.txt", "r");
                                    while (!feof($file)) {
                                        $line = fgets($file);
                                        $txts = explode(';', $line);
                                        if ($txts[0] == $chargetype3) {
                                            $find = true;
                                        }
                                    }
                                    fclose($file);
                                    if ($find == false) {
                                        notiG100K(0,"Vật Phẩm Không Tồn Tại","error");
                                    }
                                    $chargenum3 = trim(poststr('daocunum'));
                                    if ($chargenum3 == '' || $chargenum3 < 0 || $chargenum3 > 999999) {
                                        notiG100K(0,"Số Lượng Từ 1-999999","error");
                                    }
                                
        						     $result = sendMail($url,$uid,$cookie,$chargetype3,$chargenum3,$srv_name);
    							 
    							  if ($result){
							    notiG100K(0,"Gửi Vật Phẩm Thành Công","success");
							} else {
							    notiG100K(0,"Gửi Vật Phẩm Thất Bại","error");
							}
                            break;
                        case 'SendHoathach';
                        if ($activate == 0) {
                                notiG100K(0,"Chưa Mua Tools","error");
                            }
                                $chargetype4 = trim(poststr('hoathachid'));
                                $chargenum4 = trim(poststr('hoathachnum'));
                                if ($chargetype4 == '') {
                                         exit('Chưa Chọn Vật Phẩm');
                                    }
                                    $find = false;
                                    $file = fopen("../charge4.txt", "r");
                                    while (!feof($file)) {
                                        $line = fgets($file);
                                        $txts = explode(';', $line);
                                        if ($txts[0] == $chargetype4) {
                                            $find = true;
                                        }
                                    }
                                    fclose($file);
                                    if ($find == false) {
                                        notiG100K(0,"Vật Phẩm Không Tồn Tại","error");
                                    }
                                    $chargenum4 = trim(poststr('hoathachnum'));
                                    if ($chargenum4 == '' || $chargenum4 < 0 || $chargenum4 > 999) {
                                        exit('Số Lượng Từ 1-999！');
                                    }
                                
        						     $result = sendMail($url,$uid,$cookie,$chargetype4,$chargenum4,$srv_name);
        						if ($result){
							    notiG100K(0,"Gửi Vật Phẩm Thành Công","success");
							} else {
							    notiG100K(0,"Gửi Vật Phẩm Thất Bại","error");
							}
                            break;
                        case 'SendManhvo';
                        if ($activate == 0) {
                                notiG100K(0,"Chưa Mua Tools","error");
                            }
                                $chargetype2 = trim(poststr('manhvoid'));
                                $chargenum2 = trim(poststr('manhvonum'));
                                if ($chargetype2 == '') {
                                         exit('Chưa Chọn Vật Phẩm');
                                    }
                                    $find = false;
                                    $file = fopen("../charge2.txt", "r");
                                    while (!feof($file)) {
                                        $line = fgets($file);
                                        $txts = explode(';', $line);
                                        if ($txts[0] == $chargetype2) {
                                            $find = true;
                                        }
                                    }
                                    fclose($file);
                                    if ($find == false) {
                                        notiG100K(0,"Vật Phẩm Không Tồn Tại","error");
                                    }
                                    $chargenum2 = trim(poststr('manhvonum'));
                                    if ($chargenum2 == '' || $chargenum2 < 0 || $chargenum2 > 9999) {
                                        exit('Số Lượng Từ 1-9999！');
                                    }
                                
    						     $result = sendMail($url,$uid,$cookie,$chargetype2,$chargenum2,$srv_name);
    						if ($result){
							    notiG100K(0,"Gửi Vật Phẩm Thành Công","success");
							} else {
							    notiG100K(0,"Gửi Vật Phẩm Thất Bại","error");
							}
                            break;
                        case 'SendKhung';
                        if ($activate == 0) {
                                notiG100K(0,"Chưa Mua Tools","error");
                            }
                            $chargetype5 = trim(poststr('khungid'));
                            $chargenum5 = trim(poststr('khungnum'));
                                if ($chargetype5 == '') {
                                         exit('Chưa Chọn Vật Phẩm');
                                    }
                                    $find = false;
                                    $file = fopen("../charge5.txt", "r");
                                    while (!feof($file)) {
                                        $line = fgets($file);
                                        $txts = explode(';', $line);
                                        if ($txts[0] == $chargetype5) {
                                            $find = true;
                                        }
                                    }
                                    fclose($file);
                                    if ($find == false) {
                                        notiG100K(0,"Vật Phẩm Không Tồn Tại","error");
                                    }
                                    $chargenum5 = trim(poststr('khungnum'));
                                    if ($chargenum5 == '' || $chargenum5 < 0 || $chargenum5 > 1) {
                                        exit('Số Lượng 1！');
                                    }
                            
    						     $result = sendMail($url,$uid,$cookie,$chargetype5,$chargenum5,$srv_name);
    							 if ($result){
							    notiG100K(0,"Gửi Vật Phẩm Thành Công","success");
							} else {
							    notiG100K(0,"Gửi Vật Phẩm Thất Bại","error");
							}
                            break;
                            
                        case 'addczvip':
                            $pwd = trim(poststr('pwd'));
                            if ($pwd == '') {
                                exit('玩家后台的授权密码不能为空');
                            }
                            $vipfile = 'Q1806712451-' . $quid . '.json';
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
                                $vipjson[$uid] = array('pwd' => $pwd, 'level' => 0, 'quid' => $quid);
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
                            $vipfile = 'Q1806712451-' . $quid . '.json';
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
                                $vipjson[$uid] = array('pwd' => $pwd, 'level' => 1, 'quid' => $quid);
                                file_put_contents($vipfile, json_encode($vipjson, 320));
                                exit('加入或升级VIP成功.');
                            } else {
                                exit('该角色名已经是VIP了.');
                            }
                        break;
                        case 'quxiaovip':
                            $vipfile = 'Q1806712451-' . $quid . '.json';
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
                            $data = array("key" => $token, "time" => $time, "type" => 'queryrole', "roleid" => $uid, "port" => $port, "ip" => $ip);
                            $rest = get($url, $data);
                            if (strstr($rest, 'success') == false) {
                                exit('校验失败');
                            }
                            $pwd = trim(poststr('pwd'));
                            if ($pwd == '') {
                                exit('玩家后台的授权密码不能为空');
                            }
                            $vipfile = 'Q1806712451-' . $quid . '.json';
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
                                exit('该角色名并未授权.');
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
