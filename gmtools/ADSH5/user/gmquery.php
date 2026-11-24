<?php
include 'config.php';
if ($_POST) {
    $checknum = "g100k";
    $quid = trim(poststr('qu'));
    $qu = $quarr [$quid];
    $uid = trim(poststr('uid'));
    $dbname = $qu ['db_name'];
    $dbname1 = $qu ['db_name1'];
    $prefix = $qu ['prefix'];
    $prebs = $qu ['prebs'];
    $url = $qu ['url'];
    $time = time();
    if ($checknum == $gmcode) {
        if ($quid >= 1) {
            if ($uid != '') {
                $sql = "SELECT * FROM `sdk`.`users` where `username`='$uid' limit 1";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                $activate = $row ['activate'];
                if ($row['userId'] != '') {
                    if ($_POST ['type']) {
                        $type = trim($_POST ['type']);
                        switch ($type) {
                            case 'AddXu' :
                                if ($activate == 1) {
                                    	$chargenum = trim($_POST['coin']);
        								$sql = "UPDATE `sdk`.`users` SET `rmb` = rmb + $chargenum WHERE `username` = '$uid'";
        								$result = mysqli_query($conn, $sql);
        								if ($result != 0) {
        								    notiG100K(0, "Cộng Xu Thành Công111!", "success");
        								}else{
        									notiG100K(0, "Cộng Xu Thất Bại!", "error");
        								}
                                } else {
                                    notiG100K(0, "Chưa Mua Tools ! Vui Lòng Truy Cập G100K.NET Để Mua!", "error");
                                }
                                break;

                            case 'ClearMail' :
                                $userId = $row['userId'];
                                $sql = "SELECT * FROM `$dbname`.`player_login` where `accname`='$userId' limit 1";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_array($result);
                                if ($row['id'] != '') {
                                    $role_id = $row['id'];
                                    $sql = "DELETE FROM  `$dbname`.`mail_attr`  WHERE `rid` = '$role_id'";
        								$result = mysqli_query($conn, $sql);
        								if ($result != 0) {
        								    notiG100K(0, "Xóa Thư Thành Công!", "success");
        								}else{
        									notiG100K(0, "Xóa Thư Thất Bại!", "error");
        									//notiG100K(0, $sql, "error");
        								}
                                } else {
                                    notiG100K(0, "Chưa Tạo Nhân Vật!11", "error");
                                }
                                break;
                            case 'ClearItem' :
                                $userId = $row['userId'];
                                $sql = "SELECT * FROM `$dbname`.`player_login` where `accname`='$userId' limit 1";
                                 notiG100K(0, "Không hỗ trợ xóa balo!", "success");
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_array($result);
                                if ($row['id'] != '') {
                                    $role_id = $row['id'];
                                    $sql = "DELETE FROM  `$dbname`.`goods_high`  WHERE `pid` = '$role_id' AND `location` = '4'";
        								$result = mysqli_query($conn, $sql);
        								if ($result != 0) {
        								    notiG100K(0, "Xóa Vật Phẩm Thành Công!", "success");
        								}else{
        									notiG100K(0, "Xóa Vật Phẩm Thất Bại!", "error");
        									//notiG100K(0, $sql, "error");
        								}
                                } else {
                                    notiG100K(0, "Chưa Tạo Nhân Vật!", "error");
                                }
                                break;
                            case 'charge' :
                                $userId = $row['userId'];
                                $sql = "SELECT * FROM `$dbname`.`player_login` where `accname`='$userId' limit 1";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_array($result);
                                if ($row['id'] != '') {
    								$role_id = $row['id'];
    								$mailid = trim(poststr('chargetype'));
    								$mailnum = trim(poststr('chargenum'));
    								$mailtype = "0";
    								$item = "[{".$mailtype.",".$mailid.",".$mailnum."}]";
    								$url = $url."test.php";
    								$post = array("uid" => $userId, "role_id" => $role_id, "server_id" => $quid, "type" => 3, "title" => "G100K - TOOLS FREE", "content" => "G100K - TOOLS FREE", "special_attachment" => $item);
                                    $ch = curl_init($url); 
    								curl_setopt($ch, CURLOPT_POST, 1);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                    $content = curl_exec($ch);
    								curl_close($ch);  
    								if (strpos($content, 'success')) {
    									 notiG100K(0, "Gửi Thành Công", "success");
    								}else{
    									notiG100K(0, $url, "error");
    								}
    							}else{
    								mysqli_close($con);
    								 notiG100K(0, "Chưa Tạo Nhân Vật!", "error");	
    							}	
                                break;
                            case 'daoju' :
                                if ($activate == 0) {
                                    notiG100K(0, "Chưa Mua Tools ! Vui Lòng Truy Cập G100K.NET Để Mua!", "error");
                                }
                                $userId = $row['userId'];
                                $sql = "SELECT * FROM `$dbname`.`player_login` where `accname`='$userId' limit 1";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_array($result);
                                if ($row['id'] != '') {
    								$role_id = $row['id'];
    								$mailid = trim(poststr('mailid'));
    								$mailnum = trim(poststr('mailnum'));
    								$mailtype = "0";
    								$item = "[{".$mailtype.",".$mailid.",".$mailnum."}]";
    								$url = $url."test.php";
    								$post = array("uid" => $userId, "role_id" => $role_id, "server_id" => $quid, "type" => 3, "title" => "G100K - TOOLS VIPS", "content" => "G100K - TOOLS VIPS", "special_attachment" => $item);
                                    $ch = curl_init($url); 
    								curl_setopt($ch, CURLOPT_POST, 1);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                    $content = curl_exec($ch);
    								curl_close($ch);  
    								if (strpos($content, 'success')) {
    									 notiG100K(0, "Gửi Thành Công", "success");
    								}else{
    									notiG100K(0, $url, "error");
    								}
    							}else{
    								mysqli_close($con);
    								 notiG100K(0, "Chưa Tạo Nhân Vật!", "error");	
    							}	
                                break;
                            default :
                                notiG100K(0, "Chức Năng Không Tồn Tại !!!", "error");
                                break;
                        }
                    } else {
                        notiG100K(0, "Loại được yêu cầu không tồn tại!", "error");
                    }
                } else {
                    notiG100K(0, "Nhân vật không tồn tại!", "error");
                }
            } else {
                notiG100K(0, "Sai ID!", "error");
            }
        } else {
            notiG100K(0, "Lỗi máy chủ!", "error");
        }
    } else {
        notiG100K(0, "Sai mã GM!", "error");
    }
} else {
    notiG100K(0, "Bug Con Cặc !", "error");
}