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
    mysqli_query("set names 'utf8'");
    mysqli_select_db($dbname, $con);
    $sql = "SELECT * FROM `$dbname`.`t_u_player` where `account`='$account' and `server_id`='$sid' limit 1";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    $uid = $row['player_id'];
    $activated = $row['delete_mark'];
    if(!$uid) {
        notiG100K(0,"Tài Khoản Không Tồn Tại !","error");
    }
    if(!$config['url']){
        notiG100K(0,"Không có cài đặt url !","error");
    }
    if ($checknum == $gmcode) {
        if ($quid >= 1 || $quid != '') {
            if ($account != '') {
                if ($_POST['type']) {
                    $type = trim($_POST['type']);
                    switch ($type) {
                        //Charge
                        case 'charge':
                            $recharge_id = intval($_POST['chargenum']);
                            $data = array(
                                'channel'=>0,
                                //'id'=>129,
                                'number'=>1,
                                'rechargeId'=>$recharge_id,
                                'roleId'=>$uid
                            );
                            $rtn=post($config['url'].'recharge/manual.do',$data);
                            $rtn=json_decode($rtn,true);
                            if($rtn['status']==0){
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
                            if($num<1 || $num>99999999){
                                notiG100K(0,"Số lượng: 1-99999999","error");
                            }
                            $bt = 'G100K - TOOLS VIP';
                            //$goods="1,".$itemid.",".$num;
                            $goods = $itemid.",".$num;
                            $data = array(
                                'target'=>$uid,
                                'mailInfo'=>array(
                                    'attach'=>$goods,
                                    'title'=>'G100K - TOOLS VIP',
                                    'outline'=>$bt,
                                    'content'=>$bt
                                )
                            );
                            if ($activated == 1) {
                                $rtn = post($config['url'] . 'mbean/mail/to_player.do?t=' . time(), $data);
                                $rtn = json_decode($rtn, true);
                                if ($rtn['status'] == 0) {
                                    notiG100K(0, "Gửi Thành Công", "success");

                                } else {
                                    notiG100K(0, "Gửi thất bại", "error");
                                }
                            } else {
                                notiG100K(0, "Chưa Kích Hoạt Tools", "error");
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
