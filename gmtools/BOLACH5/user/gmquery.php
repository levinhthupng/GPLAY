<?php
include "./config.php";
error_reporting(0);
$qu = $_POST['qu'];
$sqm = '061294';
$usr = $_POST['uid'];
$bao = $_POST['chargenum'];
$num = $_POST['mailnum'];
$item = $_POST['mailid'];
$xbag = $_POST['xbag'];
$xmag = $_POST['xmag'];
$gnxz = $_POST['type'];
$rmb = $_POST['rmb'];
$gm = '061294';
$usr = str_replace(array(' ', '%'), '', $usr);
$gnxz = str_replace(array(' ', '%'), '', $gnxz);
$usr = str_replace(array(' ', '%'), '', $usr);
$qu == '' && (notiG100K(0, "Chưa Chọn Server", "error"));
$usr == '' && (notiG100K(0, "Chưa Nhập Tên Tài Khoản Game", "error"));
$gnxz == '' && (notiG100K(0, "Chưa Chọn Chức Năng", "error"));
$mysql = mysqli_connect($PZ['DB_HOST'], $PZ['DB_USER'], $PZ['DB_PWD'], $PZ['DB_NAME'], $PZ['DB_PORT']) or notiG100K(0, "Server Bảo Trì1 !", "error");
$mysql->query('set names utf8');
$xx = mysqli_fetch_assoc($mysql->query("SELECT * FROM {$PZ['DB_GAME']}.actors WHERE accountname = '$usr' limit 1"));
$xx1 = mysqli_fetch_assoc($mysql->query("SELECT * FROM h5.account WHERE account = '$usr' limit 1"));
$xx['actorid'] == '' && (notiG100K(0, "Chưa Tạo Nhân Vật !", "error"));
$xx['accountname'] == '' && (notiG100K(0, "Tài Khoản " + $usr + " Không Tồn Tại !", "error"));
$activate = $xx1['activate'];
$rid = $xx['actorid'];
$uid = $xx['accountname'];
if ($sqm != $gm) {
    notiG100K(0, "Mã GM Sai !", "error");
} else {

    if ($gnxz == "charge") {
        $bao == 0 && (notiG100K(0, "Chưa Chọn Gói Tiền Nạp !", "error"));
        $rmbid = substr($bao, 0, strrpos($bao, ","));//id
        $rmbnum = substr($bao, strripos($bao, ",") + 1);//rmb
        //充值
        $sql = "insert into {$PZ['DB_GAME']}.feecallback(serverid,openid,itemid,num,actor_id) values ('1001','{$uid}','{$rmbid}','{$rmbnum}','{$rid}')";
        if (mysqli_query($mysql, $sql)) {
            notiG100K(0, "Nạp Free Thành Công !", "success");
        } else {
            notiG100K(0, "Nạp Free Thất Bại !", "error");
        }
    } elseif ($gnxz == "daoju") {
        $item == '0' && (notiG100K(0, "Chưa Chọn Gói Tiền Nạp !", "error"));
        $find = false;
        $file = fopen("./item.txt", "r");
        while (!feof($file)) {
            $line = fgets($file);
            $txts = explode('|', $line);
            if (trim($txts[0]) == trim($item)) {
                $find = true;
                break;
            }
        }
        fclose($file);
        if ($find == false) {
            notiG100K(0, "Vật Phẩm Không Tồn Tại !", "error");
        }
        $num == '' && ($num = 1);
        if ($num > 9999) {
            notiG100K(0, "Phát Hiện Tools Số Lượng Lớn. 1 lần nữa Sẽ Khóa Tài Khoản !", "error");

        }
        //邮件 九 零一  起玩www .9 01 7 5 .com
        //$type='1';
        if ($activate == 1) {
            $sql = "INSERT INTO {$PZ['DB_GAME']}.gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('1001','1','sendMail','G100K-TOOLS VIP', 'G100K-TOOLS VIP',{$rid},'{$item},{$num}','')";
            if (mysqli_query($mysql, $sql)) {
                notiG100K(0, "Gửi Vật Phẩm Thành Công !", "success");
            } else {
                notiG100K(0, "Gửi Vật Phẩm Thất Bại !", "error");
            }

        } else {
            notiG100K(0, "Chưa Mua Tools !", "error");
        }
    } elseif ($gnxz == "ClearItem") {
        $sql = "DELETE FROM {$PZ['DB_GAME']}.items WHERE actorid ='0000{$rid}'";
        if (mysqli_query($mysql, $sql)) {
            notiG100K(0, "Xóa Balo Thành Công", "success");
        } else {
            notiG100K(0, $sql, "error");
        }


    } else {
        die('error');
    }
}

?>