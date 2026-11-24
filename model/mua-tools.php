<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
include "../config.php";
if (isset($_SESSION['username'])) {
    $date = date("d-m-Y H:i:s");
    $user = $_SESSION['username'];
    $magame = check_string($_POST['tengame']);
    $sid = check_string($_POST['idsever']);
    $nv = check_string($_POST['roleid']);
    //$codedis = $_POST['codedishide'];
    //$giamgia = $ketnoi->query("SELECT * FROM `discount` WHERE `code` = '".$codedis."' AND `sudung` = 0 AND `user` = '".$user."'");
    //$rsdis = mysqli_fetch_array($giamgia);
    //$codegiamgia = $rsdis['code'];
    $time = time();
    $checkmg = $ketnoi->query("SELECT * FROM `category` WHERE `code` = '" . $magame . "'");
    $rs = mysqli_fetch_array($checkmg);
    $severip = $rs['ip'];
    $dtb = $rs['dtb'];
    $xutru = $rs['money'];
    $xutru1 = $rs['money'];
    //$xutru = ($xutru - $xutru * $rsdis['discount'] / 100);
    $gamename = $rs['title'];
    $kiemtra = $ketnoi->query("SELECT * FROM `orders` WHERE `codegame` = '" . $magame . "' AND `acc` = '" . $nv . "' AND `sever` = '" . $sid . "'");
    $rskt = mysqli_fetch_array($kiemtra);
    $lenhsql = array(
        'DLDL' => "UPDATE `wow-dldl_{$sid}`.`users` SET `activate` = '1' WHERE `users`.`account` = '{$nv}'",
        'DLDL2' => "UPDATE `wow-dldl_{$sid}`.`users` SET `activate` = '1' WHERE `users`.`account` = '{$nv}'",
        'TDL' => "UPDATE `wow-dldl_{$sid}`.`users` SET `activate` = '1' WHERE `users`.`account` = '{$nv}'",
        'KHT' => "UPDATE `session{$sid}`.`charbase` SET `activate` = '1' WHERE `charbase`.`NAME` = '{$nv}'",
        'TSMB' => "INSERT INTO `tssy_sdk`.`g100k`(`idnv`, `activate`) VALUES ('{$nv}','1')",
        'COKIEM' => "UPDATE `ts_game_wd{$sid}`.`player_info` SET `activate` = '1' WHERE `account` = '{$nv}'",
        'LVH5' => "UPDATE `xkm_server_100{$sid}`.`role` SET `activate` = '1' WHERE `name` = 's{$sid}.{$nv}'",
        'TTH' => "UPDATE `xm_s{$sid}`.`role` SET `activate` = '1' WHERE `role_name` = '{$nv}'",
        'TDQ' => "UPDATE `xl_s{$sid}`.`role` SET `activate` = '1' WHERE `role_name` = '{$nv}'",
        'NK3D' => "UPDATE `xx_s{$sid}`.`role` SET `activate` = '1' WHERE `role_name` = '{$nv}'",
        'NKGH' => "UPDATE `s{$sid}`.`player` SET `activate` = '1' WHERE `name` = '{$nv}' OR `id` = '{$nv}'",
        'BCTK' => "UPDATE `tdnemo_center_dev`.`player` SET  `activate` = '1' WHERE `accname` = '{$nv}' AND `server_id` = '{$sid}'",
        'VTL' => "UPDATE `vtnemo_center_dev`.`player` SET  `activate` = '1' WHERE `accname` = '{$nv}' AND `server_id` = '{$sid}'",
        'KNTC' => "UPDATE `game_center`.`t_player` SET  `activate` = '1' WHERE `playerName` = '{$nv}' AND `serverId` = '{$sid}'",
        '3QAFK' => "UPDATE `sszg_local_{$sid}`.`role` SET  `activate` = '1' WHERE `account` = '{$nv}'",
        'DCNR' => "UPDATE `sszg_local_{$sid}`.`role` SET  `activate` = '1' WHERE `account` = '{$nv}'",
        'ELO' => "UPDATE `sszg_local_{$sid}`.`role` SET  `activate` = '1' WHERE `account` = '{$nv}'",
        'HTAFK' => "UPDATE `sszg_local_{$sid}`.`role` SET  `vip` = '1' WHERE `account` = '{$nv}'",
        'HC2' => "UPDATE `sszg_local_{$sid}`.`role` SET  `activate` = '1' WHERE `account` = '{$nv}'",
        'TDCL' => "UPDATE `ms_mstop1_s{$sid}`.`tb_player_info` SET  `activate` = '1' WHERE `name` = '[$sid]{$nv}'",
        'AW' => "UPDATE `aldzn_{$sid}`.`t_player_info` SET  `activate` = '1' WHERE `name` = '{$nv}'",
        'MTK' => "UPDATE `actor_560{$sid}`.`charfulldata` SET  `activate` = '1' WHERE `charname` = '{$nv}'",
        'VT' => "UPDATE `accounts`.`accounts` SET  `activate` = '1' WHERE `idnv` = '{$nv}'",
        'VTK' => "UPDATE `ranger_windows_{$sid}`.`db_role_account_p` SET `activate`= '1' WHERE `ranger_windows_{$sid}`.`db_role_account_p`.`data` LIKE '%1_0_{$nv}' OR CAST(`ranger_windows_{$sid}`.`db_role_account_p`.`update_time` AS CHAR CHARACTER SET utf8) COLLATE utf8_general_ci LIKE '%1_0_{$nv}%'",
        'POCKET' => "INSERT INTO `pocket`.`gm`(`idnv`, `activate`, `sever`) VALUES ('{$nv}','1','{$sid}')",
        'PIV2' => "INSERT INTO `pocket`.`gm`(`idnv`, `activate`) VALUES ('{$nv}','1')",
        'PKV3' => "INSERT INTO `pocket`.`gm`(`idnv`, `activate`) VALUES ('{$nv}','1')",
        'OPSS' => "INSERT INTO `account`.`role`(`roleName`, `activate`) VALUES ('{$nv}','1')",
        'LANGLA' => "INSERT INTO `pocket`.`gm`(`idnv`, `activate`) VALUES ('{$nv}','1')",
        'DH' => "INSERT INTO `pocket`.`gm`(`idnv`, `activate`) VALUES ('{$nv}','1')",
        'PK23' => "INSERT INTO `pocket`.`gm`(`idnv`, `activate`) VALUES ('{$nv}','1')",
        'HAITAC3D' => "UPDATE `game_30030`.`t_role` SET  `activate` = '1' WHERE `t_user_name` = '-1_$nv'",
        'TGH5' => "UPDATE `sanguo_game`.`tb_player` SET  `stars` = '1' WHERE `playerName` = '$nv'",
        'HC' => "UPDATE `sszg_local_{$sid}`.`role` SET  `activate` = '1' WHERE `account` = '{$nv}'",
        'HLTBC' => "UPDATE `jhhd_s{$sid}`.`t_u_player` SET  `delete_mark` = '1' WHERE `account` = '{$nv}'",
        'TYTD' => "UPDATE `x_account`.`t_account` SET  `activate` = '1' WHERE `account` = '{$nv}'",
        'LKH5' => "UPDATE `lyz_webgame`.`role` SET  `isng` = '1' WHERE `userid` = '{$nv}' AND `serverid` = '$sid'",
        '3QDV' => "UPDATE `server_400{$sid}`.`t_u_player` SET  `delete_mark` = '1' WHERE `account` = '{$nv}'",
        '3QLEGEND' => "UPDATE `h_sanguo_test_game{$sid}`.`t_account` SET  `isforbid` = '1' WHERE `accountId` = '{$nv}'",
        'TM2D' => "UPDATE `h_game`.`t_account` SET  `isforbid` = '1' WHERE `accountId` = '{$nv}' AND `createServer` = '{$sid}'",
        '3QQAT' => "UPDATE `wdsg_s{$sid}`.`t_u_player` SET  `delete_mark` = '1' WHERE `account` = '{$nv}'",
        'TNH5' => "UPDATE `xnh5_release_game_{$sid}`.`role_login` SET  `via` = '1' WHERE `account` = '{$nv}'",
        '3QSC' => "UPDATE `sanguo{$sid}`.`player` SET  `yuanbao` = '1' WHERE `name` = '{$nv}'",
        'CTH5' => "UPDATE `game_{$sid}`.`ny_role` SET  `activate` = '1' WHERE `name` = 'S{$sid}.{$nv}'",
        'MMH5' => "UPDATE `game_admin`.`account` SET  `activate` = '1' WHERE `user` = '{$nv}'",
        '7BALLH5' => "UPDATE `game_admin`.`account` SET  `activate` = '1' WHERE `user` = '{$nv}'",
        '3QGD' => "UPDATE `game_admin`.`account` SET  `activate` = '1' WHERE `user` = '{$nv}'",
        'CTXDMB' => "UPDATE `qqsg_s{$sid}`.`player` SET  `idfa` = '1' WHERE `unique_id` = '{$nv}'",
        'CTXDH5' => "UPDATE `SgLocal`.`user_zone` SET  `member` = '1' WHERE `pf_key` = '{$nv}' AND `zones` = '|{$sid}'",
        'DHCD' => "UPDATE `agame_10_999`.`dbnamesrecord` SET  `activate` = '1' WHERE `Name` = '{$nv}'",
        'CCH5' => "UPDATE `game_{$sid}`.`ny_role` SET  `activate` = '1' WHERE `name` = 'S{$sid}.{$nv}'",
        'ADS' => "UPDATE `sdk`.`users` SET  `activate` = '1' WHERE `username` = '{$nv}'",
        'TKVD' => "UPDATE `cdk`.`user` SET  `activate` = '1' WHERE `userid` = '{$nv}'",
        'DPTQ2' => "UPDATE `cdk`.`account` SET  `activate` = '1' WHERE `account` = '{$nv}'",
        'MVH5' => "UPDATE `web`.`account` SET  `vip` = '1' WHERE `name` = '{$nv}'",
        'CAUCAH5' => "UPDATE `login`.`user` SET  `serverId` = '1' WHERE `userId` = '{$nv}'",
        'BLH5' => "UPDATE `h5`.`account` SET  `activate` = '1' WHERE `account` = '{$nv}'",
        'DCPK' => "UPDATE `game_30030`.`t_role` SET  `activate` = '1' WHERE `t_name` = '{$nv}'",
        'KULH' => "UPDATE `xw_admin`.`sdk_account_logs` SET  `activate` = '1' WHERE `account` = '{$nv}'",
        'TUTHAN' => "UPDATE `game_ss`.`player` SET  `activate` = '1' WHERE `PlayerName` = '{$nv}'",
        'ZW' => "UPDATE `h_game`.`t_player` SET  `activate` = '1' WHERE `name` = '{$nv}'",
        'MULGH5' => "UPDATE `qj_h5_100{$sid}`.`globaluser` SET `activate` = '1' WHERE `globaluser`.`account` = '{$nv}'",
        'KTH5' => "UPDATE `lx_lord`.`Role` SET  `activate` = '1' WHERE `name` = '{$nv}'",
        'TKCV' => "UPDATE `tzj_login`.`rolelogin` SET `activate` = '1' WHERE `roleName` = '{$nv}'",
        'NGB' => "UPDATE `sszg_local_{$sid}`.`role` SET  `activate` = '1' WHERE `account` = '{$nv}'",
        'MHK' => "UPDATE `account`.`account` SET  `fuli` = '1' WHERE `username` = '{$nv}'",
        'VLNB' => "UPDATE `tcg`.`account` SET  `activate` = '1' WHERE `username` = '{$nv}'",
        'RT' => "UPDATE `h_game`.`t_player` SET `activate` = '1' WHERE `t_player`.`name` = '{$nv}'",
        'PICAHT' => "UPDATE `h_game`.`t_player` SET `activate` = '1' WHERE `t_player`.`name` = '{$nv}'");
    $xutong = $ketnoi->query("SELECT * FROM `users` WHERE `username` = '" . $user . "'")->fetch_assoc()['money'];
    $level = $ketnoi->query("SELECT * FROM `users` WHERE `username` = '" . $user . "'")->fetch_assoc()['level'];
    $sqlup = $lenhsql[$magame];
    
    if ($magame != "" && $xutru != "") {
        //exit ($sqlup);
        if ($rskt['activate'] != '1') {
            if ($xutong >= $xutru) {
                //exit($severip);
                $servername1 = "$severip";
                $username1 = "hk20";
                $password1 = "12082001Lvt";
                $database1 = "$dtb";
                $conn1 = mysqli_connect($servername1, $username1, $password1, $database1);
                if (!$conn1) {
                    $json['status'] = 0;
                    $json['msg'] = "Không Thể Kết Nối Server Game !!!";
                    $json['type'] = "error";
                    exit(json_encode($json));
                }
                mysqli_set_charset($conn1, "utf8");
                $conn1->query("$lenhsql[$magame]");
                if (($conn1->affected_rows) == 1) {

                    //$ketnoi->query("UPDATE `discount` SET `sudung` = 1  WHERE `code` = '".$rsdis['code']."'");
                    @$up = $ketnoi->query("UPDATE `users` SET `money` = `money` - '{$xutru}' WHERE `username` = '" . $user . "'");
                    if ($up) {
                        $ketnoi->query("INSERT INTO `orders`(user,xutru,codegame,game,acc,activate,createTime,sever) VALUES ('" . $user . "','" . $xutru . "','" . $magame . "','" . $gamename . "','" . $nv . "',1,'" . $date . "','" . $sid . "')");
                        $nhanvat = substr($nv, 0, 2) . '*****';
                        $content = 'Vừa mua Tools cho nhân vật ' . $nhanvat . ' game ' . $gamename . ' sever ' . $sid . ' với giá ' . format_cash($xutru) . 'VND';
                        $username = substr($user, 0, 3) . '*****';
                        $ketnoi->query("INSERT INTO ls_mua SET username = '$username', content = '$content', createdate = now() ");
                        $json['status'] = 1;
                        $json['msg'] = "Mua Tools Thành Công Cho <b style='color:red;'>$nv</b>";
                        $json['type'] = "success";
                        $json['url'] = "/history/orders/";
                    }
                    exit(json_encode($json));
                } else {
                    $json['status'] = 0;
                    $json['msg'] = "Nhân Vật $nv Chưa Có Trên Hệ Thống !!!";
                    $json['type'] = "error";
                    exit(json_encode($json));
                }
            } else {
                $json['status'] = 0;
                $json['msg'] = "Bạn Không Đủ Tiền Để Mua!";
                $json['type'] = "error";
                exit(json_encode($json));
            }

        } else if ($rskt['activate'] == '1' && $user == $rskt['user']) {
            $servername2 = "$severip";
            $username2 = "hk20";
            $password2 = "12082001Lvt";
            $database2 = "$dtb";
            $conn2 = mysqli_connect($servername2, $username2, $password2, $database2);
            if (!$conn2) {
                $json['status'] = 0;
                $json['msg'] = "Không Thể Kết Nối Server Game !!!";
                $json['type'] = "error";
                exit(json_encode($json));
            }
            mysqli_set_charset($conn2, "utf8");
            $conn2->query("$sqlup");
            if (($conn2->affected_rows) == 1) {
                $json['status'] = 1;
                $json['msg'] = "<b style='color:green;'>$nv</b> Cập Nhật Thành Công";
                $json['type'] = "success";
                $json['url'] = "";
                exit(json_encode($json));
            } else {
                $json['status'] = 0;
                $json['msg'] = "<b style='color:green;'>$nv</b> Đã Kích Hoặc Tools Trên Hệ Thống !!!";
                $json['type'] = "warning";
                exit(json_encode($json));
            }
        } else {
            $json['status'] = 0;
            $json['msg'] = "Tài khoản của bạn chưa mua Tools Cho <b style='color:green;'>$nv</b> !!!";
            $json['type'] = "error";
            exit(json_encode($json));
        }
    } else {
        $json['status'] = 1;
        $json['msg'] = "Mua Tools Thất Bại !!!";
        $json['type'] = "error";
        $json['url'] = "";
        exit(json_encode($json));
    }
    $getfilter = "'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    $postfilter = "\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    $cookiefilter = "\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    function StopAttack($StrFiltKey, $StrFiltValue, $ArrFiltReq)
    {
        if (is_array($StrFiltValue)) {
            $StrFiltValue = implode($StrFiltValue);
        }
        if (preg_match("/" . $ArrFiltReq . "/is", $StrFiltValue) == 1) {
            print "Hoạt động bất hợp pháp!";
            exit();
        }
    }

    foreach ($_GET as $key => $value) {
        StopAttack($key, $value, $getfilter);
    }
    foreach ($_POST as $key => $value) {
        StopAttack($key, $value, $postfilter);
    }
    foreach ($_COOKIE as $key => $value) {
        StopAttack($key, $value, $cookiefilter);
    }
    function poststr($str)
    {

        return $_POST[$str];

    }

    function strToHex($str)
    {
        $hex = "";
        for ($i = 0; $i < strlen($str); $i++)
            $hex .= dechex(ord($str[$i]));
        $hex = strtoupper($hex);
        return "0x" . $hex;
    }

}
?>