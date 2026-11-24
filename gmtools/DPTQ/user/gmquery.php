<?php
date_default_timezone_set("Asia/Shanghai");
include "config.php";
if ($_POST) {
    $checknum = "lyzwlkj.vip";
    $quid = trim(poststr("qu"));
    $qu = $quarr[$quid];
    $uid = $_POST["uid"];
    $gid = $qu["gid"];
    $s = $qu["zoneid"];
    $mailurl = $qu["mailurl"];
    $dbip = $qu["host"];
    $dbname = $qu["dbname"];
    $dbuser = $qu["user"];
    $dbpwd = $qu["pwd"];
    $dbport = $qu["port"];
    $quname = $qu["name"];
    $ADMIN_COOKIE = $qu["cookie"];
    //$cdknum = $_POST["cdknum"];
    $con = mysqli_connect($dbip, $dbuser, $dbpwd, $dbname, $dbport);
    // 检查连接是否成功
    if (mysqli_connect_errno()) {
        notiG100K(0,"Không Thể Kết Nối Đến Server !","error");
    }
    
    $sql = "SELECT * FROM account WHERE account  = '" . $uid . "'";
    $result = mysqli_query($con, $sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $activate = $row["activate"];
        $roleid = $row["account"];
    } else {
        notiG100K(0,"Tài Khoản $uid Không Tồn Tại !","error");
    }
   // notiG100K(0,$roleid,"error");
    
    if ($checknum == $gmcode) {
        if ($quid >= 1 || $quid != "") {
            if ($uid != "") {
                if ($_POST["type"]) {
                    $type = trim($_POST["type"]);
                    switch ($type) {
                        
                        case 'clearbag':
                            $sql = "DELETE FROM mem_coin WHERE uid='{$roleid}'";
                            $result = mysqli_query($con, $sql);
                            if ($result) {
                                notiG100K(0,"Xóa Balo Thành Công !","success");
                            } else {
                                 notiG100K(0,"Xóa Balo Thất Bại !","error");
                            }
                            break;
                        
                        
                        case "charge":
                            $mailid = intval(poststr("chargetype"));
                            if ($mailid == "") {
                                notiG100K(0,"Chưa Chọn Vật Phẩm","error");
                            }
                            $find = false;
                            $file = fopen("charge.txt", "r");
                            while (!feof($file)) {
                                $line = fgets($file);
                                $txts = explode(";", $line);
                                if ($txts[0] == $mailid) {
                                    $item_name = $txts[1];
                                    $find = true;
                                }
                            }
                            fclose($file);
                            if ($find == false) {
                               notiG100K(0,"Vật Phẩm Không Tồn Tại !","error");
                            }
                            
                            $items = $mailid;// 类型1，ID 1，数量
                            $user = queryRoleInfo($roleid);
                            $prefix = $qu['qu'] . ":" .$qu['fu'] . ":" . $user['uid'];
                                $result = sendrechargeMail($qu['qu'], $prefix,  'Nạp tiền thành công', 'Nạp tiền hậu trường thành công！', $items);
                                if ($result['success']) {
                                    if ($result['data']['result'] == 0) {
                                         notiG100K(0,"Nạp Free Thành Công","success");
                                        
                                    } else {
                                        notiG100K(0,"Nạp Thất Bại !","error");
                                    }
                                } else {
                                    notiG100K(0,"Gửi Thất Bại - Nhân Vật Không Tồn Tại!!","error");
                                }
                            
                            break;
                        case "mail":
                            
                            $mailid = trim(poststr("mailid"));
                            if ($mailid == "") {
                                notiG100K(0,"Chưa Chọn Vật Phẩm","error");
                            }
                            $find = false;
                            $file = fopen("item.txt", "r");
                            while (!feof($file)) {
                                $line = fgets($file);
                                $txts = explode(";", $line);
                                if ($txts[0] == $mailid) {
                                    $find = true;
                                }
                            }
                            fclose($file);
                            if ($find == false) {
                               notiG100K(0,"Vật Phẩm Không Tồn Tại !","error");
                            }
                            $mailnum = trim(poststr("mailnum"));
                            if (
                                $mailnum == "" ||
                                $mailnum < 0 ||
                                $mailnum > 2000000000
                            ) {
                                notiG100K(0,"Chưa Nhập Số Lượng","error");
                            }

                            $itemId = $mailid;    // 物品ID
                            $items = array(array("itemId"=>intval($itemId), "itemCount"=>intval($mailnum)));
                            $user = queryRoleInfo($roleid);
                            $prefix = $qu['qu'] . ":" .$qu['fu'] . ":" . $user['uid'];
                            if ($activate == 1) {
                            $result = sendGameMail(intval($qu['qu']), $prefix, 'G100K - TOOLS VIP', 'Server Game Private Online: G100K.NET', $items);
                            if ($result['success']) {
                                    if ($result['data']['result'] == 0) {
                                        notiG100K(0,"Gửi Vật Phẩm Thành Công","success");
                                    } else {
                                        notiG100K(0,"Gửi Vật Phẩm Thất Bại","error");
                                    }
                                } else {
                                     notiG100K(0,"Gửi Thất Bại - Nhân Vật Không Tồn Tại!!","error");
                                }
                            } else {
                                notiG100K(0,"Chưa Mua Tools !!","error");
                            }
                            break;
                        default:
                            exit("系统异常，请重试!");
                            break;
                    }
                } else {
                    exit("请求类型不存在！");
                }
            } else {
                exit("角色名错误");
            }
        } else {
            exit("区号错误");
        }
    } else {
        exit("GM码不对");
    }
} else {
    exit("非法请求!请自重");
}
