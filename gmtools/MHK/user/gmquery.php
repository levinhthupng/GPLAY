<?php
error_reporting(0);
include "config.php";
function notiG100K($status, $msg, $type) {
    $json = [
        'status' => $status,
        'msg' => $msg,
        'type' => $type
    ];
    exit(json_encode($json));
}
$key = 'mhj898225422dff56';
$type = $_POST['type'];
$account = $_POST['uid'];
$qu = $_POST['qu'];
$conn = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME, DBPORT) or notiG100K(0,"Server Bảo Trì!","error");
$conn->query('set names utf8');
$sql = "select * from `account` where `username`='$account'";
$result = $conn->query($sql);
$row = $result->fetch_array();
$activate = $row['fuli'];

switch ($type) {
    case 'AddXu' :
        if ($activate == 1) {
            $coin = $_POST['coin'];
            $sql = "UPDATE `account`.`account` SET `money` = `money` + '$coin'  WHERE   username='{$account}' ;";
            if ($conn->query($sql)) {
                notiG100K(0, "Cộng Xu Thành Công","success");
            } else {
                notiG100K(0, "Cộng Xu Thất Bại","error");
            }
            mysqli_close($conn);

        } else {
            notiG100K(0, "Chưa Mua Tools ! Vui Lòng Truy Cập G100K.NET Để Mua!","error");
        }
        break;
    case 'ClearItem' :
        $sql2 = "SELECT * FROM `game_1000001`.`character` WHERE `account`='{$account}'";
        $result1 = $conn->query($sql2);
        $row1 = $result1->fetch_array();
        $xuid = $row1['characterid'];
        if ($xuid == '') {
            exit ("Tài Khoản Không Tồn Tại！");
        } else {
            $sql3 = "DELETE FROM `game_1000001`.`equipment` WHERE `characterid` = {$xuid}";
            $conn->query($sql3);
            if (($conn->query($sql3))) {
                notiG100K(0,"Xóa đạo cụ thành công: online sau 5 phút !","success");
            } else {
                notiG100K(0,"Xóa đạo cụ thất bại !","error");
            }
            mysql_close($conn);
        }
    case 'charge':
        $chargenum = $_POST['chargenum'];
        $chargeid = $_POST['charetype'];
        $userid = $_POST['uid'];
        $serverId = $qu + 1000000;
        $chargeid = $chargeid . "#" . $chargenum;
        $title = "G100K - TOOLS FREE";
        $content = "G100K - TOOLS FREE";
        $sign = md5($userid . $serverId . $key);
        $url = $gmip . "Callback/h5mail";  // 替换为实际的目标网址

        $postFields = array(
            'userid' => $userid,
            'roleid' => $roleid,
            'roleName' => $roleName,
            'serverId' => $serverId,
            'item' => $chargeid,
            'title' => $title,
            'content' => $content,
            'sign' => $sign,
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);
        if ($response == 1) {
            notiG100K(0,"Nạp Free Thành Công !","success");
        } else {
            notiG100K(0,"Nạp Free Thất Bại !","error");
        }
        break;

    case 'daoju':
        $mailnum = $_POST['mailnum'];
        $mailid = $_POST['mailid'];
        $userid = $_POST['uid'];
        $serverId = $qu + 1000000;
        $mailid = $mailid . "#" . $mailnum;
        $title = "G100K - TOOLS VIP";
        $content = "G100K - TOOLS VIP";
        $sign = md5($userid . $serverId . $key);
        $url = $gmip . "Callback/h5mail";  // 替换为实际的目标网址

        if ($activate == 0) {
            notiG100K(0,"Chưa Mua Tools !","error");
        } else {
            $postFields = array(
                'userid' => $userid,
                'roleid' => $roleid,
                'roleName' => $roleName,
                'serverId' => $serverId,
                'item' => $mailid,
                'title' => $title,
                'content' => $content,
                'sign' => $sign,
            );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            if ($response == 1) {
                notiG100K(0,"Gửi Vật Phẩm Thành Công !","success");
            } else {
                notiG100K(0,"Gửi Vật Phẩm Thất Bại !","error");
            }
        }

        break;
    default:
        break;
}
?>