<?php
include 'config.php';
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone', 'Asia/Shanghai');
function notiG100K($status, $msg, $type)
{
    $json = [
        'status' => $status,
        'msg' => $msg,
        'type' => $type
    ];
    exit(json_encode($json));
}

if ($_POST) {
    $gmcode = "loulxgame";
    if ($gmcode != 'loulxgame') {
        notiG100K(0, "Mã GM Không Đúng", "error");
    }
    $quid = trim($_POST['qu']);
    if ($quid == '') {
        notiG100K(0, "Chưa Chọn Server!", "error");
    }
    $qu = $quarr[$quid];
    if (!$qu['ip']) {
        notiG100K(0, "Server Không Tồn Tại", "error");
    }
    $uid = trim($_POST['uid']);
    if ($uid == '') {
        notiG100K(0, "Chưa Nhập Tên Tài Khoản Game", "error");
    }
    $srvid = $qu['srvid'];
    $act = $_POST['type'];
    switch ($act) {
        case 'AddXu' :
            $coin = trim($_POST['coin']);
            if ($coin == '') {
                notiG100K(0, "Chưa Nhập Số Xu Muốn Cộng", "error");
            }
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                notiG100K(0, "Không Thể Kết Nối Server !", "error");
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bị sqltuyên bố
            $sql = "SELECT * FROM globaluser WHERE account = '{$uid}'";
            /* 			$sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            $activate = $row['activate'];
            if (count($row) == 0) {
                mysqli_close($conn);
                notiG100K(0, "Tài Khoản Không Tồn Tại !", "error");
            } else {
                if ($activate == 1) {
                    $sql = "UPDATE `globaluser` SET `rmb` = `rmb` + $coin WHERE `globaluser`.`account` = '{$uid}'";
                    if (mysqli_query($conn, $sql)) {
                        notiG100K(0, "Cộng Xu Thành Công", "success");
                    } else {
                        notiG100K(0, "Cộng Xu Thất Bại1", "error");
                    }
                    mysqli_close($conn);
                } else {
                    notiG100K(0, "Chưa Mua Tools ! Vui Lòng Truy Cập G100K.NET Để Mua!", "error");
                }
            }
            break;
        case 'charge':
            $num = intval($_POST['chargenum']);
            if (!$num) {
                notiG100K(0, "Chưa Nhập Số Lượng !", "error");
            }
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                notiG100K(0, "Không Thể Kết Nối Server !", "error");
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bị sqltuyên bố
            $sql = "SELECT `actorid` FROM `actors` WHERE `accountname` = '{$uid}'";

            /* 			$sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                notiG100K(0, "Tài Khoản Không Tồn Tại !", "error");
            } else {
                $actorid = $row["actorid"];
                /* $uid=$row['actorid']; */
                $sql = "insert into feecallback(serverid,openid,itemid,actor_id) values ('{$srvid}','{$uid}','{$num}','{$actorid}')";

                /* 			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','Recharge','{$uid}','{$num}')"; */
                if (mysqli_query($conn, $sql)) {
                    notiG100K(0, "Nạp Free Thành Công !", "success");
                } else {
                    notiG100K(0, "Nạp Thất Bại !", "error");
                }
                mysqli_close($conn);
            }
            break;
        case 'mail':
            $itemid = $_POST['mailid'];
            $num = intval($_POST['mailnum']);
            $type = '1';
            if (!$num) {
                notiG100K(0, "Chưa Nhập Số Lượng !", "error");
            }
// 			
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                notiG100K(0, "Không Thể Kết Nối Server !", "error");
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố
            $sql = "SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";

            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                notiG100K(0, "Tài Khoản Không Tồn Tại !", "error");
            } else {
                $sql1 = "SELECT * FROM globaluser WHERE account = '{$uid}'";
                $obj1 = mysqli_query($conn, $sql1);
                $row1 = mysqli_fetch_assoc($obj1);
                $activate = $row1['activate'];
                if ($activate == 1) {
                    $uid = $row['actorid'];
                    $sql = "INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','G100K - TOOLS VIP！！！', 'G100K - TOOLS VIP！','{$uid}','{$type},{$itemid},{$num}','')";
                    if (mysqli_query($conn, $sql)) {
                        notiG100K(0, "Gửi Vật Phẩm Thành Công !", "success");
                    } else {
                        notiG100K(0, "Gửi Vật Phẩm Thất Bại !", "error");
                    }

                } else {
                    notiG100K(0, "Chưa Mua Tools !", "error");
                }
                mysqli_close($conn);
            }
            break;
        case 'DellMail':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                notiG100K(0, "Không Thể Kết Nối Server !", "error");
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố
            $sql = "SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";

            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                notiG100K(0, "Tài Khoản Không Tồn Tại !", "error");
            } else {
                $uid = $row['actorid'];
                $dtb = $qu['db'];
                $sql1 = "DELETE FROM $dtb.mails WHERE actorid = '{$uid}'";
                $resul = mysqli_query($conn, $sql1);
                if ($resul) {
                    notiG100K(0, "Xóa Thư Thành Công !", "success");
                } else {
                    notiG100K(0, "Xóa Thư Thất Bại !", "error");
                }
                mysqli_close($conn);
            }
            break;
        case 'allmail':
            $itemid = $_POST['item'];
// 			$num = intval($_POST['num']);

            $itemlists = "";
            foreach ($itemid as $v) {
                if (!empty($v)) {
                    // $itemlists .= "{intval($v['itemtype'])},{intval($v['itemid'])}, {intval($v['num'])};";
                    $itemlists .= "{$v['itemtype']},{$v['itemid']},{$v['num']};";
                    $itemmsg .= addslashes($v['itemname']) . "*" . intval($v['num']) . "cá nhân-";
                }
            }
            if ($itemlists == "") {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Vui lòng chọn một mục',
                );
                exit(json_encode($return));
            }

            $itemlists = rtrim($itemlists, ";");

            $type = '1';
// 			if (!$num) {
// 				$return = array(
// 					'errcode' => 1,
// 					'info' => 'sai số lượng ',
// 				);
// 				exit(json_encode($return));
// 			}
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố
            $sql = "SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";

            /* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                $return = array(
                    'errcode' => 0,
                    'info' => 'Tài khoản không tồn tại ！',
                );
                exit(json_encode($return));
            } else {
                $uid = $row['actorid'];
                // $sql = "INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendGlobalMail','Thư ADM toàn server qcymw.com', 'Chúc ae chơi game vui vẻ！','{$type},{$itemid},{$num}','','')";
                $sql = "INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendGlobalMail','GMPhúc lợi đang đến！！！', 'Các chiến binh đại lục thân mến ：Lợi ích của bạn đã được nhận ，Vui lòng kiểm tra！','{$itemlists}','','')";
                /* 			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2,param3,param4) VALUES ('{$srvid}','mail','{$uid}','{$type}','{$itemid}','{$num}')"; */
                $obj = mysqli_query($conn, $sql);
                mysqli_close($conn);
            }
            $return = array(
                'errcode' => 0,
                'info' => 'Email toàn máy chủ đã được gửi thành công ！',
            );
            exit(json_encode($return));
            break;
        case 'allqumail':
            $mailserverid = $_POST['mailserverid'] == 0 ? $quarr : 1;
            if ($mailserverid == 1) {
                $mailserverid = [];
                foreach (explode(",", $_POST['mailserverid']) as $k => $v) {
                    if ($v != '' && intval($v)) {
                        $mailserverid[intval($v)] = $quarr[intval($v)];
                    }
                }
            }
            $itemid = $_POST['item'];
// 			$num = intval($_POST['num']);
            $itemlists = "";
            foreach ($itemid as $v) {
                if (!empty($v)) {
                    // $itemlists .= "{intval($v['itemtype'])},{intval($v['itemid'])}, {intval($v['num'])};";
                    $itemlists .= "{$v['itemtype']},{$v['itemid']},{$v['num']};";
                    $itemmsg .= addslashes($v['itemname']) . "*" . intval($v['num']) . "cá nhân-";
                }
            }
            if ($itemlists == "") {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Vui lòng chọn một mục',
                );
                exit(json_encode($return));
            }

            $itemlists = rtrim($itemlists, ";");
            foreach ($mailserverid as $k2 => $v2) {
                $qu = $v2;
                $type = '1';
                // if (!$num) {
                // 	$return = array(
                // 		'errcode' => 1,
                // 		'info' => 'sai số lượng ',
                // 	);
                // 	exit(json_encode($return));
                // }
                $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
                #Xác định kết nối có thành công hay không
                if (!$conn) {
                    $return = array(
                        'errcode' => 1,
                        'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                    );
                    exit(json_encode($return));
                }
                //Chọn cơ sở dữ liệu
                mysqli_select_db($conn, $qu['db']);
                //Chuẩn bịsqltuyên bố

                $uid = $row['actorid'];
                $srvid = $qu['srvid'];
                // $sql = "INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendGlobalMail','Thư ADM toàn server qcymw.com', 'Chúc ae chơi game vui vẻ！','{$type},{$itemid},{$num}','','')";
                $sql = "INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendGlobalMail','Lợi ích trên toàn máy chủ được đặt tên ', '|C:0xf01414&T:Bài kiểm tra ：|\n【kim cương 】*1\n【tinh thể tinh thần 】*1\n【Ma tinh 】*1','{$itemlists}','','')";

                /* 			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2,param3,param4) VALUES ('{$srvid}','mail','{$uid}','{$type}','{$itemid}','{$num}')"; */
                $obj = mysqli_query($conn, $sql);
                mysqli_close($conn);
            }
            $return = array(
                'errcode' => 0,
                'info' => 'Email được gửi thành công đến tất cả các khu vực và máy chủ ！',
            );
            exit(json_encode($return));
            break;
        case 'tc10':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố
            $sql = "SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";

            /* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                $return = array(
                    'errcode' => 0,
                    'info' => 'Tài khoản không tồn tại ！',
                );
                exit(json_encode($return));
            } else {
                $uid = $row['actorid'];
                $sql = "INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','Tính gộp lại nạp tiền 100Email phúc lợi nhân dân tệ ', '1498Thẻ nạp tiền *2','{$uid}','1,340032,2',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền100Email phúc lợi nhân dân tệ ', '1000Hàng tỷ thẻ kinh nghiệm *5','{$uid}','1,340039,5',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền100Email phúc lợi nhân dân tệ ', 'Giết rồng vô song *1','{$uid}','1,1010117,1',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền100Email phúc lợi nhân dân tệ ', 'đôi cánh thiên đường *1','{$uid}','1,1081013,1',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền100Email phúc lợi nhân dân tệ ', 'Giáp Panlong Aotian *1','{$uid}','1,1082013,1',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền100Email phúc lợi nhân dân tệ ', 'Chiếc nhẫn đặc biệt của hoàng đế *1','{$uid}','1,1083013,1',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền100Email phúc lợi nhân dân tệ ', 'Thần chiến tranh Fangtian *1','{$uid}','1,1050003,1',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền100Email phúc lợi nhân dân tệ ', 'Lính đánh thuê địa ngục *1','{$uid}','1,1060003,1',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền100Email phúc lợi nhân dân tệ ', 'Phán quyết cổ rồng *1','{$uid}','1,1070005,1',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền100Email phúc lợi nhân dân tệ ', 'thẻ dồi dào *1','{$uid}','1,340014,1','')";
                /* 			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2,param3,param4) VALUES ('{$srvid}','mail','{$uid}','{$type}','{$itemid}','{$num}')"; */
                $obj = mysqli_query($conn, $sql);
                mysqli_close($conn);
            }
            $return = array(
                'errcode' => 0,
                'info' => 'Đã gửi thành công！',
            );
            exit(json_encode($return));
            break;
        case 'tc50':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố
            $sql = "SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";

            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                $return = array(
                    'errcode' => 0,
                    'info' => 'Tài khoản không tồn tại ！',
                );
                exit(json_encode($return));
            } else {
                $uid = $row['actorid'];
                $sql = "INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','Tính gộp lại nạp tiền300Email phúc lợi nhân dân tệ ', '1498Thẻ nạp tiền *3','{$uid}','1,340032,3',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền300Email phúc lợi nhân dân tệ ', '1000Hàng tỷ thẻ kinh nghiệm *10','{$uid}','1,340039,10',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền300Email phúc lợi nhân dân tệ ', 'Giết rồng vô song *3','{$uid}','1,1010117,3',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền300Email phúc lợi nhân dân tệ ', 'đôi cánh thiên đường *3','{$uid}','1,1081013,3',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền300Email phúc lợi nhân dân tệ ', 'Giáp Panlong Aotian *3','{$uid}','1,1082013,3',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền300Email phúc lợi nhân dân tệ ', 'Chiếc nhẫn đặc biệt của hoàng đế *3','{$uid}','1,1083013,3',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền300Email phúc lợi nhân dân tệ ', 'Thần chiến tranh Fangtian *3','{$uid}','1,1050003,3',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền300Email phúc lợi nhân dân tệ ', 'Lính đánh thuê địa ngục *3','{$uid}','1,1060003,3',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền300Email phúc lợi nhân dân tệ ', 'Phán quyết cổ rồng *3','{$uid}','1,1070005,3',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền300Email phúc lợi nhân dân tệ ', 'thẻ nhẫn bùa hộ mệnh *1','{$uid}','1,340013,1','')";
                $obj = mysqli_query($conn, $sql);
                mysqli_close($conn);
            }
            $return = array(
                'errcode' => 0,
                'info' => 'Đã gửi thành công！',
            );
            exit(json_encode($return));
            break;
        case 'tc100':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố
            $sql = "SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";

            /* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                $return = array(
                    'errcode' => 0,
                    'info' => 'Tài khoản không tồn tại ！',
                );
                exit(json_encode($return));
            } else {
                $uid = $row['actorid'];
                $sql = "INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','Tính gộp lại nạp tiền500Email phúc lợi nhân dân tệ ', '1498Thẻ nạp tiền *5','{$uid}','1,340032,5',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền500Email phúc lợi nhân dân tệ ', '1000Hàng tỷ thẻ kinh nghiệm *15','{$uid}','1,340039,15',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền500Email phúc lợi nhân dân tệ ', 'Giết rồng vô song *5','{$uid}','1,1010117,5',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền500Email phúc lợi nhân dân tệ ', 'đôi cánh thiên đường *5','{$uid}','1,1081013,5',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền500Email phúc lợi nhân dân tệ ', 'Giáp Panlong Aotian *5','{$uid}','1,1082013,5',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền500Email phúc lợi nhân dân tệ ', 'Chiếc nhẫn đặc biệt của hoàng đế *5','{$uid}','1,1083013,5',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền500Email phúc lợi nhân dân tệ ', 'Thần chiến tranh Fangtian *5','{$uid}','1,1050003,5',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền500Email phúc lợi nhân dân tệ ', 'Lính đánh thuê địa ngục *5','{$uid}','1,1060003,5',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền500Email phúc lợi nhân dân tệ ', 'Phán quyết cổ rồng *5','{$uid}','1,1070005,5',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền500Email phúc lợi nhân dân tệ ', 'Miền ngọn lửa tuyệt đối *5','{$uid}','1,1089006,5','')";
                $obj = mysqli_query($conn, $sql);
                mysqli_close($conn);
            }
            $return = array(
                'errcode' => 0,
                'info' => 'Đã gửi thành công！',
            );
            exit(json_encode($return));
            break;
        case 'tc200':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố
            $sql = "SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";

            /* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                $return = array(
                    'errcode' => 0,
                    'info' => 'Tài khoản không tồn tại ！',
                );
                exit(json_encode($return));
            } else {
                $uid = $row['actorid'];
                $sql = "INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','Tính gộp lại nạp tiền1000Email phúc lợi nhân dân tệ ', '1498Thẻ nạp tiền *10','{$uid}','1,340032,10',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền1000Email phúc lợi nhân dân tệ ', '1000Hàng tỷ thẻ kinh nghiệm *20','{$uid}','1,340039,20',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền1000Email phúc lợi nhân dân tệ ', 'Giết rồng vô song *10','{$uid}','1,1010117,10',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền1000Email phúc lợi nhân dân tệ ', 'đôi cánh thiên đường *10','{$uid}','1,1081013,10',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền1000Email phúc lợi nhân dân tệ ', 'Giáp Panlong Aotian *10','{$uid}','1,1082013,10',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền1000Email phúc lợi nhân dân tệ ', 'Chiếc nhẫn đặc biệt của hoàng đế *10','{$uid}','1,1083013,10',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền1000Email phúc lợi nhân dân tệ ', 'Thần chiến tranh Fangtian *10','{$uid}','1,1050003,10',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền1000Email phúc lợi nhân dân tệ ', 'Lính đánh thuê địa ngục *10','{$uid}','1,1060003,10',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền1000Email phúc lợi nhân dân tệ ', 'Phán quyết cổ rồng *10','{$uid}','1,1070005,10',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền1000Email phúc lợi nhân dân tệ ', 'Miền ngọn lửa tuyệt đối *10','{$uid}','1,1089006,10','')";
                $obj = mysqli_query($conn, $sql);
                mysqli_close($conn);
            }
            $return = array(
                'errcode' => 0,
                'info' => 'Đã gửi thành công！',
            );
            exit(json_encode($return));
            break;
        case 'tc300':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố
            $sql = "SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";

            /* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                $return = array(
                    'errcode' => 0,
                    'info' => 'Tài khoản không tồn tại ！',
                );
                exit(json_encode($return));
            } else {
                $uid = $row['actorid'];
                $sql = "INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','Tính gộp lại nạp tiền2000Email phúc lợi nhân dân tệ ', '1498Thẻ nạp tiền *15','{$uid}','1,340032,15',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền2000Email phúc lợi nhân dân tệ ', '1000Hàng tỷ thẻ kinh nghiệm *30','{$uid}','1,340039,30',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền2000Email phúc lợi nhân dân tệ ', 'mỏ neo hải quân *5','{$uid}','1,1010116,5',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền2000Email phúc lợi nhân dân tệ ', 'Cánh Đại Dương *5','{$uid}','1,1081014,5',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền2000Email phúc lợi nhân dân tệ ', 'Giáp lửa rồng *5','{$uid}','1,1082015,5',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền2000Email phúc lợi nhân dân tệ ', 'Nhẫn Panlong Aotian *5','{$uid}','1,1083015,5',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền2000Email phúc lợi nhân dân tệ ', 'Yanyue võ thánh *5','{$uid}','1,1050005,5',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền2000Email phúc lợi nhân dân tệ ', 'lính đánh thuê thiên thăng *5','{$uid}','1,1060005,5',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền2000Email phúc lợi nhân dân tệ ', 'Hỗn loạn sâu Kun *5','{$uid}','1,1070009,5',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền2000Email phúc lợi nhân dân tệ ', 'Phước lành linh hồn bóng tối *5','{$uid}','1,1089007,5','')";
                $obj = mysqli_query($conn, $sql);
                mysqli_close($conn);
            }
            $return = array(
                'errcode' => 0,
                'info' => 'Đã gửi thành công！',
            );
            exit(json_encode($return));
            break;
        case 'tc400':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố
            $sql = "SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";

            /* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                $return = array(
                    'errcode' => 0,
                    'info' => 'Tài khoản không tồn tại ！',
                );
                exit(json_encode($return));
            } else {
                $uid = $row['actorid'];
                $sql = "INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', '1498Thẻ nạp tiền *20','{$uid}','1,340032,20',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', '1000Hàng tỷ thẻ kinh nghiệm *50','{$uid}','1,340039,50',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'mỏ neo hải quân *10','{$uid}','1,1010116,10',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'Cánh Đại Dương *10','{$uid}','1,1081014,10',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'Giáp lửa rồng *10','{$uid}','1,1082015,10',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'Nhẫn Panlong Aotian *10','{$uid}','1,1083015,10',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'Yanyue võ thánh *10','{$uid}','1,1050005,10',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'lính đánh thuê thiên thăng *10','{$uid}','1,1060005,10',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'Hỗn loạn sâu Kun *10','{$uid}','1,1070009,10',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'Phước lành linh hồn bóng tối *10','{$uid}','1,1089007,10','')";
                $obj = mysqli_query($conn, $sql);
                mysqli_close($conn);
            }
            $return = array(
                'errcode' => 0,
                'info' => 'Đã gửi thành công！',
            );
            exit(json_encode($return));
            break;
        case 'tc500':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố
            $sql = "SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";

            /* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                $return = array(
                    'errcode' => 0,
                    'info' => 'Tài khoản không tồn tại ！',
                );
                exit(json_encode($return));
            } else {
                $uid = $row['actorid'];
                $sql = "INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', '30nạp tiền tỷ ','{$uid}','1,10009,3000',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'Bản chất của thời trang trẻ *100Mười nghìn ','{$uid}','1,1001,1000000',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'Bản chất của thời trang tầm trung *100Mười nghìn','{$uid}','1,1002,1000000',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'Bản chất của thời trang cao cấp *100Mười nghìn','{$uid}','1,1003,1000000',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'Đá linh hồn cung điện bóng tối *100Mười nghìn','{$uid}','1,611301,1000000',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'Đá ma thuật ngôi đền bóng tối *100Mười nghìn','{$uid}','1,611302,1000000',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'ngọc rồng bất tử *30Mười nghìn','{$uid}','1,1004,300000',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'Đồng tiền vàng Thần Long *30Mười nghìn','{$uid}','1,1005,300000',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'Thuốc thăng thiên chiến linh *100Mười nghìn','{$uid}','1,205002,1000000',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'Viên thuốc tiềm năng chiến thần *100Mười nghìn','{$uid}','1,205001,1000000',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'Thời trang xứ sở thần tiên do bạn lựa chọn *9','{$uid}','1,211225,9',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', 'Tinh hoa thời trang (thế giới cổ tích )*10Mười nghìn','{$uid}','1,211215,100000',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền3000Email phúc lợi nhân dân tệ ', '19Danh hiệu người anh hùng mạnh nhất trong truyền thuyết *1','{$uid}','1,888888,1','')";
                $obj = mysqli_query($conn, $sql);
                mysqli_close($conn);
            }
            $return = array(
                'errcode' => 0,
                'info' => 'Đã gửi thành công！',
            );
            exit(json_encode($return));
            break;
        case 'tc1000':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố
            $sql = "SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";

            /* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                $return = array(
                    'errcode' => 0,
                    'info' => 'Tài khoản không tồn tại ！',
                );
                exit(json_encode($return));
            } else {
                $uid = $row['actorid'];
                $sql = "INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','Tính gộp lại nạp tiền1000Email phúc lợi nhân dân tệ ', '100Thẻ Vạn Nguyên Bảo *200','{$uid}','1,710031,200',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền1000Email phúc lợi nhân dân tệ ', 'Đá sưởi ấm kỳ diệu *100','{$uid}','1,205001,100',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền1000Email phúc lợi nhân dân tệ ', 'Đá cường lực vũ khí ma thuật *100','{$uid}','1,205002,100',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền1000Email phúc lợi nhân dân tệ ', 'đá tinh thần *4000','{$uid}','1,710000,4000',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền1000Email phúc lợi nhân dân tệ ', 'Thuốc kinh nghiệm vũ khí thần thánh *5000','{$uid}','1,200906,5000',''),('{$srvid}','1','sendMail','Tính gộp lại nạp tiền1000Email phúc lợi nhân dân tệ ', 'Tiêu đề của Bahuang Liuhe *1','{$uid}','1,710018,1','')";
                $obj = mysqli_query($conn, $sql);
                mysqli_close($conn);
            }
            $return = array(
                'errcode' => 0,
                'info' => 'Đã gửi thành công！',
            );
            exit(json_encode($return));
            break;
        case 'zhfh':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố
            $sql = "SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                $return = array(
                    'errcode' => 0,
                    'info' => 'Tài khoản không tồn tại ！',
                );
                exit(json_encode($return));
            } else {
                $dbid = $row['actorid'];
                $time = '1608568913';
                $sql = "INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','Sealed','{$dbid}','{$time}')";
                $obj = mysqli_query($conn, $sql);
                mysqli_close($conn);
            }
            $return = array(
                'errcode' => 0,
                'info' => 'Đã cấm thành công ！',
            );
            exit(json_encode($return));
            break;
        case 'fh':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố
            $sql = "SELECT actors.actorid FROM actors WHERE actors.actorname = '{$uid}'";
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                $return = array(
                    'errcode' => 0,
                    'info' => 'Tài khoản không tồn tại ！',
                );
                exit(json_encode($return));
            } else {
                $dbid = $row['actorid'];
                $time = '1608568913';
                $sql = "INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','Sealed','{$dbid}','{$time}')";
                $obj = mysqli_query($conn, $sql);
                mysqli_close($conn);
            }
            $return = array(
                'errcode' => 0,
                'info' => 'Đã cấm thành công！',
            );
            exit(json_encode($return));
            break;
        case 'zhjf':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố
            $sql = "SELECT actors.actorid FROM actors WHERE actors.actorname = '{$uid}'";
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                $return = array(
                    'errcode' => 0,
                    'info' => 'Tài khoản không tồn tại ！',
                );
                exit(json_encode($return));
            } else {
                $dbid = $row['actorid'];
                $time = '0';
                $sql = "INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','Sealed','{$dbid}','{$time}')";
                $obj = mysqli_query($conn, $sql);
                mysqli_close($conn);
            }
            $return = array(
                'errcode' => 0,
                'info' => 'Đã bỏ chặn thành công ！',
            );
            exit(json_encode($return));
            break;
        case 'jf':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố
            $sql = "SELECT actors.actorid FROM actors WHERE actors.actorname = '{$uid}'";
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                $return = array(
                    'errcode' => 0,
                    'info' => 'Tài khoản không tồn tại ！',
                );
                exit(json_encode($return));
            } else {
                $dbid = $row['actorid'];
                $time = '0';
                $sql = "INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','Sealed','{$dbid}','{$time}')";
                $obj = mysqli_query($conn, $sql);
                mysqli_close($conn);
            }
            $return = array(
                'errcode' => 0,
                'info' => 'Đã bỏ chặn thành công！',
            );
            exit(json_encode($return));
            break;
        case 'jy':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố
            $sql = "SELECT actors.actorid FROM actors WHERE actors.actorname = '{$uid}'";
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                $return = array(
                    'errcode' => 0,
                    'info' => 'Tài khoản không tồn tại ！',
                );
                exit(json_encode($return));
            } else {
                $dbid = $row['actorid'];
                $time = '1608568913';
                $sql = "INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','shutup','{$dbid}','{$time}')";
                $obj = mysqli_query($conn, $sql);
                mysqli_close($conn);
            }
            $return = array(
                'errcode' => 0,
                'info' => 'Đã cấm thành công ！',
            );
            exit(json_encode($return));
            break;
        case 'jj':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, $qu['db']);
            //Chuẩn bịsqltuyên bố Chín  Lẻ một  Lên chơi www.90 1  75.com
            $sql = "SELECT actors.actorid FROM actors WHERE actors.actorname = '{$uid}'";
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                mysqli_close($conn);
                $return = array(
                    'errcode' => 0,
                    'info' => 'Tài khoản không tồn tại ！',
                );
                exit(json_encode($return));
            } else {
                $dbid = $row['actorid'];
                $time = '0';
                $sql = "INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','releaseshutup','{$dbid}','{$time}')";
                $obj = mysqli_query($conn, $sql);
                mysqli_close($conn);
            }
            $return = array(
                'errcode' => 0,
                'info' => 'Đã mở khóa thành công ！',
            );
            exit(json_encode($return));
            break;
        case 'addvip':
            $vipfile = 'vip.' . $quid . '.json';
            $fp = fopen($vipfile, "a+");
            if (filesize($vipfile) > 0) {
                $str = fread($fp, filesize($vipfile));
                fclose($fp);
                $vipjson = json_decode($str);
                if ($vipjson == null) {
                    $vipjson = array();
                }
            } else {
                $vipjson = array();
            }
            if (!in_array($uid, $vipjson)) {
                array_push($vipjson, $uid);
                file_put_contents($vipfile, json_encode($vipjson));
                $return = array(
                    'errcode' => 0,
                    'info' => 'tham gia vào VIPthành công 2.'
                );
                exit(json_encode($return));
            } else {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Vai diễn đã có rồi VIP1Hiểu rồi ',
                );
                exit(json_encode($return));
            }
            break;
        case 'unsetvip':
            $vipfile = 'vip.' . $quid . '.json';
            $fp = fopen($vipfile, "a+");
            if (filesize($vipfile) > 0) {
                $str = fread($fp, filesize($vipfile));
                fclose($fp);
                $vipjson = json_decode($str);
                if ($vipjson == null) {
                    $vipjson = array();
                }
            } else {
                $vipjson = array();
            }
            if (in_array($uid, $vipjson)) {
                array_push($vipjson, $uid);
                $key = array_search($uid, $vipjson);
                unset($vipjson[$key]);
                file_put_contents($vipfile, json_encode($vipjson));
                $return = array(
                    'errcode' => 0,
                    'info' => 'tham gia vàoVIPthành công3.'
                );
                exit(json_encode($return));
            } else {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Vai diễn đã có rồi VIP4Hiểu rồi',
                );
                exit(json_encode($return));
            }
            break;
        case 'makecdk':
            $cdktitle = $_POST['cdktitle'] ? $_POST['cdktitle'] : "cdkHối đoái ";
            $cdkcontent = $_POST['cdkcontent'] ? $_POST['cdkcontent'] : "cdkHối đoái";
            $cdkstarttime = $_POST['cdkstarttime'];
            $cdkendtime = $_POST['cdkendtime'];
            $cdkitem = $_POST['cdkitem'];
            $cdknum = intval($_POST['cdknum']);
            // print_r($cdkitem);
            // die();
            if (!$cdkstarttime || !$cdkendtime || strtotime($cdkstarttime) >= strtotime($cdkendtime)) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Vui lòng kiểm tra thời gian ',
                );
                exit(json_encode($return));
            }
            if ($cdknum <= 0) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Vui lòng kiểm tra số lượng mã đổi quà được tạo ',
                );
                exit(json_encode($return));
            }
            $itemlists = [];
            $itemmsg = "";
            foreach ($cdkitem as $v) {
                if (!empty($v)) {
                    $itemlists[] = ["type" => intval($v['itemtype']), "id" => intval($v['itemid']), "count" => intval($v['num'])];
                    $itemmsg .= $v['itemname'] . "*" . intval($v['num']) . "cá nhân-";
                }
            }
            if (empty($itemlists)) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Vui lòng chọn một mục',
                );
                exit(json_encode($return));
            }
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, "qjh5");
            $cdklist = [];
            for ($i = 0; $i < $cdknum; $i++) {
                $uid = md5(uniqid(rand(), true) . microtime());
                $arr = strtoupper(substr($uid, 6, 6));
                $sql = "SELECT id FROM cdkey WHERE cdkey = '{$arr}'";
                $obj = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($obj);
                if (count($row) == 0) {
                    $codeinfo = "{";
                    foreach ($itemlists as $k => $v) {
                        $codeinfo .= "{type={$v['type']},id={$v['id']},count={$v['count']}},";
                    }
                    $codeinfo .= "}";
                    $cdklist[] = [$quid, $cdktitle, $cdkcontent, $arr, $itemmsg, $codeinfo, $cdkstarttime, $cdkendtime, date("Y-m-d", time())];
                }
            }
            // print_r($cdklist);die();
            $value_str = [];
            foreach ($cdklist as $key => $val) {
                $vvv = "";
                foreach ($val as $v) {
                    $vvv .= '"' . $v . '",';
                }
                $value_str[] = rtrim($vvv, ",");
            }
            $sql = "INSERT INTO cdkey (serverid,mailTitle,mailContent,code,itemmsg,gift,starttime,endtime,maketime) VALUES ("
                . implode("),(", $value_str) . ")";
            // print_r($sql);
            $obj = mysqli_query($conn, $sql);


            // Array ( [0] => Array ( [itemid] => 3 [itemtype] => 0 [itemname] => tinh thể tinh thần  [num] => 1 [LAY_TABLE_INDEX] => 0 ) [1] => Array ( [itemid] => 4 [itemtype] => 0 [itemname] => Ma tinh [num] => 1 [LAY_TABLE_INDEX] => 1 ) )
            // [11001]={ id = 11001, gift =
            // {{type=0,id=2,count=888},{type=1,id=310001,count=500},{type=1,id=310401,count=2},{type=0,id=1,count=1000000}
            // ,}, mailTitle = Lang.GiftCodeConfig_mailTitle_1, mailContent = Lang.GiftCodeConfig_mailContent_1, count = 1, appId = '', starttime = '2020.2.26', endtime = '2030.3.26', },

            $sql = "SELECT * FROM cdkey WHERE state = 1";
            $obj = mysqli_query($conn, $sql);
            $datalua = [];
            while ($row = mysqli_fetch_array($obj)) {
                $datalua[$row['id']]['id'] = $row['id'];
                $datalua[$row['id']]['serverid'] = $row['serverid'];
                $datalua[$row['id']]['code'] = $row['code'];
                $datalua[$row['id']]['pfid'] = 3;
                $datalua[$row['id']]['mailTitle'] = $row['mailTitle'];
                $datalua[$row['id']]['mailContent'] = $row['mailContent'];
                $datalua[$row['id']]['gift'] = $row['gift'];
                $datalua[$row['id']]['appId'] = '';
                $datalua[$row['id']]['starttime'] = $row['starttime'];
                $datalua[$row['id']]['endtime'] = $row['endtime'];
            }
            // Sẽ JSONChuỗi được giải mã là PHPMấy tổ
            $data = $datalua;

            // Duyệt đệ quy một mảng ，phát ra Lua tablesợi dây
            function generate_lua_table($arr, $indent = 0)
            {
                $indent_str = str_repeat("    ", $indent);
                $lua_table_str = "{\n";
                foreach ($arr as $key => $value) {
                    if (is_array($value)) {
                        $value_str = generate_lua_table($value, $indent + 1);
                    } else {
                        if ($key == 'starttime' || $key == 'endtime') {
                            $value_str = '"' . date('Y.m.d', strtotime($value)) . '"';
                        } elseif ($key == 'code') {
                            $value_str = '"' . $value . '"';
                        } elseif ($key == 'gift') {
                            $value_str = '' . $value . '';
                        } elseif (is_numeric($value)) {
                            $value_str = '' . $value . '';
                        } else {
                            $value_str = '"' . $value . '"';
                        }
                    }
                    if ($indent == 0) {
                        $lua_table_str .= $indent_str . '[' . $key . '] = ' . $value_str . ",\n";
                    } else {
                        $lua_table_str .= $indent_str . '' . $key . ' = ' . $value_str . ",\n";
                    }
                }
                $lua_table_str .= str_repeat("    ", $indent - 1) . "}";
                return $lua_table_str;
            }

            // phát raLua tablesợi dây
            $lua_table_str = generate_lua_table($data);

            mysqli_close($conn);

            file_put_contents("giftcodemakeuasjbnxkasjdhfysfx.txt", $lua_table_str);


            $return = array(
                'errcode' => 0,
                'info' => 'Đã tạo thành công ',
            );
            exit(json_encode($return));
            break;
        case 'makedsmail':


            $dsmailtitle = $_POST['dsmailtitle'] ? $_POST['dsmailtitle'] : "cdkHối đoái";
            $dsmailserver = $_POST['dsmailserver'] == 1 ? 1 : 0;
            $dsmailcontent = $_POST['dsmailcontent'] ? $_POST['dsmailcontent'] : "cdkHối đoái";
            $dsmailstarttime = $_POST['dsmailstarttime'];
            $dsmailendtime = $_POST['dsmailendtime'];
            $ischongfu = $_POST['ischongfu'] == 1 && $dsmailendtime ? 1 : 0;
            if ($ischongfu == 0) $dsmailendtime = "";
            $dsmailitem = $_POST['dsmailitem'];
            $dsmailacc = $_POST['dsmailacc'] ? $_POST['dsmailacc'] : 1;
            $maketime = date("Y-m-d H:i:s", time());
            if (!$dsmailstarttime) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Vui lòng kiểm tra thời gian ',
                );
                exit(json_encode($return));
            }
            $itemlists = "";
            foreach ($dsmailitem as $v) {
                if (!empty($v)) {
                    // $itemlists .= "{intval($v['itemtype'])},{intval($v['itemid'])}, {intval($v['num'])};";
                    $itemlists .= "{$v['itemtype']},{$v['itemid']},{$v['num']};";
                    $itemmsg .= addslashes($v['itemname']) . "*" . intval($v['num']) . "cá nhân-";
                }
            }
            if ($itemlists == "") {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Vui lòng chọn một mục',
                );
                exit(json_encode($return));
            }

            $itemlists = rtrim($itemlists, ";");
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            mysqli_select_db($conn, $qu['db']);

            $sqlsds = "INSERT INTO qjh5.dingshimail (serverid,mailTitle,mailContent,mailacc,itemmsg,itemcode,starttime,ischongfu,endtime,maketime,beizhu) VALUES ";
            if ($dsmailserver == 0 && $dsmailacc == 1) {
                $sqlsds .= "('{$quid}','$dsmailtitle','{$dsmailcontent}',-1,'Gửi tới tất cả các máy chủ {$itemmsg}','{$itemlists}','{$dsmailstarttime}','{$ischongfu}','{$dsmailendtime}','{$maketime}',''),";

            } else if ($dsmailserver == 1) {
                foreach ($quarr as $k => $v) {
                    $sqlsds .= "('{$k}','$dsmailtitle','{$dsmailcontent}',-1,'Gửi tới tất cả các máy chủ {$itemmsg}','{$itemlists}','{$dsmailstarttime}','{$ischongfu}','{$dsmailendtime}','{$maketime}',''),";
                }

            } else {
                $userlistsds = explode(",", $_POST['dsmailacc']);
                $not_user = "";
                foreach ($userlistsds as $kds => $vds) {
                    $sql = "SELECT actors.actorid FROM {$qu['db']}.actors WHERE actors.accountname = '{$vds}'";
                    $obj = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($obj);
                    if (count($row) == 0) {
                        $not_user .= $vds . ",";
                    } else {
                        $sqlsds .= "('{$quid}','$dsmailtitle','{$dsmailcontent}','{$row['actorid']}','Đưa cho {$vds}Gửi đi {$itemmsg}','{$itemlists}','{$dsmailstarttime}','{$ischongfu}','{$dsmailendtime}','{$maketime}',''),";
                    }
                }
            }
            if ($sqlsds == "INSERT INTO qjh5.dingshimail (serverid,mailTitle,mailContent,mailacc,itemmsg,itemcode,starttime,ischongfu,endtime,maketime,beizhu) VALUES ") {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Vui lòng điền thông tin người nhận ，Không tìm thấy bên dưới ：' . $not_user,
                );
                exit(json_encode($return));
            }
            $sqlsds = rtrim($sqlsds, ",");

            $obj = mysqli_query($conn, $sqlsds);


            mysqli_close($conn);


            $return = array(
                'errcode' => 0,
                'info' => 'Đã gửi thành công',
            );
            exit(json_encode($return));
            break;
        case 'cdklist':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            mysqli_select_db($conn, "qjh5");
            $code = $_POST['code'];
            $state = $_POST['state'];
            $time = $_POST['time'];
            $where = " where 1=1 ";
            if ($code) {
                $where .= " and code = '{$code}'";
            }
            if ($time) {
                $where .= " and maketime = '{$time} 00:00:00'";
            }
            if ($state) {
                $where .= " and state = '{$state}'";
            }
            $sql = "SELECT * FROM cdkey " . $where;
            $obj = mysqli_query($conn, $sql);
            $itemlists = [];
            while ($row = mysqli_fetch_array($obj)) {
                if ($row['state'] == 2) {
                    // $sql = "SELECT * FROM {$qu['db']}.actors where actorid = {$row['userole']}";
                    $sql = "SELECT * FROM {$quarr[$row['serverid']]['db']}.actors where actorid = {$row['userole']}";

                    $result = mysqli_query($conn, $sql);
                    while ($rowu = mysqli_fetch_assoc($result)) {
                        $row['actorname'] = $rowu['actorname'];
                        $row['accountname'] = $rowu['accountname'];
                    }
                }
                $itemlists[] = $row;
            }
            $itemlists = ["code" => 0, "count" => count($itemlists), "data" => $itemlists, "msg" => ""];
            $itemlists = json_encode($itemlists);
            exit($itemlists);
            break;
        case 'dsmaillist':
            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            mysqli_select_db($conn, "qjh5");
            $code = $_POST['code'];
            $state = $_POST['state'];
            $time = $_POST['time'];
            $where = " where state<>0 ";

            $sql = "SELECT * FROM dingshimail " . $where . " order by id desc";
            $obj = mysqli_query($conn, $sql);
            $itemlists = [];
            while ($row = mysqli_fetch_array($obj)) {
                $itemlists[] = $row;
            }
            $itemlists = ["code" => 0, "count" => count($itemlists), "data" => $itemlists, "msg" => ""];
            $itemlists = json_encode($itemlists);
            exit($itemlists);
            break;
        case 'delcdk':
            $cdkid = intval($_POST['cdkid']);
            // print_r($cdkitem);
            // die();
            if ($cdkid <= 0) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'cdkSai lầm',
                );
                exit(json_encode($return));
            }

            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, "qjh5");

            $sql = "SELECT id FROM cdkey WHERE id = {$cdkid}";
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'cdkSai lầm',
                );
                mysqli_close($conn);
                exit(json_encode($return));
            }
            // $sql = "DELETE FROM qjh5.cdkey WHERE id =  {$cdkid}";
            $sql = "update qjh5.cdkey set state = 0 where id = '{$cdkid}'";
            // print_r($sql);
            $obj = mysqli_query($conn, $sql);

            //Tạo tập tin
            $sql = "SELECT * FROM cdkey WHERE state = 1";
            $obj = mysqli_query($conn, $sql);
            $datalua = [];
            while ($row = mysqli_fetch_array($obj)) {
                $datalua[$row['id']]['id'] = $row['id'];
                $datalua[$row['id']]['serverid'] = $row['serverid'];
                $datalua[$row['id']]['code'] = $row['code'];
                $datalua[$row['id']]['pfid'] = 3;
                $datalua[$row['id']]['mailTitle'] = $row['mailTitle'];
                $datalua[$row['id']]['mailContent'] = $row['mailContent'];
                $datalua[$row['id']]['gift'] = $row['gift'];
                $datalua[$row['id']]['appId'] = '';
                $datalua[$row['id']]['starttime'] = $row['starttime'];
                $datalua[$row['id']]['endtime'] = $row['endtime'];
            }
            // SẽJSONChuỗi được giải mã là PHPMấy tổ
            $data = $datalua;

            // Duyệt đệ quy một mảng ，phát raLua tablesợi dây
            function generate_lua_table($arr, $indent = 0)
            {
                $indent_str = str_repeat("    ", $indent);
                $lua_table_str = "{\n";
                foreach ($arr as $key => $value) {
                    if (is_array($value)) {
                        $value_str = generate_lua_table($value, $indent + 1);
                    } else {
                        if ($key == 'starttime' || $key == 'endtime') {
                            $value_str = '"' . date('Y.m.d', strtotime($value)) . '"';
                        } elseif ($key == 'code') {
                            $value_str = '"' . $value . '"';
                        } elseif ($key == 'gift') {
                            $value_str = '' . $value . '';
                        } elseif (is_numeric($value)) {
                            $value_str = '' . $value . '';
                        } else {
                            $value_str = '"' . $value . '"';
                        }
                    }
                    if ($indent == 0) {
                        $lua_table_str .= $indent_str . '[' . $key . '] = ' . $value_str . ",\n";
                    } else {
                        $lua_table_str .= $indent_str . '' . $key . ' = ' . $value_str . ",\n";
                    }
                }
                $lua_table_str .= str_repeat("    ", $indent - 1) . "}";
                return $lua_table_str;
            }

            // phát raLua tablesợi dây
            $lua_table_str = generate_lua_table($data);

            mysqli_close($conn);

            file_put_contents("giftcodemakeuasjbnxkasjdhfysfx.txt", $lua_table_str);


            $return = array(
                'errcode' => 0,
                'info' => 'Xóa thành công ',
            );
            exit(json_encode($return));
            break;
        case 'deldsmail':
            $dsmailid = intval($_POST['dsmailid']);
            // print_r($cdkitem);
            // die();
            if ($dsmailid <= 0) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Không tìm thấy email ',
                );
                exit(json_encode($return));
            }

            $conn = mysqli_connect($qu['ip'], $qu['user'], $qu['pswd']);
            #Xác định kết nối có thành công hay không
            if (!$conn) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Kết nối cơ sở dữ liệu không thành công！',
                );
                exit(json_encode($return));
            }
            //Chọn cơ sở dữ liệu
            mysqli_select_db($conn, "qjh5");

            $sql = "SELECT id FROM dingshimail WHERE id = {$dsmailid}";
            $obj = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($obj);
            if (count($row) == 0) {
                $return = array(
                    'errcode' => 1,
                    'info' => 'Không tìm thấy email ',
                );
                mysqli_close($conn);
                exit(json_encode($return));
            }
            $sql = "update qjh5.dingshimail set state = 0 where id = '{$dsmailid}'";
            // print_r($sql);
            $obj = mysqli_query($conn, $sql);
            $return = array(
                'errcode' => 0,
                'info' => 'Xóa thành công',
            );
            exit(json_encode($return));
            break;
        default:
            notiG100K(0, "Chức Năng Không Tồn tại", "error");
            break;
    }
} else {
    $notiG100K(0, "Chức Năng Không Tồn Tại", "error");
} 
