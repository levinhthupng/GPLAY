<?php
include 'config.php';
header("Content-type: text/html; charset=utf8");
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
                    apiLogin();
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
					        $rechargeId = trim(poststr('chargetype'));
    							if ($rechargeId == '') {
                                        notiG100K(0,"Chưa Chọn Vật Phẩm!","error");
                                    }
                            $rechargenum = trim(poststr('chargenum'));
                            if ($rechargenum == '' || $rechargenum < 0 || $rechargenum > 1000000) {
                                notiG100K(0,"Số Lượng Từ 0-1000000!","error");
                            }
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0,"Server Bảo Trì!","error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                            $sql="select * from $dbname.role where userid='".$uid."'";
                            $result = mysqli_query($con,$sql);
                            $row = mysqli_fetch_array($result);
                            mysqli_close($con);
                            $roleId = $row['id'];
                            if ($roleId != '') {
                                    $tokenFile = 'login_info.txt';
                                    $tokenData = json_decode(file_get_contents($tokenFile), true);
                                    
                                    // 使用accessToken进行后续请求
                                    $urldaoju = "http://146.190.83.72:668/api/games-mgr/sendEmail";
                                    
                                    $datadaoju = [
                                        'content' => "G100K.NET - TOOLS GM VIP",
                                        'gameId' => 1,
                                        'items' => [
                                            ['i' => $rechargeId, 'n' => $rechargenum]
                                        ],
                                        'key' => "123",
                                        'owner' => $roleId,
                                        'sender' => "qiqi",
                                        'serverid' => 1,
                                        'title' => "G100K"
                                    ];
                                    
                                    // 初始化cURL会话
                                    $chdaoju = curl_init();
                                    // 设置cURL选项
                                    curl_setopt($chdaoju, CURLOPT_URL, $urldaoju);
                                    curl_setopt($chdaoju, CURLOPT_POST, true);
                                    curl_setopt($chdaoju, CURLOPT_POSTFIELDS, json_encode($datadaoju));
                                    curl_setopt($chdaoju, CURLOPT_RETURNTRANSFER, true);
                                    curl_setopt($chdaoju, CURLOPT_HTTPHEADER, [
                                        'Content-Type: application/json',
                                        'Authorization: Bearer ' . $tokenData['accessToken'], // 使用accessToken
                                    ]);
                                    
                                    // 执行cURL请求
                                    $responsedaoju = curl_exec($chdaoju);
                                    //var_dump($responsedaoju); die;
                                    
                                    // Decode the JSON response
                                    $responseArray = json_decode($responsedaoju, true);
                                    
                                    if (isset($responseArray['success']) && $responseArray['success'] === true) {
                                        notiG100K(0,"Gửi Vật Phẩm Thành Công!","success");
                                    } else {
                                        notiG100K(0,$responsedaoju,"error");
                                    }
                                    curl_close($chdaoju);
                            } else {
                                notiG100K(0,"Nhân Vật $uid Không Tồn tại!","error");
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
                            $mailnumyj = trim(poststr('mailnum'));
                            if ($mailnumyj == '' || $mailnumyj < 0 || $mailnumyj > 1000000) {
                                notiG100K(0,"Số Lượng Từ 0-1000000!","error");
                            }
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0,"Server Bảo Trì!","error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                            $sql="select * from $dbname.role where userid='".$uid."'";
                            $result = mysqli_query($con,$sql);
                            $row = mysqli_fetch_array($result);
                            mysqli_close($con);
                            $roleId = $row['id'];
                            $activate =  $row['isng'];
                            if ($roleId != '') {
                                    if($activate == 1 ){
                        		    $tokenFile = 'login_info.txt';
                                    $tokenData = json_decode(file_get_contents($tokenFile), true);
                                    
                                    // 使用accessToken进行后续请求
                                    $urldaoju = "http://146.190.83.72:668/api/games-mgr/sendEmail";
                                    
                                    $datadaoju = [
                                        'content' => "G100K.NET - TOOLS GM VIP",
                                        'gameId' => 1,
                                        'items' => [
                                            ['i' => $mailid, 'n' => $mailnumyj]
                                        ],
                                        'key' => "123",
                                        'owner' => $roleId,
                                        'sender' => "qiqi",
                                        'serverid' => 1,
                                        'title' => "G100K"
                                    ];
                                    
                                    // 初始化cURL会话
                                    $chdaoju = curl_init();
                                    // 设置cURL选项
                                    curl_setopt($chdaoju, CURLOPT_URL, $urldaoju);
                                    curl_setopt($chdaoju, CURLOPT_POST, true);
                                    curl_setopt($chdaoju, CURLOPT_POSTFIELDS, json_encode($datadaoju));
                                    curl_setopt($chdaoju, CURLOPT_RETURNTRANSFER, true);
                                    curl_setopt($chdaoju, CURLOPT_HTTPHEADER, [
                                        'Content-Type: application/json',
                                        'Authorization: Bearer ' . $tokenData['accessToken'], // 使用accessToken
                                    ]);
                                    
                                    // 执行cURL请求
                                    $responsedaoju = curl_exec($chdaoju);
                                    //var_dump($responsedaoju); die;
                                    
                                    // Decode the JSON response
                                    $responseArray = json_decode($responsedaoju, true);
                                    
                                    if (isset($responseArray['success']) && $responseArray['success'] === true) {
                                        notiG100K(0,"Gửi Vật Phẩm Thành Công!","success");
                                    } else {
                                        notiG100K(0,"Gửi Vật Phẩm Thất Bại!","error");
                                    }
                                    curl_close($chdaoju);
                                    } else {
                                        notiG100K(0,"Nhân Vật $uid Chưa Mua Tools!","error");
                                    }
                            } else {
                                notiG100K(0,"Nhân Vật $uid Không Tồn tại!","error");
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
