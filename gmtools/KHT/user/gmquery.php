<?php
function notiG100K($status, $msg, $type)
{
    $json = [
        'status' => $status,
        'msg' => $msg,
        'type' => $type
    ];
    exit(json_encode($json));
}

// include 'config.php';
$gmcode = "29082000";
$quarr = array(
    "1" => array(
        "zoneid" => 1,
        "host" => "209.97.174.196",
        "dbname" => "session1",
        "extdbname" => "extgame1",
        "user" => "hk20",
        "pwd" => "12082001Lvt",
        "name" => "Server 1",
        "hidde" => false
    ),
    "2" => array(
        "zoneid" => 2,
        "host" => "209.97.174.196",
        "dbname" => "session2",
        "extdbname" => "extgame1",
        "user" => "hk20",
        "pwd" => "12082001Lvt",
        "name" => "Server 2",
        "hidde" => false
    ),
    "3" => array(
        "zoneid" => 3,
        "host" => "209.97.174.196",
        "dbname" => "session3",
        "extdbname" => "extgame1",
        "user" => "hk20",
        "pwd" => "12082001Lvt",
        "name" => "Server 3",
        "hidde" => false
    ),
);

function poststr($str)
{
    if (isset($_POST[$str])) {
        return $_POST[$str];
    }
    notiG100K(0, "Chức Năng Không Tồn Tại!", "error");
}

if ($_POST) {
    $quid = trim($_POST['qu']);
    $qu = $quarr[$quid];
    $extdbname = $qu['extdbname'];
    $uid = trim($_POST['uid']);
    // $gid = $qu['gid'];
    // $manageurl = $qu['manageurl'];
    $dbip = $qu['host'];
    $dbname = $qu['dbname'];
    $dbuser = $qu['user'];
    $dbpwd = $qu['pwd'];
    $quname = $qu['name'];
    if ($quid >= 1) {
        if ($uid != '') {
            if ($_POST['type']) {
                $type = trim($_POST['type']);
                // $pswd = trim($_POST['pswd']);

                switch ($type) {
                    case 'charge':
                        $title = 'G100K - TOOLS FREE';
                        $content = 'G100K - TOOLS FREE';
                        $chargetype = trim($_POST['chargetype']);
                        $find = false;
                        $file = fopen("../pay.txt", "r");
                        while (!feof($file)) {
                            $line = fgets($file);
                            $txts = explode(';', $line);
                            if ($txts[0] == $chargetype) {
                                $find = true;
                            }
                        }
                        fclose($file);
                        if ($find == false) {
                            notiG100K(0, "Vật Phẩm Không Tồn Tại!", "error");
                        }
                        $chargenum = trim($_POST['chargenum']);
                        if ($chargenum == '' || $chargenum < 0 || $chargenum > 2000000000) {
                            notiG100K(0, "Số Lượng Quá Lớn!", "error");
                        }

                        $con = @mysqli_connect($dbip, $dbuser, $dbpwd, $dbname);
                        if (mysqli_connect_errno()) {
                            notiG100K(0, "Server Đã Đóng !!!", "error");
                            exit;
                        }

                        mysqli_select_db($con, $dbname);
                        $sql = "select * from `charbase` where  `NAME` = '$uid' limit 1";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                       // notiG100K(0, $sql, "error");
                        $roleid = $row['CHARID'];
                        $rolename = $row['NAME'];
                        if ($roleid != '') {
                            $res = mysqli_query($con, "insert into `gift` (`CHARID`,`ZONE`,`NAME`,`ITEMID1`,`ITEMID2`,`ITEMID3`,`ITEMNUM1`,`ITEMNUM2`,`ITEMNUM3`,`BIND1`,`BIND2`,`BIND3`,`MAILFROM`,`MAILTITLE`,`MAILTEXT`) values('$roleid', '" . $qu['zoneid'] . "','$rolename','$chargetype','0','0','$chargenum','0','0','1','0','0','G100K','$title','$content')");
                            $SN = md5(uniqid(rand(), true));
                            $OptTimeStamp = time();
                            $gm_code = 'loadgift';
                            $Command = ltrim($gm_code, '/');
                            $CmdLength = strlen($Command);
                            $sql = "insert into `" . $extdbname . "`.`gm_command` (SN,FromIP,ServerID,Command,Status,OptTimeStamp,FlagId,CmdLength,ADMIN) values('" . $SN . "','64.56.71.79','" . $qu['zoneid'] . "','" . $gm_code . "','1','" . $OptTimeStamp . "','" . $OptTimeStamp . "','" . $CmdLength . "','admin')";
                            $result = mysqli_query($con, $sql);
                            mysqli_close($con);
                            if ($result) {
                                notiG100K(0, "Nạp Free Thành Công", "success");
                            } else {
                                notiG100K(0, "Nạp Free Thất Bại", "error");
                            }
                        } else {
                            notiG100K(0, "Nhân Vật " . $rolename . " Không Tồn Tại !", "error");
                        }
                        break;
                    case 'daoju':
                        $title = 'G100K - TOOLS VIP';
                        $content = 'G100K - TOOLS VIP';
                        $chargetype = trim($_POST['mailid']);
                        $find = false;
                        $file = fopen("../item.txt", "r");
                        while (!feof($file)) {
                            $line = fgets($file);
                            $txts = explode(';', $line);
                            if ($txts[0] == $chargetype) {
                                $find = true;
                            }
                        }
                        fclose($file);
                        if ($find == false) {
                            notiG100K(0, "Vật Phẩm Không Tồn Tại!", "error");
                        }
                        $chargenum = trim($_POST['mailnum']);
                        if ($chargenum == '' || $chargenum < 0 || $chargenum > 2000000000) {
                            notiG100K(0, "Số Lượng Quá Lớn!", "error");
                        }
                        $con = @mysqli_connect($dbip, $dbuser, $dbpwd, $dbname);
                        if (mysqli_connect_errno()) {
                            notiG100K(0, "Server Đã Đóng !!!", "error");
                            exit;
                        }
                        mysqli_select_db($con, $dbname);
                        $sql = "select * from `charbase` where  `NAME` = '$uid' limit 1";
                        $result = mysqli_query($con, $sql);

                        $row = mysqli_fetch_array($result);


                        $roleid = $row['CHARID'];
                        $rolename = $row['NAME'];
                        $activate = $row['ACTIVATE'];
                        if ($roleid != '') {
                            if ($activate == 1) {
                                $res = mysqli_query($con, "insert into `gift` (`CHARID`,`ZONE`,`NAME`,`ITEMID1`,`ITEMID2`,`ITEMID3`,`ITEMNUM1`,`ITEMNUM2`,`ITEMNUM3`,`BIND1`,`BIND2`,`BIND3`,`MAILFROM`,`MAILTITLE`,`MAILTEXT`) values('$roleid', '" . $qu['zoneid'] . "','$rolename','$chargetype','0','0','$chargenum','0','0','1','0','0','G100K','$title','$content')");
                                $SN = md5(uniqid(rand(), true));
                                $OptTimeStamp = time();
                                $gm_code = 'loadgift';
                                $Command = ltrim($gm_code, '/');
                                $CmdLength = strlen($Command);
                                $sql = "insert into `" . $extdbname . "`.`gm_command` (SN,FromIP,ServerID,Command,Status,OptTimeStamp,FlagId,CmdLength,ADMIN) values('" . $SN . "','64.56.71.79','" . $qu['zoneid'] . "','" . $gm_code . "','1','" . $OptTimeStamp . "','" . $OptTimeStamp . "','" . $CmdLength . "','admin')";
                                $result = mysqli_query($con, $sql);
                                mysqli_close($con);;
                                if ($result) {
                                    notiG100K(0, "Gửi Vật Phẩm Thành Công", "success");
                                } else {
                                    notiG100K(0, "Gửi Vật Phẩm Thất Bại", "error");
                                }
                            } else {
                                notiG100K(0, "Chưa Mua Tools", "error");
                            }
                        } else {
                            notiG100K(0, "Nhân Vật " . $rolename . " Không Tồn Tại !", "error");
                        }
                        break;
                    default:
                        notiG100K(0, "Chức Năng Đang Cập Nhật !!!", "error");
                        break;
                }
            } else {
                notiG100K(0, "Chức Năng Không Tồn Tại !!!", "error");
            }
        } else {
            notiG100K(0, "Chưa Nhập Tên Nhân Vật !!!", "error");
        }
    } else {
        notiG100K(0, "Server Không Tồn Tại !!!", "error");
    }
} else {
    notiG100K(0, "Bug Con Cặc!" . mysqli_connect_error(), "error");
}
