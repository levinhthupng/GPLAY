<?php
date_default_timezone_set("Asia/Shanghai");
include "config.php";
function notiG100K($status, $msg, $type) {
    $json = [
        'status' => $status,
        'msg' => $msg,
        'type' => $type
    ];
    exit(json_encode($json));
}
if ($_POST) {
    $checknum = "lyzwlkj.vip";
    $quid = trim(poststr("qu"));
    $qu = $quarr[$quid];
    $uid = $_POST["uid"];
    $gid = $qu["gid"];
    $zoneid = $qu["zoneid"];
    $dbip = $qu["host"];
    $dbname = $qu["dbname"];
    $dbuser = $qu["user"];
    $dbpwd = $qu["pwd"];
    $dbport = $qu["port"];
    $quname = $qu["name"];
    //$cdknum = $_POST["cdknum"];

    $con = mysqli_connect($dbip, $dbuser, $dbpwd, $dbname, $dbport);
    // 检查连接是否成功
    if (mysqli_connect_errno()) {
        notiG100K(0,"Không Thể Kết Nối Đến Server !","error");
    }

    $sql = "SELECT * FROM account WHERE user  = '" . $uid . "'";
    $result = mysqli_query($con, $sql);

    if ($result->num_rows > 0) {
        // 将查询结果存储在变量中
        $row = $result->fetch_assoc();
        $activate = $row["activate"];
        $roleid = $row["user"];
        
    } else {
        notiG100K(0,"Nhân Vật Không Tồn Tại !","error");
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
                            $file = fopen("charge.txt", "r");
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
                            $mailnum = trim(poststr("chargenum"));
                            if (
                                $mailnum == "" ||
                                $mailnum < 0 ||
                                $mailnum > 2000000000
                            ) {
                                notiG100K(0,"Chưa Nhập Số Lượng","error");
                            }
                           
                            $con = db_con();
                            
                            // notiG100K(0,$mailid,"success");
                            // 3) Dữ liệu insert (apply_time dùng time())
                            $server_id     = $zoneid;
                            $apply_person  = 'admin';
                            $apply_time    = time(); // <== dùng time()
                            $apply_reason  = 'GM';
                            $mailTitle     = 'G100K - TOOLS FREE';
                            $mailContent   = 'G100K - TOOLS FREE';
                            $accountsJson  = json_encode([$uid], JSON_UNESCAPED_UNICODE);
                            $itemsJson = json_encode([
                                [
                                    'itemID'  => $mailid,
                                    'itemCnt' => $mailnum,
                                ]
                            ], JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
                            $verify_result = 1;
                            $verify_person = '';
                            $sendType      = 2;
                            $visible       = 1;
                            
                            // 4) INSERT bằng prepared procedural để tránh SQL injection
                            $sql = "INSERT INTO t_apply_goods
                            (server_id, apply_person, apply_time, apply_reason,
                             mailTitle, mailContent, accounts, items,
                             verify_result, verify_person, sendType, visible)
                            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
                            
                            $stmt = mysqli_prepare($con, $sql);
                            if (!$stmt) {
                                jexit(['ok'=>false,'error'=>'PREPARE_FAIL','msg'=>mysqli_error($con)], 500);
                            }
                            
                            // types: i s i s s s s s i s i i  => 'isisssssisii'
                            mysqli_stmt_bind_param(
                                $stmt,
                                'isisssssisii',
                                $server_id, $apply_person, $apply_time, $apply_reason,
                                $mailTitle, $mailContent, $accountsJson, $itemsJson,
                                $verify_result, $verify_person, $sendType, $visible
                            );
                            
                            if (!mysqli_stmt_execute($stmt)) {
                                jexit(['ok'=>false,'error'=>'INSERT_FAIL','msg'=>mysqli_stmt_error($stmt)], 500);
                            }
                            $newId = mysqli_insert_id($con);
                            mysqli_stmt_close($stmt);
                            
                            // 5) Gọi verify (giống thao tác bấm trên web)
                            $verifyResultWanted = (int)($_REQUEST['verifyResult'] ?? 1); // 1 hoặc 2 tuỳ hệ thống
                            $verifyRes = verify_apply_goods($newId, $verifyResultWanted);
                          //  $res = json_decode($verifyRes, true);
                            if (($verifyRes['ok'] ?? ($verifyRes['msg']['ok'] ?? false)) &&
                                (intval($verifyRes['code'] ?? ($verifyRes['msg']['code'] ?? 0)) === 200)) {
                                notiG100K(0,"Gửi Thành Công !!","success");
                            } else {
                                notiG100K(0,$res,"error");
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

                                                        $con = db_con();
                            
                            // notiG100K(0,$mailid,"success");
                            // 3) Dữ liệu insert (apply_time dùng time())
                            $server_id     = $zoneid;
                            $apply_person  = 'admin';
                            $apply_time    = time(); // <== dùng time()
                            $apply_reason  = 'GM';
                            $mailTitle     = 'G100K - TOOLS VIP';
                            $mailContent   = 'G100K - TOOLS VIP';
                            $accountsJson  = json_encode([$uid], JSON_UNESCAPED_UNICODE);
                            $itemsJson = json_encode([
                                [
                                    'itemID'  => $mailid,
                                    'itemCnt' => $mailnum,
                                ]
                            ], JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
                            $verify_result = 1;
                            $verify_person = '';
                            $sendType      = 2;
                            $visible       = 1;
                            
                            // 4) INSERT bằng prepared procedural để tránh SQL injection

                            if ($activate == 1) {
                                $sql = "INSERT INTO t_apply_goods
                                (server_id, apply_person, apply_time, apply_reason,
                                 mailTitle, mailContent, accounts, items,
                                 verify_result, verify_person, sendType, visible)
                                VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
                                
                                $stmt = mysqli_prepare($con, $sql);
                                if (!$stmt) {
                                    jexit(['ok'=>false,'error'=>'PREPARE_FAIL','msg'=>mysqli_error($con)], 500);
                                }
                                
                                // types: i s i s s s s s i s i i  => 'isisssssisii'
                                mysqli_stmt_bind_param(
                                    $stmt,
                                    'isisssssisii',
                                    $server_id, $apply_person, $apply_time, $apply_reason,
                                    $mailTitle, $mailContent, $accountsJson, $itemsJson,
                                    $verify_result, $verify_person, $sendType, $visible
                                );
                                
                                if (!mysqli_stmt_execute($stmt)) {
                                    jexit(['ok'=>false,'error'=>'INSERT_FAIL','msg'=>mysqli_stmt_error($stmt)], 500);
                                }
                                $newId = mysqli_insert_id($con);
                                mysqli_stmt_close($stmt);
                                
                                // 5) Gọi verify (giống thao tác bấm trên web)
                                $verifyResultWanted = (int)($_REQUEST['verifyResult'] ?? 1); // 1 hoặc 2 tuỳ hệ thống
                                $verifyRes = verify_apply_goods($newId, $verifyResultWanted);
                              //  $res = json_decode($verifyRes, true);
                                if (($verifyRes['ok'] ?? ($verifyRes['msg']['ok'] ?? false)) &&
                                    (intval($verifyRes['code'] ?? ($verifyRes['msg']['code'] ?? 0)) === 200)) {
                                    notiG100K(0,"Gửi Thành Công !!","success");
                                } else {
                                   notiG100K(0,"Gửi Thất Bại !!","error");
                                }
                            } else {
                                notiG100K(0,"Chưa Mua Tools !!","error");
                            }
                            break;
                        case "ban":
                            // 进行数据库查询操作
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd);
                            if (!$con) {
                                exit(
                                    "数据库连接失败：" . mysqli_connect_error()
                                );
                            }
                            mysqli_select_db($con, $dbname2);
                            // 使用参数化查询防止 SQL 注入
                            $sql =
                                "SELECT * FROM `chardesc` WHERE `account` = ? LIMIT 1";
                            $stmt = mysqli_prepare($con, $sql);
                            if (!$stmt) {
                                exit("SQL 预处理失败：" . mysqli_error($con));
                            }
                            // 绑定参数
                            mysqli_stmt_bind_param($stmt, "s", $uid);
                            // 执行查询
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            // 检查查询结果
                            $row = mysqli_fetch_array($result);
                            mysqli_stmt_close($stmt);
                            // 关闭 SQL 语句句柄
                            mysqli_close($con);
                            // 关闭数据库连接
                            // 如果数据库中该物品不是当前用户的，输出 1，否则输出 2
                            if ($row["account"] != $uid) {
                                exit("编号不存在");
                            } else {
                                $con = mysqli_connect(
                                    $dbip,
                                    $dbuser,
                                    $dbpwd,
                                    $dbname
                                );
                                if (!$con) {
                                    die("连接失败: " . mysqli_connect_error());
                                }
                                mysqli_set_charset($con, "utf8");
                                $time = date("Y-m-d H:i:s");
                                $uid = mysqli_real_escape_string($con, $uid);
                                // 防止SQL注入
                                //var_dump($time);exit;
                                $sql = "INSERT INTO `gamecmd` (`serverid`,`cmd`,`data`,`optime`,`opperson`) VALUES ('0','AddDenyAccount','$uid/0','$time','admin')";
                                if (mysqli_query($con, $sql)) {
                                    echo "成功";
                                } else {
                                    echo "失败: " . mysqli_error($con);
                                }
                                mysqli_close($con);
                            }
                            break;
                        case "unban":
                            // 进行数据库查询操作
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd);
                            if (!$con) {
                                exit(
                                    "数据库连接失败：" . mysqli_connect_error()
                                );
                            }
                            mysqli_select_db($con, $dbname2);
                            // 使用参数化查询防止 SQL 注入
                            $sql =
                                "SELECT * FROM `chardesc` WHERE `account` = ? LIMIT 1";
                            $stmt = mysqli_prepare($con, $sql);
                            if (!$stmt) {
                                exit("SQL 预处理失败：" . mysqli_error($con));
                            }
                            // 绑定参数
                            mysqli_stmt_bind_param($stmt, "s", $uid);
                            // 执行查询
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            // 检查查询结果
                            $row = mysqli_fetch_array($result);
                            mysqli_stmt_close($stmt);
                            // 关闭 SQL 语句句柄
                            mysqli_close($con);
                            // 关闭数据库连接
                            // 如果数据库中该物品不是当前用户的，输出 1，否则输出 2
                            if ($row["account"] != $uid) {
                                exit("编号不存在");
                            } else {
                                $con = mysqli_connect(
                                    $dbip,
                                    $dbuser,
                                    $dbpwd,
                                    $dbname
                                );
                                if (!$con) {
                                    die("连接失败: " . mysqli_connect_error());
                                }
                                mysqli_set_charset($con, "utf8");
                                $time = date("Y-m-d H:i:s");
                                $uid = mysqli_real_escape_string($con, $uid);
                                // 防止SQL注入
                                $sql = "INSERT INTO `gamecmd` (`serverId`,`cmd`,`opPerson`,`opTime`,`data`) VALUES ('0','DelDenyAccount','admin','$time','$uid')";
                                if (mysqli_query($con, $sql)) {
                                    echo "成功";
                                } else {
                                    echo "失败: " . mysqli_error($con);
                                }
                                mysqli_close($con);
                            }
                            break;
                        case "notice":
                            $Notice = $_POST["daojunum2"];
                            $con = mysqli_connect(
                                $dbip,
                                $dbuser,
                                $dbpwd,
                                $dbname
                            );
                            if (!$con) {
                                die("连接失败: " . mysqli_connect_error());
                            }
                            mysqli_set_charset($con, "utf8");
                            $time = date("Y-m-d H:i:s");
                            $time2 = time();
                            $time3 = time() + 3600;
                            $uid = mysqli_real_escape_string($con, $uid);
                            // 防止SQL注入
                            $sql = "INSERT INTO `gamecmd` (`serverId`,`cmd`,`opPerson`,`opTime`,`data`) VALUES ($zoneid,'NoticeZMD','admin','$time','56;255;1;;$time2;$time3;10;$Notice')";
                            if (mysqli_query($con, $sql)) {
                                echo "成功";
                            } else {
                                echo "失败: " . mysqli_error($con);
                            }
                            break;
                        case "rolepack1":
                            $con = mysqli_connect(
                                $dbip,
                                $dbuser,
                                $dbpwd,
                                $dbname
                            );
                            if (!$con) {
                                die("连接失败: " . mysqli_connect_error());
                            }
                            mysqli_set_charset($con, "utf8");
                            $uid = mysqli_real_escape_string($con, $uid);
                            $time = time();
                            // 防止SQL注入
                            $sql = "UPDATE mem_mail SET delete_at='{$time}' WHERE uid='{$uid}' AND delete_at=0";
                            if (mysqli_query($con, $sql)) {
                                echo "邮件清理成功！玩家ID：" . $uid;
                            } else {
                                echo "邮件清理失败: " . mysqli_error($con);
                            }
                            break;
                        case "rolepack2":
                            $con = mysqli_connect(
                                $dbip,
                                $dbuser,
                                $dbpwd,
                                $dbname
                            );
                            if (!$con) {
                                die("连接失败: " . mysqli_connect_error());
                            }
                            mysqli_set_charset($con, "utf8");
                            $uid = mysqli_real_escape_string($con, $uid);
                            $time = time();
                            // 防止SQL注入
                            $sql = "DELETE FROM mem_coin WHERE uid='{$uid}'";
                            if (mysqli_query($con, $sql)) {
                                echo "背包清理成功！玩家ID：" . $uid;
                            } else {
                                echo "背包清理失败: " . mysqli_error($con);
                            }
                            break;
                        case "randomcdk":
                            $con = mysqli_connect(
                                $dbip,
                                $dbuser,
                                $dbpwd,
                                "x_account"
                            );
                            if (!$con) {
                                die("连接失败: " . mysqli_connect_error());
                            }
                            mysqli_set_charset($con, "utf8");
                            $uid = mysqli_real_escape_string($con, $uid);
                            $tableCheckQuery = "SHOW TABLES LIKE 'cdks'";
                            $tableCheckResult = mysqli_query(
                                $con,
                                $tableCheckQuery
                            );

                            if (mysqli_num_rows($tableCheckResult) == 0) {
                                // 如果 cdks 表不存在，则创建它
                                $createTableQuery = "
            CREATE TABLE cdks (
                id INT AUTO_INCREMENT PRIMARY KEY, -- 自增ID
                cdk VARCHAR(255) NOT NULL,          -- CDK字段
                lv INT NOT NULL,                    -- 等级字段
                status TINYINT NOT NULL             -- 状态字段 (0或1)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";

                                if (mysqli_query($con, $createTableQuery)) {
                                    echo "无cdks 表 正在创建 cdks 表已成功创建！<br>";
                                } else {
                                    echo "创建 cdks 表时出错: " .
                                        mysqli_error($con);
                                }
                            } else {
                            }

                            // 生成随机 CDK 数据
                            function generateRandomCDK($length = 10)
                            {
                                $characters =
                                    "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                                $charactersLength = strlen($characters);
                                $randomString = "";
                                for ($i = 0; $i < $length; $i++) {
                                    $randomString .=
                                        $characters[
                                            rand(0, $charactersLength - 1)
                                        ];
                                }
                                return $randomString;
                            }

                            for ($i = 0; $i < $cdknum; $i++) {
                                $cdk = generateRandomCDK();
                                $lv = 1; // 固定等级为1
                                $status = 0; // 固定状态为0
                                $insertQuery = "INSERT INTO cdks (cdk, lv, status) VALUES ('$cdk', '$lv', '$status')";
                                if (mysqli_query($con, $insertQuery)) {
                                    echo "CDK 生成成功: $cdk<br>";
                                } else {
                                    echo "生成 CDK 时出错: " .
                                        mysqli_error($con) .
                                        "<br>";
                                }
                            }
                            break;
                        case "userandomcdk":
                            $con = mysqli_connect(
                                $dbip,
                                $dbuser,
                                $dbpwd,
                                "x_account"
                            );
                            if (!$con) {
                                die("连接失败: " . mysqli_connect_error());
                            }
                            mysqli_set_charset($con, "utf8");
                            $uid = mysqli_real_escape_string($con, $uid);
                            $sql = "SELECT cdk FROM cdks WHERE status = 1";
                            $result = mysqli_query($con, $sql);
                            if ($result) {
                                // 创建一个文件并写入查询结果
                                $file = fopen("cdks.txt", "w");
                                while ($row = mysqli_fetch_assoc($result)) {
                                    fwrite($file, $row["cdk"] . "\n");
                                }
                                fclose($file);

                                // 设置文件下载头
                                header("Content-Description: File Transfer");
                                header(
                                    "Content-Type: application/octet-stream"
                                );
                                header(
                                    'Content-Disposition: attachment; filename="cdks.txt"'
                                );
                                header("Expires: 0");
                                header("Cache-Control: must-revalidate");
                                header("Pragma: public");
                                header(
                                    "Content-Length: " . filesize("cdks.txt")
                                );
                                readfile("cdks.txt");

                                // 删除临时文件
                                //unlink("cdks.txt");
                            } else {
                                echo "查询失败: " . mysqli_error($con);
                            }

                            break;
                        case "unrandomcdk":
                            $con = mysqli_connect(
                                $dbip,
                                $dbuser,
                                $dbpwd,
                                "x_account"
                            );
                            if (!$con) {
                                die("连接失败: " . mysqli_connect_error());
                            }
                            mysqli_set_charset($con, "utf8");
                            $uid = mysqli_real_escape_string($con, $uid);
                            $sql = "SELECT cdk FROM cdks WHERE status = 0";
                            $result = mysqli_query($con, $sql);
                            if ($result) {
                                // 创建一个文件并写入查询结果
                                $file = fopen("cdk.txt", "w");
                                while ($row = mysqli_fetch_assoc($result)) {
                                    fwrite($file, $row["cdk"] . "\n");
                                }
                                fclose($file);

                                // 设置文件下载头
                                header("Content-Description: File Transfer");
                                header(
                                    "Content-Type: application/octet-stream"
                                );
                                header(
                                    'Content-Disposition: attachment; filename="cdks.txt"'
                                );
                                header("Expires: 0");
                                header("Cache-Control: must-revalidate");
                                header("Pragma: public");
                                header(
                                    "Content-Length: " . filesize("cdks.txt")
                                );
                                readfile("cdks.txt");

                                // 删除临时文件
                                //unlink("cdks.txt");
                            } else {
                                echo "查询失败: " . mysqli_error($con);
                            }

                            break;
                        case "mail1":
                            $mailid = trim(poststr("item"));
                            if ($mailid == "") {
                                exit("物品ID错误");
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
                                exit("物品ID不存在");
                            }
                            $mailnum = trim(poststr("num"));
                            if (
                                $mailnum == "" ||
                                $mailnum < 0 ||
                                $mailnum > 2000000000
                            ) {
                                exit("发送数量错误");
                            }

                            $itmes =
                                $txts[2] . "#" . $mailid . "#" . trim($mailnum);
                            $mailurl = $qu["mailurl"];
                            $data = [
                                "code" => $gmkey,
                                "uid" => $uid,
                                "items" => $itmes,
                                "title" => "游戏邮件",
                                "content" =>
                                    "亲爱的玩家：这是您的奖励，点击领取！！！",
                            ];
                            $res = postFormRequest($mailurl, $data);

                            if ($res["data"] == 1) {
                                echo "成功";
                            } else {
                                echo "失败: " .
                                    $res["data"] .
                                    $gmkey .
                                    $uid .
                                    $mailurl .
                                    $itmes .
                                    $data;
                            }

                            break;
                        case "addczvip":
                            // 使用 mysqli 连接数据库
                            //$con = @mysqli_connect($dbip, $dbuser, $dbpwd, $dbname2);
                            // 检查连接是否成功
                            //if (mysqli_connect_errno()) {
                            //    die("连接失败: ".mysqli_connect_error());
                            //}
                            // 设置字符集为 utf8
                            //mysqli_set_charset($con, "utf8");
                            // 准备 SQL 查询（使用预处理语句，避免 SQL 注入）
                            //$sql = "SELECT * FROM `chardesc` WHERE `charid` = ? LIMIT 1";
                            //$stmt = mysqli_prepare($con, $sql);
                            // 绑定参数（确保安全，防止 SQL 注入）
                            //mysqli_stmt_bind_param($stmt, "i", $uid);
                            // 执行查询
                            //mysqli_stmt_execute($stmt);
                            // 获取查询结果
                            //$result = mysqli_stmt_get_result($stmt);
                            //$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            // 检查是否有返回数据
                            //if (empty($row)) {
                            //    exit("〖".$quname."〗中无该帐号的角色数据。");
                            //}
                            // 提取 charid，并确保它是整数
                            //$role_id = (int) $row['charid'];
                            // 关闭数据库连接
                            //mysqli_close($con);
                            //if ($row['charid'] == '') {
                            //    exit("〖".$quname."〗中无该帐号的角色数据。");
                            //}
                            $pwd = trim(poststr("pwd"));
                            if ($pwd == "") {
                                exit("玩家后台的授权密码不能为空");
                            }
                            $vipfile = "xundao-" . $quid . ".json";
                            $fp = fopen($vipfile, "a+");
                            if (filesize($vipfile) > 0) {
                                $str = fread($fp, filesize($vipfile));
                                fclose($fp);
                                $vipjson = json_decode($str, true);
                                if ($vipjson == null) {
                                    $vipjson = [];
                                }
                            } else {
                                $vipjson = [];
                            }
                            if (!$vipjson[$uid]) {
                                $vipjson[$uid] = [
                                    "pwd" => $pwd,
                                    "level" => 0,
                                    "quid" => $quid,
                                ];
                                file_put_contents(
                                    $vipfile,
                                    json_encode($vipjson, 320)
                                );
                                exit("加入VIP成功.");
                            } else {
                                exit("该角色名已经是VIP了.");
                            }
                            break;
                        case "addvip":
                            $pwd = trim(poststr("pwd"));
                            if ($pwd == "") {
                                exit("玩家后台的授权密码不能为空");
                            }
                            $vipfile = "xundao-" . $quid . ".json";
                            $fp = fopen($vipfile, "a+");
                            if (filesize($vipfile) > 0) {
                                $str = fread($fp, filesize($vipfile));
                                fclose($fp);
                                $vipjson = json_decode($str, true);
                                if ($vipjson == null) {
                                    $vipjson = [];
                                }
                            } else {
                                $vipjson = [];
                            }
                            if (
                                !$vipjson[$uid] ||
                                intval($vipjson[$uid]["level"] == 0)
                            ) {
                                $vipjson[$uid] = [
                                    "pwd" => $pwd,
                                    "level" => 1,
                                    "quid" => $quid,
                                ];
                                file_put_contents(
                                    $vipfile,
                                    json_encode($vipjson, 320)
                                );
                                exit("加入或升级VIP成功.");
                            } else {
                                exit("该角色名已经是VIP了.");
                            }
                            break;
                        case "quxiaovip":
                            // 使用 mysqli 连接数据库
                            //$con = @mysqli_connect($dbip, $dbuser, $dbpwd, $dbname2);
                            // 检查连接是否成功
                            //if (mysqli_connect_errno()) {
                            //    die("连接失败: ".mysqli_connect_error());
                            //}
                            // 设置字符集为 utf8
                            //mysqli_set_charset($con, "utf8");
                            // 准备 SQL 查询（使用预处理语句，避免 SQL 注入）
                            //$sql = "SELECT * FROM `chardesc` WHERE `charid` = ? LIMIT 1";
                            //$stmt = mysqli_prepare($con, $sql);
                            // 绑定参数（确保安全，防止 SQL 注入）
                            //mysqli_stmt_bind_param($stmt, "i", $uid);
                            // 执行查询
                            //mysqli_stmt_execute($stmt);
                            // 获取查询结果
                            //$result = mysqli_stmt_get_result($stmt);
                            //$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            // 检查是否有返回数据
                            //if (empty($row)) {
                            //    exit("〖".$quname."〗中无该帐号的角色数据。");
                            //}
                            // 提取 charid，并确保它是整数
                            //$role_id = (int) $row['charid'];
                            // 关闭数据库连接
                            //mysqli_close($con);
                            //if ($row['charid'] == '') {
                            //    exit("〖".$quname.
                            //        "〗中无该帐号的角色数据。");
                            //}
                            $vipfile = "xundao-" . $quid . ".json";
                            $fp = fopen($vipfile, "a+");
                            if (filesize($vipfile) > 0) {
                                $str = fread($fp, filesize($vipfile));
                                fclose($fp);
                                $vipjson = json_decode($str, true);
                                if ($vipjson == null) {
                                    $vipjson = [];
                                }
                            } else {
                                $vipjson = [];
                            }
                            if ($vipjson[$uid]) {
                                unset($vipjson[$uid]);
                                file_put_contents(
                                    $vipfile,
                                    json_encode($vipjson, 320)
                                );
                                exit("取消成功.");
                            } else {
                                exit("该角色名并未授权.");
                            }
                            break;
                        case "editpwd":
                            // 使用 mysqli 连接数据库
                            //$con = @mysqli_connect($dbip, $dbuser, $dbpwd, $dbname2);
                            // 检查连接是否成功
                            //if (mysqli_connect_errno()) {
                            //    die("连接失败: ".mysqli_connect_error());
                            //}
                            // 设置字符集为 utf8
                            //mysqli_set_charset($con, "utf8");
                            // 准备 SQL 查询（使用预处理语句，避免 SQL 注入）
                            //$sql = "SELECT * FROM `chardesc` WHERE `charid` = ? LIMIT 1";
                            //$stmt = mysqli_prepare($con, $sql);
                            // 绑定参数（确保安全，防止 SQL 注入）
                            //mysqli_stmt_bind_param($stmt, "i", $uid);
                            // 执行查询
                            //mysqli_stmt_execute($stmt);
                            // 获取查询结果
                            //$result = mysqli_stmt_get_result($stmt);
                            //$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            // 检查是否有返回数据
                            //if (empty($row)) {
                            //    exit("〖".$quname."〗中无该帐号的角色数据。");
                            //}
                            // 提取 charid，并确保它是整数
                            //$role_id = (int) $row['charid'];
                            // 关闭数据库连接
                            //mysqli_close($con);
                            //if ($row['charid'] == '') {
                            //    exit("〖".$quname.
                            //        "〗中无该帐号的角色数据。");
                            //}
                            $pwd = trim(poststr("pwd"));
                            if ($pwd == "") {
                                exit("玩家后台的授权密码不能为空");
                            }
                            $vipfile = "xundao-" . $quid . ".json";
                            $fp = fopen($vipfile, "a+");
                            if (filesize($vipfile) > 0) {
                                $str = fread($fp, filesize($vipfile));
                                fclose($fp);
                                $vipjson = json_decode($str, true);
                                if ($vipjson == null) {
                                    $vipjson = [];
                                }
                            } else {
                                $vipjson = [];
                            }
                            if ($vipjson[$uid]) {
                                $vipjson[$uid] = [
                                    "pwd" => $pwd,
                                    "level" => $vipjson[$uid]["level"],
                                    "quid" => $quid,
                                ];
                                file_put_contents(
                                    $vipfile,
                                    json_encode($vipjson, 320)
                                );
                                exit("修改成功.");
                            } else {
                                exit("该角色名并未授权.");
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
