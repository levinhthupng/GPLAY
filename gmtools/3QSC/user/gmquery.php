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
function getCookiesFromLogin($url, $post_data = null, $headers = []) {
    // Khởi tạo cURL
    $curl = curl_init($url);

    // Cấu hình cURL
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Lấy kết quả trả về
    curl_setopt($curl, CURLOPT_HEADER, true); // Bao gồm header trong phản hồi
    curl_setopt($curl, CURLOPT_POST, true); // Gửi POST request
    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data); // Dữ liệu gửi POST
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); // Headers bổ sung
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // Bỏ qua SSL (nếu cần)
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    // Thực hiện yêu cầu
    $response = curl_exec($curl);

    // Kiểm tra lỗi cURL
    if (curl_errno($curl)) {
        echo 'CURL Error: ' . curl_error($curl);
        curl_close($curl);
        return null;
    }

    // Tách phần header và body
    $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE); // Kích thước header
    $header = substr($response, 0, $header_size); // Phần header
    $body = substr($response, $header_size); // Phần body

    curl_close($curl);

    // Lấy cookie từ header
    preg_match_all('/Set-Cookie:\s*([^;]*)/mi', $header, $matches);
    $cookies = implode('; ', $matches[1]); // Gộp cookie thành chuỗi

    // Trả về cookie và body phản hồi
    return [
        'cookies' => $cookies,
        'response' => $body
    ];
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
                                notiG100K(0,"Nhân Vật $uid Không Tồn tại!","error");
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
                         $sql = "SELECT * FROM `$dbname`.`player` where `name`= '$uid' limit 1";
                         
                        $result = mysqli_query($con,$sql);
                        $row = mysqli_fetch_array($result);
                        mysqli_close($con);
                        if ($row['id'] != '') {
                            $url = "http://152.42.213.236:8080/sangogm/login?data=%7B%22username%22%3A%22admin%22%2C%22pwd%22%3A%22youningdaxia.com%22%7D";
                            $headers = [
                                "Content-Type: application/x-www-form-urlencoded",
                                "referer: http://152.42.213.236:8080/sangogm/jsp/login.jsp",
                                "Content-Length: 0",
                            ];
                            $post_data = null; // Có thể thêm dữ liệu POST nếu cần
                            
                            $result = getCookiesFromLogin($url, $post_data, $headers);
                            
                            if ($result) {
                                $cookie = $result['cookies'];
                            } else {
                                notiG100K(0,"Đăng nhập thất bại hoặc lỗi cURL!","error");
                            }
                            $role_id = $row['id'];
                            $title = "OKEM";
                            $content = "OKEM";
                            $queryString = [
                                "submitData" => '{"serverId":'.$svid.',"serverName":"S1","ids":"'.$role_id.'","reason":"okme","title":"G100K - TOOLS FREE","content":"G100K - TOOLS FREE","moneynum":"999999","jewelnum":"999999","expnum":"999999","vitalitynum":"999999","staminanum":"999999","warriorspiritnum":"999999","spiritjadenum":"999999","honor":"999999","prestige":"999999","battleSoul":"999999","normalItemNum1":"999","normalItemNum2":"0","normalItemNum3":"0","normalItemNum4":"0","debrisItemNum1":"0","debrisItemNum2":"0","debrisItemNum3":"0","debrisItemNum4":"0","heroItemNum1":"0","heroItemNum2":"0","heroItemNum3":"0","heroItemNum4":"0","equipItemNum1":"0","equipItemNum2":"0","equipItemNum3":"0","equipItemNum4":"0","treasureItemNum1":"0","treasureItemNum2":"0","treasureItemNum3":"0","treasureItemNum4":"0"}',
                                "opt" => 1,
                                "playerType" => 1,
                                "heroItem" => -1,
                                "normalItem" => -1,
                                "debrisItem" => -1,
                                "equipItem" => -1,
                                "treasureItem" => -1
                            ];
                            $post = http_build_query($queryString);
                            $url = $manageurl . "additem?".$post;
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $headers = array(
                                "cookie: $cookie",
                                "Content-Type: application/x-www-form-urlencoded",
                                "Content-Length: 0",
                            );
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            $content = curl_exec($ch);
                            if($content == '操作成功'){
									notiG100K(0,"Nạp Free Thành Công!","success");
								}else{
									notiG100K(0,"Nạp Free Thất Bại ! Thử Lại Sau 5s","error");
								}
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
                            $mailnum = trim(poststr('mailnum'));
                            if ($mailnum == '' || $mailnum < 0 || $mailnum > 999) {
                                notiG100K(0,"Số Lượng Từ 0-999!","error");
                            }
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0,"Server Bảo Trì!","error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                             $sql = "SELECT * FROM `$dbname`.`player` where `name`= '$uid' limit 1";
                             
                            $result = mysqli_query($con,$sql);
                            $row = mysqli_fetch_array($result);
                            //notiG100K(0,$sql,"error");
                            
							mysqli_close($con);
							if ($row['yuanbao'] == 1) {
							    
							
                            if ($row['id'] != '') {
                            $url = "http://152.42.213.236:8080/sangogm/login?data=%7B%22username%22%3A%22admin%22%2C%22pwd%22%3A%22youningdaxia.com%22%7D";
                            $headers = [
                                "Content-Type: application/x-www-form-urlencoded",
                                "referer: http://152.42.213.236:8080/sangogm/jsp/login.jsp",
                                "Content-Length: 0",
                            ];
                            $post_data = null; // Có thể thêm dữ liệu POST nếu cần
                            
                            $result = getCookiesFromLogin($url, $post_data, $headers);
                            
                            if ($result) {
                                $cookie = $result['cookies'];
                            } else {
                                notiG100K(0,"Đăng nhập thất bại hoặc lỗi cURL!","error");
                            }
                            $role_id = $row['id'];
                            $title = "OKEM";
                            $content = "OKEM";
                            $data = [
                                "submitData" => '{"serverId":'.$svid.',"serverName":"S1","ids":"'.$role_id.'","reason":"1","title":"G100K - TOOLS VIP","content":"G100K - TOOLS VIP","moneynum":"1","jewelnum":"0","expnum":"0","vitalitynum":"0","staminanum":"0","warriorspiritnum":"0","spiritjadenum":"0","honor":"0","prestige":"0","battleSoul":"0","normalItemNum1":"'.$mailnum.'","normalItemNum2":"0","normalItemNum3":"0","normalItemNum4":"0","debrisItemNum1":"0","debrisItemNum2":"0","debrisItemNum3":"0","debrisItemNum4":"0","heroItemNum1":"0","heroItemNum2":"0","heroItemNum3":"0","heroItemNum4":"0","equipItemNum1":"0","equipItemNum2":"0","equipItemNum3":"0","equipItemNum4":"0","treasureItemNum1":"0","treasureItemNum2":"0","treasureItemNum3":"0","treasureItemNum4":"0"}',
                                "heroItem" => [-1, -1, -1, -1],
                                "normalItem" => [$mailid, -1, -1, -1],
                                "debrisItem" => [-1, -1, -1, -1],
                                "equipItem" => [-1, -1, -1, -1],
                                "treasureItem" => [-1, -1, -1, -1],
                                "opt" => 1,
                                "playerType" => 1
                            ];
                            $query = '';
                            foreach ($data as $key => $value) {
                                if (is_array($value)) {
                                    foreach ($value as $val) {
                                        $query .= urlencode($key) . '=' . urlencode($val) . '&';
                                    }
                                } else {
                                    $query .= urlencode($key) . '=' . urlencode($value) . '&';
                                }
                            }
                            
                            $query = rtrim($query, '&');
                            $url = "http://152.42.213.236:8080/sangogm/additem?".$query;
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $headers = array(
                                "cookie: $cookie",
                            );
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            $content = curl_exec($ch);
                            if($content == '操作成功'){
									notiG100K(0,"Gửi Vật Phẩm Thành Công!","success");
								}else{
									notiG100K(0,"Gửi Vật Phẩm Thất Bại! Thử Lại Sau 5s","error");
								}
                            } else {
                                notiG100K(0,"Nhân Vật $uid Không Tồn tại!","error");
                            }
							} else {
							    notiG100K(0,"Nhân Vật $uid Chưa Mua Tools!","error");
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
