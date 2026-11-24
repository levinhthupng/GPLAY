<?php
include 'config.php';
if ($_POST) {
    $checknum = 'toandaik';
    $quid = trim(poststr('qu'));
    $config = $quarr[$quid];
    $account = trim(poststr('uid'));
    $sid = $config['id'];
    $dbname = $config['db_name'];
    $con = @mysqli_connect($config_mysql['db_host'], $config_mysql['db_user'], $config_mysql['db_pass']) or notiG100K(0,"Server đã đóng!","error");
    $mysql = mysqli_connect($PZ['DB_HOST'],$PZ['DB_USER'],$PZ['DB_PWD'],$PZ['DB_NAME'],$PZ['DB_PORT']) or notiG100K(0,"Server đã đóng!","error");
    mysqli_query("set names 'utf8'");
    mysqli_select_db($dbname, $con);
    $sql = "SELECT * FROM `tzj_login`.`rolelogin` WHERE `roleName` = '$account' and `serverId`= '$sid' limit 1";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    $activate = $row['activate'];
    $roleid = $row['roleId'];
    if ($roleid== null){
        notiG100K(0,"Nhân Vật ".$sql." Không Tồn Tại","success");
    }
    if ($checknum == $gmcode) {
        if ($quid >= 1 || $quid != '') {
            if ($account != '') {
                if ($_POST['type']) {
                    $type = trim($_POST['type']);
                    switch ($type) {
                        case 'charge':
                            $chargeid = intval($_POST['chargeid']);
                            $chargenum = intval($_POST['chargenum']);
                          //  notiG100K(0,$roleid,"success");
                            $re = gmmail($sid, $roleid,$chargeid,$chargenum,$mysql);
                            $data = json_decode($re);
                            if($data->ok === true){
                                notiG100K(0,"Nạp Free Thành Công","success");
                            }else{
                                notiG100K(0,"Nạp Thất Bại !","error");
                            }

                            break;
                        //Send Mail
                        case 'mail':
                            $itemid = trim($_POST['mailid']);
                            $num = intval($_POST['mailnum']);

                            if(!$itemid){
                                notiG100K(0,"Vật Phẩm Không Tồn Tại","error");
                            }
                            if($num<1 || $num>99999999999){
                                notiG100K(0,"Số lượng: 1-99999999999","error");
                            }

                            if ($activate == 1) {
                                $re = gmmail($sid, $roleid,$itemid,$num,$mysql);
                                $data = json_decode($re);
                                if($data->ok === true){
                                    notiG100K(0, "Gửi Thành Công", "success");

                                } else {
                                    notiG100K(0, "Gửi thất bại", "error");
                                }
                            } else {
                                notiG100K(0, "Chưa Mua Tools !!!", "error");
                            }
                            break;
                        default:
                            notiG100K(0,"Chức Năng Không Tồn tại","error");
                            break;
                    }
                } else {
                    notiG100K(0,"Loại yêu cầu không tồn tại!","error");
                }
            } else {
                notiG100K(0,"Nhập tài khoản","error");
            }
        } else {
            notiG100K(0,"Chọn máy chủ","error");
        }
    } else {
        notiG100K(0,"Mã GM sai","error");
    }
} else {
    notiG100K(0,"Yêu cầu bất hợp pháp!","error");
}