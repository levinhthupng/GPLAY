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
    $sql = "SELECT * FROM `$dbname`.`user` where `userid`='$account' limit 1";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);
    $activate = $row['activate'];
    if ($checknum == $gmcode) {
        if ($quid >= 1 || $quid != '') {
            if ($account != '') {
                if ($_POST['type']) {
                    $type = trim($_POST['type']);
                    switch ($type) {
                        case 'charge':
                            $chargeid = intval($_POST['chargeid']);
                            $chargenum = intval($_POST['chargenum']);
                            $code = "[[1,$chargeid,$chargenum]]";
                            $data = [
                                'uuid' => $account,  //角色id
                                'token' => '000',
                                'version' => '0.1.94',
                                'time' => '1737438754',
                                'params' => $code  //物品列表  类型，id，数量
                            ];		
                            //notiG100K(0,"Nạp Thất Bại !","error");		
                            $url = 'http://139.59.253.81:3030/mail/add';
                            $result = sendPostRequest($url, $data);
                            
                            //$response = ['status' => 'success', 'message' => '充值成功！', 'data' => $result];
                			//notiG100K(0,$result,"success");
                			//判断一下result是否返回{"msg":"success","code":0}
                			$response = ['status' => 'success', 'message' => '充值成功！', 'data' => $result];
                			//echo json_encode($response);
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
                            if($num<1 || $num>99999999999){
                                notiG100K(0,"Số lượng: 1-99999999999","error");
                            }
                            
                            $code = "[[1,$itemid,$num]]";
                            if ($activate == 1) {
                                $data = [
                                'uuid' => $account,  //角色id
                                'token' => '000',
                                'version' => '0.1.94',
                                'time' => '1737438754',
                                'params' => $code  //物品列表  类型，id，数量
                                ];		
                                //notiG100K(0,"Nạp Thất Bại !","error");		
                                $url = 'http://139.59.253.81:3030/mail/add';
                                $result = sendPostRequest($url, $data);
                                if ($rtn['status'] == 0) {
                                    notiG100K(0, "Gửi Thành Công", "success");

                                } else {
                                    notiG100K(0, "Gửi thất bại", "error");
                                }
                            } else {
                                notiG100K(0, "Chưa Kích Hoạt Tools !!!", "error");
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
