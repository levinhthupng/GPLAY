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
    
    
    if ($checknum == $gmcode) {
        if ($quid >= 1 || $quid != "") {
            if ($uid != "") {
                if ($_POST["type"]) {
                    $type = trim($_POST["type"]);
                    switch ($type) {
                        case "charge":
                            $mailid = trim(poststr("chargetype"));
                            if ($mailid == "") {
                                notiG100K(0,"Chưa Chọn Vật Phẩm","error");
                            }
                            $find = false;
                            $file = fopen("item.txt", "r");
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
                            $mailnum = trim(poststr("chargenum"));
                            if (
                                $mailnum == "" ||
                                $mailnum < 0 ||
                                $mailnum > 2000000000
                            ) {
                                notiG100K(0,"Chưa Nhập Số Lượng","error");
                            }
                            //$data = '{"world_id":1,"character_name":"$uid","mid":"1764503438","items":[{"item_id":$mailid,"amount":$mailnum,"name":"$item_name"}]}';
                           $data = json_encode([
                            "world_id" => 1,
                            "character_name" => $uid,
                            "mid" => "1764503438",
                            "items" => [
                                    [
                                        "item_id" => (int)$mailid,
                                        "amount" => (int)$mailnum,
                                        "name" => "G100K.NET - TOOLS FREE"
                                    ]
                                ]
                            ], JSON_UNESCAPED_UNICODE );
                            
                            $send = api_request($mailurl, $data, $ADMIN_COOKIE);
                            $res = json_decode($send, true);
                                if ($res['code'] == 1) {
                                    notiG100K(0,"Gửi Thành Công","success");
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

                            
                            
                            $sql = "SELECT * FROM account.role WHERE rolenAME  = '" . $uid . "'";
                            $result = mysqli_query($con, $sql);
                        
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $activate = $row["activate"];
                            } else {
                                notiG100K(0,"$uid Chưa Mua Tools","error");
                            }
                            
                            
                            $data = json_encode([
                                "world_id" => 1,
                                "character_name" => $uid,
                                "mid" => "1764503438",
                                "items" => [
                                        [
                                            "item_id" => (int)$mailid,
                                            "amount" => (int)$mailnum,
                                            "name" => "G100K.NET - TOOLS VIP"
                                        ]
                                    ]
                                ], JSON_UNESCAPED_UNICODE );
                                
                                $send = api_request($mailurl, $data, $ADMIN_COOKIE);
                                $res = json_decode($send, true);
                                    if ($res['code'] == 1) {
                                        notiG100K(0,"Gửi Thành Công","success");
                                    } else {
                                       notiG100K(0,"Gửi Thất Bại - Nhân Vật Không Tồn Tại!!","error");
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
