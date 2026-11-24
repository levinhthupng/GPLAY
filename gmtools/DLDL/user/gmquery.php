<?php
include 'config.php';
if ($_SESSION['lasttime'] == '') {
    $_SESSION['lasttime'] = time();
} else {
    if (time() - $_SESSION['lasttime'] < 10) {
        notiG100K(0, "Tools Quá Nhanh ! Lần Nữa Sẽ Khóa Tài Khoản", "warning");
    } else {
        $_SESSION['lasttime'] = time();
    }
}
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
    $quid = trim(poststr('qu'));
    $qu = $quarr[$quid];
    $uid = trim(poststr('uid'));
    $zoneid = $qu['zoneid'];
    $manageurl = $qu['manageurl'];
    $dbip = $qu['host'];
    $dbname = $qu['dbname'];
    $dbuser = $qu['user'];
    $dbpwd = $qu['pwd'];
    $quname = $qu['name'];
    $servers = $qu['servers'];
    $pwd = "8890";
    if ($quid >= 1) {
        if ($uid != '') {
            if ($_POST['type']) {
                $type = trim($_POST['type']);
                $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                mysqli_query("set names 'utf8'");
                mysqli_select_db($dbname, $con);
                $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                $result = mysqli_query($con, $sql);
                $row = mysqli_fetch_array($result);
                mysqli_close($con);
                if ($row['sid'] == '') {
                    mysqli_close($con);
                    notiG100K(0, "Tài Khoản ".$uid." Không Tồn tại !", "error");
                }
                $role_id = $row['sid'];
                $activate = $row['activate'];
                $uid = $role_id;
                switch ($type) {
                    case 'charge':
                        $uid = trim(poststr('uid'));
                        $chargetype = trim(poststr('chargetype'));
                        if ($chargetype == '') {
                            notiG100K(0, "Chưa Chọn Vật Phẩm", "error");
                        }
                        $chargenum = trim(poststr('chargenum'));
                        if ($chargenum == '' || $chargenum < 0 || $chargenum > 9999) {
                            notiG100K(0, "Số Lượng Từ < 9999!", "error");
                        }
                        $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                        mysqli_query("set names 'utf8'");
                        mysqli_select_db($dbname, $con);
                        $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        mysqli_close($con);
                        if ($row['sid'] == '') {
                            mysqli_close($con);
                            notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                        }
                        $login_url = $manageurl . "admin/login/";
                        $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                        $ch = curl_init($login_url); //初始化
                        curl_setopt($ch, CURLOPT_HEADER, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                        $content = curl_exec($ch);
                        preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                        $cookie = $str[1];
                        $role_id = $row['sid'];
                        $title = "G100K - TOOLS FREE";
                        $content = "G100K - TOOLS FREE";
                        $url = $manageurl . "admin/console/mails/publish/dldl_develop/new_post";
                        $attachments = $chargetype . '^' . $chargenum;
                        $date = date("Y-m-d H:i:s", time());
                        $post = array("publishTime" => $date, "offTime" => $date, "date" => 1, "offDate" => 1, "title" => $title, "body" => $content, "servers" => $servers, "attachments" => $attachments, "condition" => "person", "person" => $role_id);
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                        $content = curl_exec($ch);
                        curl_close($ch);
                        mysqli_close($con);
                        notiG100K(0, "Nạp Free Thành Công!", "success");
                        break;
                    case 'yijiantp':
                        if ($activate == 1) {
                            $uid = trim(poststr('uid'));
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                            $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_array($result);
                            if ($row['sid'] != '') {
                                $login_url = $manageurl . "admin/login/";
                                $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                                $ch = curl_init($login_url); //初始化
                                curl_setopt($ch, CURLOPT_HEADER, 1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                $content = curl_exec($ch);
                                preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                                $cookie = $str[1];
                                $role_id = $row['sid'];
                                $attachments = $chargetype . '^' . $chargenum;
                                $date = date("Y-m-d H:i:s", time());
                                for ($i=1001;$i<=1091;$i++){
                                    $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/hero/detail/" . $i . "/edit?kind=breakthrough&argId=0&count=26";
                                    $ch = curl_init($url);
                                    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                    $content = curl_exec($ch);
                                }
                                curl_close($ch);
                                mysqli_close($con);
                                notiG100K(0, "Thành Công!", "success");
                            } else {
                                mysqli_close($con);
                                notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                            }
                        } else {
                            notiG100K(0, "Chưa Mua Tools !", "info");
                        }
                        break;
                    case 'yjhs':
                        if ($activate == 1) {
                            $uid = trim(poststr('uid'));
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                            $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_array($result);
                            if ($row['sid'] != '') {
                                $login_url = $manageurl . "admin/login/";
                                $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                                $ch = curl_init($login_url); //初始化
                                curl_setopt($ch, CURLOPT_HEADER, 1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                $content = curl_exec($ch);
                                preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                                $cookie = $str[1];
                                $role_id = $row['sid'];
                                $attachments = $chargetype . '^' . $chargenum;
                                $date = date("Y-m-d H:i:s", time());
                                for ($i=1001;$i<=1091;$i++){
                                    $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/hero/add/". $i;
                                    $ch = curl_init($url);
                                    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                    $content = curl_exec($ch);
                                }
                                curl_close($ch);
                                mysqli_close($con);
                                notiG100K(0, "Thành Công!", "success");
                            } else {
                                mysqli_close($con);
                                notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                            }
                        } else {
                            notiG100K(0, "Chưa Mua Tools !", "info");
                        }
                        break;
                    case 'yijiantp2':
                        if ($activate == 1) {
                            $uid = trim(poststr('uid'));
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                            $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_array($result);
                            if ($row['sid'] != '') {
                                $login_url = $manageurl . "admin/login/";
                                $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                                $ch = curl_init($login_url); //初始化
                                curl_setopt($ch, CURLOPT_HEADER, 1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                $content = curl_exec($ch);
                                preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                                $cookie = $str[1];
                                $role_id = $row['sid'];
                                $attachments = $chargetype . '^' . $chargenum;
                                $date = date("Y-m-d H:i:s", time());
                                for ($i=1501;$i<=1548;$i++){
                                    $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/zuoqi_add?zuoqiIds=" . $i;
                                    $ch = curl_init($url);
                                    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                    $content = curl_exec($ch);
                                }
                                curl_close($ch);
                                mysqli_close($con);
                                notiG100K(0, "Thành Công!", "success");
                            } else {
                                mysqli_close($con);
                                notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                            }
                        } else {
                            notiG100K(0, "Chưa Mua Tools !", "info");
                        }
                        break;
                    case 'yijianhl':
                        if ($activate == 1) {
                            $uid = trim(poststr('uid'));
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                            $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_array($result);
                            if ($row['sid'] != '') {
                                $login_url = $manageurl . "admin/login/";
                                $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                                $ch = curl_init($login_url); //初始化
                                curl_setopt($ch, CURLOPT_HEADER, 1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                $content = curl_exec($ch);
                                preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                                $cookie = $str[1];
                                $role_id = $row['sid'];
                                $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/soul_spirit_add";
                                $attachments = $chargetype . '^' . $chargenum;
                                $date = date("Y-m-d H:i:s", time());
                                $ch = curl_init($url);
                                curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                                curl_setopt($ch, CURLOPT_HEADER, 0);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                $content = curl_exec($ch);
                                curl_close($ch);
                                mysqli_close($con);
                                notiG100K(0, "Thành Công!", "success");
                            } else {
                                mysqli_close($con);
                                notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                            }
                        } else {
                            notiG100K(0, "Chưa Mua Tools !", "info");
                        }
                        break;
                    case 'yijiansz':
                        if ($activate == 1) {
                            $uid = trim(poststr('uid'));
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                            $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_array($result);
                            if ($row['sid'] != '') {
                                $login_url = $manageurl . "admin/login/";
                                $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                                $ch = curl_init($login_url); //初始化
                                curl_setopt($ch, CURLOPT_HEADER, 1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                $content = curl_exec($ch);
                                preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                                $cookie = $str[1];
                                $role_id = $row['sid'];
                                $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/totem_set_pos?pos=21/" . $role_id . "/";
                                $attachments = $chargetype . '^' . $chargenum;
                                $date = date("Y-m-d H:i:s", time());
                                $ch = curl_init($url);
                                curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                                curl_setopt($ch, CURLOPT_HEADER, 0);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                $content = curl_exec($ch);
                                curl_close($ch);
                                mysqli_close($con);
                                notiG100K(0, "Thành Công!", "success");
                            } else {
                                mysqli_close($con);
                                notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                            }
                        } else {
                            notiG100K(0, "Chưa Mua Tools !", "info");
                        }
                        break;
                    case 'yijianjs':
                        if ($activate == 1) {
                            $uid = trim(poststr('uid'));
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                            $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_array($result);
                            if ($row['sid'] != '') {
                                $login_url = $manageurl . "admin/login/";
                                $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                                $ch = curl_init($login_url); //初始化
                                curl_setopt($ch, CURLOPT_HEADER, 1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                $content = curl_exec($ch);
                                preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                                $cookie = $str[1];
                                $role_id = $row['sid'];
                                $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/metal_city_wave_set?wave=120";
                                $attachments = $chargetype . '^' . $chargenum;
                                $date = date("Y-m-d H:i:s", time());
                                $ch = curl_init($url);
                                curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                                curl_setopt($ch, CURLOPT_HEADER, 0);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                $content = curl_exec($ch);
                                curl_close($ch);
                                mysqli_close($con);
                                notiG100K(0, "Thành Công!", "success");
                            } else {
                                mysqli_close($con);
                                notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                            }
                        } else {
                            notiG100K(0, "Chưa Mua Tools !", "info");
                        }
                        break;
                    case 'jyyj':
                        if ($activate == 1) {
                            $uid = trim(poststr('uid'));
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                            $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_array($result);
                            if ($row['sid'] != '') {
                                $login_url = $manageurl . "admin/login/";
                                $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);

                                $ch = curl_init($login_url); //初始化
                                curl_setopt($ch, CURLOPT_HEADER, 1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                $content = curl_exec($ch);
                                preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                                $cookie = $str[1];
                                $role_id = $row['sid'];
                                $attachments = $chargetype . '^' . $chargenum;
                                $date = date("Y-m-d H:i:s", time());
                                $guanka = [1020101,1020102,1020103,1020201,1020202,1020203,1020301,1020302,1020303,1020304,1020401,1020402,1020403,1020404,1020501,1020502,1020503,1020504,1020601,1020602,1020603,1020604,1020701,1020702,1020703,1020704,1020801,1020802,1020803,1020804,1020901,1020902,1020903,1020904,1021001,1021002,1021003,1021004,1021101,1021102,1021103,1021104,1021201,1021202,1021203,1021204,1021301,1021302,1021303,1021304,1021401,1021402,1021403,1021404,1021501,1021502,1021503,1021504,1021601,1021602,1021603,1021604,1021701,1021702,1021703,1021704,1021801,1021802,1021803,1021804,1021901,1021902,1021903,1021904,1022001,1022002,1022003,1022004,1022101,1022102,1022103,1022104,1022201,1022202,1022203,1022204,1022301,1022302,1022303,1022304,1022401,1022402,1022403,1022404,1022501,1022502,1022503,1022504,1022601,1022602,1022603,1022604,1022701,1022702,1022703,1022704,1022801,1022802,1022803,1022804,1022901,1022902,1022903,1022904,1023001,1023002,1023003,1023004,1023101,1023102,1023103,1023104,1023201,1023202,1023203,1023204,1023301,1023302,1023303,1023304,1023401,1023402,1023403,1023404,1023501,1023502,1023503,1023504,1023601,1023602,1023603,1023604,1023701,1023702,1023703,1023704,1023801,1023802,1023803,1023804,1023901,1023902,1023903,1023904,1024001,1024002,1024003,1024004,1024101,1024102,1024103,1024104,1024201,1024202,1024203,1024204,1024301,1024302,1024303,1024304,1024401,1024402,1024403,1024404,1024501,1024502,1024503,1024504,1024601,1024602,1024603,1024604,1024701,1024702,1024703,1024704,1024801,1024802,1024803,1024804,1024901,1024902,1024903,1024904,1025001,1025002,1025003,1025004,1025101,1025102,1025103,1025104,1025201,1025202,1025203,1025204,1025301,1025302,1025303,1025304,1025401,1025402,1025403,1025404,1025501,1025502,1025503,1025504,1025601,1025602,1025603,1025604,1025701,1025702,1025703,1025704,1025801,1025802,1025803,1025804,1025901,1025902,1025903,1025904,1026001,1026002,1026003,1026004,1026101,1026102,1026103,1026104,1026201,1026202,1026203,1026204,1026301,1026302,1026303,1026304,1026401,1026402,1026403,1026404,1026501,1026502,1026503,1026504,1026601,1026602,1026603,1026604,1026701,1026702,1026703,1026704,1030101,1030102,1030103,1030104,1030105,1030106,1030107,1030108,1030109,1030110,1030111,1030112,1030201,1030202,1030203,1030204,1030205,1030206,1030207,1030208,1030209,1030210,1030211,1030212,1030301,1030302,1030303,1030304,1030305,1030306,1030307,1030308,1030309,1030310,1030311,1030312,1030313,1030314,1030315,1030316,1030401,1030402,1030403,1030404,1030405,1030406,1030407,1030408,1030409,1030410,1030411,1030412,1030413,1030414,1030415,1030416,1030501,1030502,1030503,1030504,1030505,1030506,1030507,1030508,1030509,1030510,1030511,1030512,1030513,1030514,1030515,1030516,1030601,1030602,1030603,1030604,1030605,1030606,1030607,1030608,1030609,1030610,1030611,1030612,1030613,1030614,1030615,1030616,1030701,1030702,1030703,1030704,1030705,1030706,1030707,1030708,1030709,1030710,1030711,1030712,1030713,1030714,1030715,1030716,1030801,1030802,1030803,1030804,1030805,1030806,1030807,1030808,1030809,1030810,1030811,1030812,1030813,1030814,1030815,1030816,1030901,1030902,1030903,1030904,1030905,1030906,1030907,1030908,1030909,1030910,1030911,1030912,1030913,1030914,1030915,1030916,1031001,1031002,1031003,1031004,1031005,1031006,1031007,1031008,1031009,1031010,1031011,1031012,1031013,1031014,1031015,1031016,1031101,1031102,1031103,1031104,1031105,1031106,1031107,1031108,1031109,1031110,1031111,1031112,1031113,1031114,1031115,1031116,1031201,1031202,1031203,1031204,1031205,1031206,1031207,1031208,1031209,1031210,1031211,1031212,1031213,1031214,1031215,1031216,1031301,1031302,1031303,1031304,1031305,1031306,1031307,1031308,1031309,1031310,1031311,1031312,1031313,1031314,1031315,1031316,1031401,1031402,1031403,1031404,1031405,1031406,1031407,1031408,1031409,1031410,1031411,1031412,1031413,1031414,1031415,1031416,1031501,1031502,1031503,1031504,1031505,1031506,1031507,1031508,1031509,1031510,1031511,1031512,1031513,1031514,1031515,1031516,1031601,1031602,1031603,1031604,1031605,1031606,1031607,1031608,1031609,1031610,1031611,1031612,1031613,1031614,1031615,1031616,1031701,1031702,1031703,1031704,1031705,1031706,1031707,1031708,1031709,1031710,1031711,1031712,1031713,1031714,1031715,1031716,1031801,1031802,1031803,1031804,1031805,1031806,1031807,1031808,1031809,1031810,1031811,1031812,1031813,1031814,1031815,1031816,1031901,1031902,1031903,1031904,1031905,1031906,1031907,1031908,1031909,1031910,1031911,1031912,1031913,1031914,1031915,1031916,1032001,1032002,1032003,1032004,1032005,1032006,1032007,1032008,1032009,1032010,1032011,1032012,1032013,1032014,1032015,1032016,1032101,1032102,1032103,1032104,1032105,1032106,1032107,1032108,1032109,1032110,1032111,1032112,1032113,1032114,1032115,1032116,1032201,1032202,1032203,1032204,1032205,1032206,1032207,1032208,1032209,1032210,1032211,1032212,1032213,1032214,1032215,1032216,1032301,1032302,1032303,1032304,1032305,1032306,1032307,1032308,1032309,1032310,1032311,1032312,1032313,1032314,1032315,1032316,1032401,1032402,1032403,1032404,1032405,1032406,1032407,1032408,1032409,1032410,1032411,1032412,1032413,1032414,1032415,1032416,1032501,1032502,1032503,1032504,1032505,1032506,1032507,1032508,1032509,1032510,1032511,1032512,1032513,1032514,1032515,1032516,1032601,1032602,1032603,1032604,1032605,1032606,1032607,1032608,1032609,1032610,1032611,1032612,1032613,1032614,1032615,1032616,1032701,1032702,1032703,1032704,1032705,1032706,1032707,1032708,1032709,1032710,1032711,1032712,1032713,1032714,1032715,1032716,1032801,1032802,1032803,1032804,1032805,1032806,1032807,1032808,1032809,1032810,1032811,1032812,1032813,1032814,1032815,1032816,1032901,1032902,1032903,1032904,1032905,1032906,1032907,1032908,1032909,1032910,1032911,1032912,1032913,1032914,1032915,1032916,1033001,1033002,1033003,1033004,1033005,1033006,1033007,1033008,1033009,1033010,1033011,1033012,1033013,1033014,1033015,1033016,1033101,1033102,1033103,1033104,1033105,1033106,1033107,1033108,1033109,1033110,1033111,1033112,1033113,1033114,1033115,1033116,1033201,1033202,1033203,1033204,1033205,1033206,1033207,1033208,1033209,1033210,1033211,1033212,1033213,1033214,1033215,1033216,1033301,1033302,1033303,1033304,1033305,1033306,1033307,1033308,1033309,1033310,1033311,1033312,1033313,1033314,1033315,1033316,1033401,1033402,1033403,1033404,1033405,1033406,1033407,1033408,1033409,1033410,1033411,1033412,1033413,1033414,1033415,1033416,1033501,1033502,1033503,1033504,1033505,1033506,1033507,1033508,1033509,1033510,1033511,1033512,1033513,1033514,1033515,1033516,1033601,1033602,1033603,1033604,1033605,1033606,1033607,1033608,1033609,1033610,1033611,1033612,1033613,1033614,1033615,1033616,1033701,1033702,1033703,1033704,1033705,1033706,1033707,1033708,1033709,1033710,1033711,1033712,1033713,1033714,1033715,1033716,1033801,1033802,1033803,1033804,1033805,1033806,1033807,1033808,1033809,1033810,1033811,1033812,1033813,1033814,1033815,1033816,1033901,1033902,1033903,1033904,1033905,1033906,1033907,1033908,1033909,1033910,1033911,1033912,1033913,1033914,1033915,1033916,1034001,1034002,1034003,1034004,1034005,1034006,1034007,1034008,1034009,1034010,1034011,1034012,1034013,1034014,1034015,1034016,1034101,1034102,1034103,1034104,1034105,1034106,1034107,1034108,1034109,1034110,1034111,1034112,1034113,1034114,1034115,1034116,1034201,1034202,1034203,1034204,1034205,1034206,1034207,1034208,1034209,1034210,1034211,1034212,1034213,1034214,1034215,1034216,1034301,1034302,1034303,1034304,1034305,1034306,1034307,1034308,1034309,1034310,1034311,1034312,1034313,1034314,1034315,1034316,1034401,1034402,1034403,1034404,1034405,1034406,1034407,1034408,1034409,1034410,1034411,1034412,1034413,1034414,1034415,1034416,1034501,1034502,1034503,1034504,1034505,1034506,1034507,1034508,1034509,1034510,1034511,1034512,1034513,1034514,1034515,1034516,1034601,1034602,1034603,1034604,1034605,1034606,1034607,1034608,1034609,1034610,1034611,1034612,1034613,1034614,1034615,1034616,1034701,1034702,1034703,1034704,1034705,1034706,1034707,1034708,1034709,1034710,1034711,1034712,1034713,1034714,1034715,1034716,1034801,1034802,1034803,1034804,1034805,1034806,1034807,1034808,1034809,1034810,1034811,1034812,1034813,1034814,1034815,1034816,1034901,1034902,1034903,1034904,1034905,1034906,1034907,1034908,1034909,1034910,1034911,1034912,1034913,1034914,1034915,1034916,1035001,1035002,1035003,1035004,1035005,1035006,1035007,1035008,1035009,1035010,1035011,1035012,1035013,1035014,1035015,1035016,1035101,1035102,1035103,1035104,1035105,1035106,1035107,1035108,1035109,1035110,1035111,1035112,1035113,1035114,1035115,1035116,1035201,1035202,1035203,1035204,1035205,1035206,1035207,1035208,1035209,1035210,1035211,1035212,1035213,1035214,1035215,1035216,1035301,1035302,1035303,1035304,1035305,1035306,1035307,1035308,1035309,1035310,1035311,1035312,1035313,1035314,1035315,1035316,1035401,1035402,1035403,1035404,1035405,1035406,1035407,1035408,1035409,1035410,1035411,1035412,1035413,1035414,1035415,1035416,1035501,1035502,1035503,1035504,1035505,1035506,1035507,1035508,1035509,1035510,1035511,1035512,1035513,1035514,1035515,1035516,1035601,1035602,1035603,1035604,1035605,1035606,1035607,1035608,1035609,1035610,1035611,1035612,1035613,1035614,1035615,1035616,1035701,1035702,1035703,1035704,1035705,1035706,1035707,1035708,1035709,1035710,1035711,1035712,1035713,1035714,1035715,1035716,1035801,1035802,1035803,1035804,1035805,1035806,1035807,1035808,1035809,1035810,1035811,1035812,1035813,1035814,1035815,1035816,1035901,1035902,1035903,1035904,1035905,1035906,1035907,1035908,1035909,1035910,1035911,1035912,1035913,1035914,1035915,1035916,1036001,1036002,1036003,1036004,1036005,1036006,1036007,1036008,1036009,1036010,1036011,1036012,1036013,1036014,1036015,1036016,1036101,1036102,1036103,1036104,1036105,1036106,1036107,1036108,1036109,1036110,1036111,1036112,1036113,1036114,1036115,1036116,1036201,1036202,1036203,1036204,1036205,1036206,1036207,1036208,1036209,1036210,1036211,1036212,1036213,1036214,1036215,1036216,1036301,1036302,1036303,1036304,1036305,1036306,1036307,1036308,1036309,1036310,1036311,1036312,1036313,1036314,1036315,1036316,1036401,1036402,1036403,1036404,1036405,1036406,1036407,1036408,1036409,1036410,1036411,1036412,1036413,1036414,1036415,1036416,1036501,1036502,1036503,1036504,1036505,1036506,1036507,1036508,1036509,1036510,1036511,1036512,1036513,1036514,1036515,1036516,1036601,1036602,1036603,1036604,1036605,1036606,1036607,1036608,1036609,1036610,1036611,1036612,1036613,1036614,1036615,1036616,1040101,1040102,1040103,1040104,1040105,1040106,1040107,1040108,1040109,1040110,1040111,1040112,1040113,1040114,1040115,1040116,1040117,1040118,1040119,1040120,1040201,1040202,1040203,1040204,103007,1040206,1040207,1040208,1040209,1040210,1040211,1040212,1040213,1040214,1040215,1040216,1040217,1040218,1040219,1040220,1040301,1040302,1040303,1040304,1040305,1040306,1040307,1040308,1040309,1040310,1040311,1040312,1040313,1040314,1040315,1040316,1040317,1040318,1040319,1040320,1040401,1040402,1040403,1040404,1040405,1040406,1040407,1040408,1040409,1040410,1040411,1040412,1040413,1040414,1040415,1040416,1040417,1040418,1040419,1040420,1040421,1040422,1040423,1040424,1040425,1040501,1040502,1040503,1040504,1040505,1040506,1040507,1040508,1040509,1040510,1040511,1040512,1040513,1040514,1040515,1040516,1040517,1040518,1040519,1040520,1040521,1040522,1040523,1040524,1040525,1040601,1040602,1040603,1040604,1040605,1040606,1040607,1040608,1040609,1040610,1040611,1040612,1040613,1040614,1040615,1040616,1040617,1040618,1040619,1040620,1040621,1040622,1040623,1040624,1040625,1040701,1040702,1040703,1040704,1040705,1040706,1040707,1040708,1040709,1040710,1040711,1040712,1040713,1040714,1040715,1040716,1040717,1040718,1040719,1040720,1040721,1040722,1040723,1040724,1040725,1040801,1040802,1040803,1040804,1040805,1040806,1040807,1040808,1040809,1040810,1040811,1040812,1040813,1040814,1040815,1040816,1040817,1040818,1040819,1040820,1040821,1040822,1040823,1040824,1040825,1040826,1040827,1040828,1040829,1040830,1040901,1040902,1040903,1040904,1040905,1040906,1040907,1040908,1040909,1040910,1040911,1040912,1040913,1040914,1040915,1040916,1040917,1040918,1040919,1040920,1040921,1040922,1040923,1040924,1040925,1040926,1040927,1040928,1040929,1040930,1041001,1041002,1041003,1041004,1041005,1041006,1041007,1041008,1041009,1041010,1041011,1041012,1041013,1041014,1041015,1041016,1041017,1041018,1041019,1041020,1041021,1041022,1041023,1041024,1041025,1041026,1041027,1041028,1041029,1041030,1041101,1041102,1041103,1041104,1041105,1041106,1041107,1041108,1041109,1041110,1041111,1041112,1041113,1041114,1041115,1041116,1041117,1041118,1041119,1041120,1041121,1041122,1041123,1041124,1041125,1041126,1041127,1041128,1041129,1041130,1041201,1041202,1041203,1041204,1041205,1041206,1041207,1041208,1041209,1041210,1041211,1041212,1041213,1041214,1041215,1041216,1041217,1041218,1041219,1041220,1041221,1041222,1041223,1041224,1041225,1041226,1041227,1041228,1041229,1041230,1041301,1041302,1041303,1041304,1041305,1041306,1041307,1041308,1041309,1041310,1041311,1041312,1041313,1041314,1041315,1041316,1041317,1041318,1041319,1041320,1041321,1041322,1041323,1041324,1041325,1041326,1041327,1041328,1041329,1041330]; 
                                foreach($guanka as $gk){
                                    $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/dungeons/pass?dungeonId=$gk";
                                    $ch = curl_init($url);
                                    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                    $content = curl_exec($ch);
                                }
                                curl_close($ch);


                                mysqli_close($con);
                                notiG100K(0, "Thành Công!", "success");
                            } else {
                                mysqli_close($con);
                                notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                            }
                        } else {
                            notiG100K(0, "Chưa Mua Tools !", "info");
                        }
                        break;
                    case 'ssyj':
                        if ($activate == 1) {
                            $uid = trim(poststr('uid'));
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                            $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_array($result);
                            if ($row['sid'] != '') {
                                $login_url = $manageurl . "admin/login/";
                                $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);

                                $ch = curl_init($login_url); //初始化
                                curl_setopt($ch, CURLOPT_HEADER, 1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                $content = curl_exec($ch);
                                preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                                $cookie = $str[1];
                                $role_id = $row['sid'];
                                $attachments = $chargetype . '^' . $chargenum;
                                $date = date("Y-m-d H:i:s", time());
                                $guanka = [1030101,1030102,1030103,1030104,1030105,1030106,1030107,1030108,1030109,1030110,1030111,1030112];
                                foreach($guanka as $gk){
                                    $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/dungeons/passWelfare?dungeonId=$gk";
                                    $ch = curl_init($url);
                                    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                    $content = curl_exec($ch);
                                }
                                curl_close($ch);


                                mysqli_close($con);
                                notiG100K(0, "Thành Công!", "success");
                            } else {
                                mysqli_close($con);
                                notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                            }
                        } else {
                            notiG100K(0, "Chưa Mua Tools !", "info");
                        }
                        break;
                    case 'daoju':
                        $uid = trim(poststr('uid'));
                        $mailid = trim(poststr('mailid'));
                        if ($mailid == '') {
                            notiG100K(0, "Chưa Chọn Vật Phẩm !", "warning");
                        }
                        $find = false;
                        $file = fopen("../item.txt", "r");
                        while (!feof($file)) {
                            $line = fgets($file);
                            $txts = explode(';', $line);
                            if ((int)$txts[1] == (int)$mailid) {
                                $find = true;
                            }
                        }
                        fclose($file);
                        if ($find == false) {
                            notiG100K(0, "Vật Phẩm Không Tồn Tại!", "warning");
                        }
                        $mailnum = trim(poststr('mailnum'));
                        if ($mailnum == '' || $mailnum < 0 || $mailnum > 2000000000) {
                            notiG100K(0, "Số Lượng Quá Lớn !", "warning");
                        }
                        if ($activate == 1) {
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                            $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_array($result);
                            if ($row['sid'] != '') {
                                $login_url = $manageurl . "admin/login/";
                                $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                                $ch = curl_init($login_url); //初始化
                                curl_setopt($ch, CURLOPT_HEADER, 1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                $content = curl_exec($ch);
                                preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                                $cookie = $str[1];
                                $role_id = $row['sid'];
                                $title = "G100K - TOOLS VIP";
                                $content = "G100K - TOOLS VIP";
                                $url = $manageurl . "admin/console/mails/publish/dldl_develop/new_post";
                                $attachments = $mailid . '^' . $mailnum;
                                $date = date("Y-m-d H:i:s", time());
                                $enddate = date("Y-m-d H:i:s", time() + 10);
                                $post = array("publishTime" => $date, "offTime" => $enddate, "date" => 1, "offDate" => 1, "title" => $title, "body" => $content, "servers" => $servers, "attachments" => $attachments, "condition" => "person", "person" => $row['sid']);
                                $ch = curl_init($url);
                                curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                                curl_setopt($ch, CURLOPT_HEADER, 0);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                $content = curl_exec($ch);
                                curl_close($ch);
                                mysqli_close($con);
                                notiG100K(0, "Thành Công!", "success");
                            } else {
                                mysqli_close($con);
                                notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                            }
                        } else {
                            notiG100K(0, "Chưa Mua Tools !", "info");
                        }
                        break;
                    case 'clearbag':
                        $uid = trim(poststr('uid'));
                        $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                        mysqli_query("set names 'utf8'");
                        mysqli_select_db($dbname, $con);
                        $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        if ($row['sid'] != '') {
                            $login_url = $manageurl . "admin/login/";
                            $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                            $ch = curl_init($login_url); //初始化
                            curl_setopt($ch, CURLOPT_HEADER, 1);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                            $content = curl_exec($ch);
                            preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                            $cookie = $str[1];
                            $role_id = $row['sid'];
                            $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/item_clean";
                            $attachments = $chargetype . '^' . $chargenum;
                            $date = date("Y-m-d H:i:s", time());
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                            $content = curl_exec($ch);
                            curl_close($ch);
                            mysqli_close($con);
                            notiG100K(0, "Thành Công!", "success");
                        } else {
                            mysqli_close($con);
                            notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                        }
                        break;
                    case 'closeinfo':
                        $uid = trim(poststr('uid'));
                        $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                        mysqli_query("set names 'utf8'");
                        mysqli_select_db($dbname, $con);
                        $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        if ($row['sid'] != '') {
                            $login_url = $manageurl . "admin/login/";
                            $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                            $ch = curl_init($login_url); //初始化
                            curl_setopt($ch, CURLOPT_HEADER, 1);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                            $content = curl_exec($ch);
                            preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                            $cookie = $str[1];
                            $role_id = $row['sid'];
                            $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/tutorial";
                            $attachments = $chargetype . '^' . $chargenum;
                            $date = date("Y-m-d H:i:s", time());
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                            $content = curl_exec($ch);
                            curl_close($ch);
                            mysqli_close($con);
                            notiG100K(0, "Thành Công!", "success");
                        } else {
                            mysqli_close($con);
                            notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                        }
                        break;
                    case 'ptyj':
                        if ($activate == 1) {
                            $uid = trim(poststr('uid'));
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                            $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_array($result);
                            if ($row['sid'] != '') {
                                $login_url = $manageurl . "admin/login/";
                                $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);

                                $ch = curl_init($login_url); //初始化
                                curl_setopt($ch, CURLOPT_HEADER, 1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                $content = curl_exec($ch);
                                preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                                $cookie = $str[1];
                                $role_id = $row['sid'];
                                $attachments = $chargetype . '^' . $chargenum;
                                $date = date("Y-m-d H:i:s", time());
                                $guanka = [1010101,1010102,1010103,1010104,1010105,1010106,1010107,1010108,1010109,1010110,1010111,1010112,1010201,1010202,1010203,1010204,1010205,1010206,1010207,1010208,1010209,1010210,1010211,1010212,1010301,1010302,1010303,1010304,1010305,1010306,1010307,1010308,1010309,1010310,1010311,1010312,1010313,1010314,1010315,1010316,1010401,1010402,1010403,1010404,1010405,1010406,1010407,1010408,1010409,1010410,1010411,1010412,1010413,1010414,1010415,1010416,1010501,1010502,1010503,1010504,1010505,1010506,1010507,1010508,1010509,1010510,1010511,1010512,1010513,1010514,1010515,1010516,1010601,1010602,1010603,1010604,1010605,1010606,1010607,1010608,1010609,1010610,1010611,1010612,1010613,1010614,1010615,1010616,1010701,1010702,1010703,1010704,1010705,1010706,1010707,1010708,1010709,1010710,1010711,1010712,1010713,1010714,1010715,1010716,1010801,1010802,1010803,1010804,1010805,1010806,1010807,1010808,1010809,1010810,1010811,1010812,1010813,1010814,1010815,1010816,1010901,1010902,1010903,1010904,1010905,1010906,1010907,1010908,1010909,1010910,1010911,1010912,1010913,1010914,1010915,1010916,1011001,1011002,1011003,1011004,1011005,1011006,1011007,1011008,1011009,1011010,1011011,1011012,1011013,1011014,1011015,1011016,1011101,1011102,1011103,1011104,1011105,1011106,1011107,1011108,1011109,1011110,1011111,1011112,1011113,1011114,1011115,1011116,1011201,1011202,1011203,1011204,1011205,1011206,1011207,1011208,1011209,1011210,1011211,1011212,1011213,1011214,1011215,1011216,1011301,1011302,1011303,1011304,1011305,1011306,1011307,1011308,1011309,1011310,1011311,1011312,1011313,1011314,1011315,1011316,1011401,1011402,1011403,1011404,1011405,1011406,1011407,1011408,1011409,1011410,1011411,1011412,1011413,1011414,1011415,1011416,1011501,1011502,1011503,1011504,1011505,1011506,1011507,1011508,1011509,1011510,1011511,1011512,1011513,1011514,1011515,1011516,1011601,1011602,1011603,1011604,1011605,1011606,1011607,1011608,1011609,1011610,1011611,1011612,1011613,1011614,1011615,1011616,1011701,1011702,1011703,1011704,1011705,1011706,1011707,1011708,1011709,1011710,1011711,1011712,1011713,1011714,1011715,1011716,1011801,1011802,1011803,1011804,1011805,1011806,1011807,1011808,1011809,1011810,1011811,1011812,1011813,1011814,1011815,1011816,1011901,1011902,1011903,1011904,1011905,1011906,1011907,1011908,1011909,1011910,1011911,1011912,1011913,1011914,1011915,1011916,1012001,1012002,1012003,1012004,1012005,1012006,1012007,1012008,1012009,1012010,1012011,1012012,1012013,1012014,1012015,1012016,1012101,1012102,1012103,1012104,1012105,1012106,1012107,1012108,1012109,1012110,1012111,1012112,1012113,1012114,1012115,1012116,1012201,1012202,1012203,1012204,1012205,1012206,1012207,1012208,1012209,1012210,1012211,1012212,1012213,1012214,1012215,1012216,1012301,1012302,1012303,1012304,1012305,1012306,1012307,1012308,1012309,1012310,1012311,1012312,1012313,1012314,1012315,1012316,1012401,1012402,1012403,1012404,1012405,1012406,1012407,1012408,1012409,1012410,1012411,1012412,1012413,1012414,1012415,1012416,1012501,1012502,1012503,1012504,1012505,1012506,1012507,1012508,1012509,1012510,1012511,1012512,1012513,1012514,1012515,1012516,1012601,1012602,1012603,1012604,1012605,1012606,1012607,1012608,1012609,1012610,1012611,1012612,1012613,1012614,1012615,1012616,1012701,1012702,1012703,1012704,1012705,1012706,1012707,1012708,1012709,1012710,1012711,1012712,1012713,1012714,1012715,1012716,1012801,1012802,1012803,1012804,1012805,1012806,1012807,1012808,1012809,1012810,1012811,1012812,1012813,1012814,1012815,1012816,1012901,1012902,1012903,1012904,1012905,1012906,1012907,1012908,1012909,1012910,1012911,1012912,1012913,1012914,1012915,1012916,1013001,1013002,1013003,1013004,1013005,1013006,1013007,1013008,1013009,1013010,1013011,1013012,1013013,1013014,1013015,1013016,1013101,1013102,1013103,1013104,1013105,1013106,1013107,1013108,1013109,1013110,1013111,1013112,1013113,1013114,1013115,1013116,1013201,1013202,1013203,1013204,1013205,1013206,1013207,1013208,1013209,1013210,1013211,1013212,1013213,1013214,1013215,1013216,1013301,1013302,1013303,1013304,1013305,1013306,1013307,1013308,1013309,1013310,1013311,1013312,1013313,1013314,1013315,1013316,1013401,1013402,1013403,1013404,1013405,1013406,1013407,1013408,1013409,1013410,1013411,1013412,1013413,1013414,1013415,1013416,1013501,1013502,1013503,1013504,1013505,1013506,1013507,1013508,1013509,1013510,1013511,1013512,1013513,1013514,1013515,1013516,1013601,1013602,1013603,1013604,1013605,1013606,1013607,1013608,1013609,1013610,1013611,1013612,1013613,1013614,1013615,1013616,1013701,1013702,1013703,1013704,1013705,1013706,1013707,1013708,1013709,1013710,1013711,1013712,1013713,1013714,1013715,1013716,1013801,1013802,1013803,1013804,1013805,1013806,1013807,1013808,1013809,1013810,1013811,1013812,1013813,1013814,1013815,1013816,1013901,1013902,1013903,1013904,1013905,1013906,1013907,1013908,1013909,1013910,1013911,1013912,1013913,1013914,1013915,1013916,1014001,1014002,1014003,1014004,1014005,1014006,1014007,1014008,1014009,1014010,1014011,1014012,1014013,1014014,1014015,1014016,1014101,1014102,1014103,1014104,1014105,1014106,1014107,1014108,1014109,1014110,1014111,1014112,1014113,1014114,1014115,1014116,1014201,1014202,1014203,1014204,1014205,1014206,1014207,1014208,1014209,1014210,1014211,1014212,1014213,1014214,1014215,1014216,1014301,1014302,1014303,1014304,1014305,1014306,1014307,1014308,1014309,1014310,1014311,1014312,1014313,1014314,1014315,1014316,1014401,1014402,1014403,1014404,1014405,1014406,1014407,1014408,1014409,1014410,1014411,1014412,1014413,1014414,1014415,1014416,1014501,1014502,1014503,1014504,1014505,1014506,1014507,1014508,1014509,1014510,1014511,1014512,1014513,1014514,1014515,1014516,1014601,1014602,1014603,1014604,1014605,1014606,1014607,1014608,1014609,1014610,1014611,1014612,1014613,1014614,1014615,1014616,1014701,1014702,1014703,1014704,1014705,1014706,1014707,1014708,1014709,1014710,1014711,1014712,1014713,1014714,1014715,1014716,1014801,1014802,1014803,1014804,1014805,1014806,1014807,1014808,1014809,1014810,1014811,1014812,1014813,1014814,1014815,1014816,1014901,1014902,1014903,1014904,1014905,1014906,1014907,1014908,1014909,1014910,1014911,1014912,1014913,1014914,1014915,1014916,1015001,1015002,1015003,1015004,1015005,1015006,1015007,1015008,1015009,1015010,1015011,1015012,1015013,1015014,1015015,1015016,1015101,1015102,1015103,1015104,1015105,1015106,1015107,1015108,1015109,1015110,1015111,1015112,1015113,1015114,1015115,1015116,1015201,1015202,1015203,1015204,1015205,1015206,1015207,1015208,1015209,1015210,1015211,1015212,1015213,1015214,1015215,1015216,1015301,1015302,1015303,1015304,1015305,1015306,1015307,1015308,1015309,1015310,1015311,1015312,1015313,1015314,1015315,1015316,1015401,1015402,1015403,1015404,1015405,1015406,1015407,1015408,1015409,1015410,1015411,1015412,1015413,1015414,1015415,1015416,1015501,1015502,1015503,1015504,1015505,1015506,1015507,1015508,1015509,1015510,1015511,1015512,1015513,1015514,1015515,1015516,1015601,1015602,1015603,1015604,1015605,1015606,1015607,1015608,1015609,1015610,1015611,1015612,1015613,1015614,1015615,1015616,1015701,1015702,1015703,1015704,1015705,1015706,1015707,1015708,1015709,1015710,1015711,1015712,1015713,1015714,1015715,1015716,1015801,1015802,1015803,1015804,1015805,1015806,1015807,1015808,1015809,1015810,1015811,1015812,1015813,1015814,1015815,1015816,1015901,1015902,1015903,1015904,1015905,1015906,1015907,1015908,1015909,1015910,1015911,1015912,1015913,1015914,1015915,1015916,1016001,1016002,1016003,1016004,1016005,1016006,1016007,1016008,1016009,1016010,1016011,1016012,1016013,1016014,1016015,1016016,1016101,1016102,1016103,1016104,1016105,1016106,1016107,1016108,1016109,1016110,1016111,1016112,1016113,1016114,1016115,1016116,1016201,1016202,1016203,1016204,1016205,1016206,1016207,1016208,1016209,1016210,1016211,1016212,1016213,1016214,1016215,1016216,1016301,1016302,1016303,1016304,1016305,1016306,1016307,1016308,1016309,1016310,1016311,1016312,1016313,1016314,1016315,1016316,1016401,1016402,1016403,1016404,1016405,1016406,1016407,1016408,1016409,1016410,1016411,1016412,1016413,1016414,1016415,1016416,1016501,1016502,1016503,1016504,1016505,1016506,1016507,1016508,1016509,1016510,1016511,1016512,1016513,1016514,1016515,1016516,1016601,1016602,1016603,1016604,1016605,1016606,1016607,1016608,1016609,1016610,1016611,1016612,1016613,1016614,1016615,1016616,1016701,1016702,1016703,1016704,1016705,1016706,1016707,1016708,1016709,1016710,1016711,1016712,1016713,1016714,1016715,1016716]; 
                                foreach($guanka as $gk){

                                    $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/dungeons/pass?dungeonId=$gk";
                                    $ch = curl_init($url);
                                    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                    $content = curl_exec($ch);
                                }
                                curl_close($ch);


                                mysqli_close($con);
                                notiG100K(0, "Thành Công!", "success");
                            } else {
                                mysqli_close($con);
                                notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                            }
                        } else {
                            notiG100K(0, "Chưa Mua Tools !", "info");
                        }
                        break;
                    case 'manvip':
                        $uid = trim(poststr('uid'));
                        $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                        mysqli_query("set names 'utf8'");
                        mysqli_select_db($dbname, $con);
                        $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        if ($row['sid'] != '') {
                            $login_url = $manageurl . "admin/login/";
                            $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                            $ch = curl_init($login_url); //初始化
                            curl_setopt($ch, CURLOPT_HEADER, 1);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                            $content = curl_exec($ch);
                            preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                            $cookie = $str[1];
                            $role_id = $row['sid'];
                            $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/add?type=vip&count=20&sid=/" . $role_id . "/";
                            $attachments = $chargetype . '^' . $chargenum;
                            $date = date("Y-m-d H:i:s", time());
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                            $content = curl_exec($ch);
                            curl_close($ch);
                            mysqli_close($con);
                            notiG100K(0, "Thành Công!", "success");
                        } else {
                            mysqli_close($con);
                            notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                        }
                        break;
                    case 'yijianchenghao':
                        if ($activate == 1) {
                            $uid = trim(poststr('uid'));
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                            $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_array($result);
                            if ($row['sid'] != '') {
                                $login_url = $manageurl . "admin/login/";
                                $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                                $ch = curl_init($login_url); //初始化
                                curl_setopt($ch, CURLOPT_HEADER, 1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                $content = curl_exec($ch);
                                preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                                $cookie = $str[1];
                                $role_id = $row['sid'];
                                $attachments = $chargetype . '^' . $chargenum;
                                $date = date("Y-m-d H:i:s", time());
                                for ($i=13100000;$i<=13100212;$i++){
                                    $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/item/adds?items=" . $i . "%5E1";
                                    $ch = curl_init($url);
                                    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                    $content = curl_exec($ch);
                                }
                                curl_close($ch);
                                mysqli_close($con);
                                notiG100K(0, "Thành Công!", "success");
                            } else {
                                mysqli_close($con);
                                notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                            }
                        } else {
                            notiG100K(0, "Chưa Mua Tools !", "info");
                        }
                        break;
                    case 'yijianpff':
                        if ($activate == 1) {
                            $uid = trim(poststr('uid'));
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                            mysqli_query("set names 'utf8'");
                            mysqli_select_db($dbname, $con);
                            $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_array($result);
                            if ($row['sid'] != '') {
                                $login_url = $manageurl . "admin/login/";
                                $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                                $ch = curl_init($login_url); //初始化
                                curl_setopt($ch, CURLOPT_HEADER, 1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                $content = curl_exec($ch);
                                preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                                $cookie = $str[1];
                                $role_id = $row['sid'];
                                $attachments = $chargetype . '^' . $chargenum;
                                $date = date("Y-m-d H:i:s", time());
                                for ($i=16100001;$i<=16100098;$i++){
                                    $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/item/adds?items=" . $i . "%5E1";
                                    $ch = curl_init($url);
                                    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                                    $content = curl_exec($ch);
                                }
                                curl_close($ch);
                                mysqli_close($con);
                                exit('一键添加全魂师皮肤成功，请重新登录');
                            } else {
                                mysqli_close($con);
                                notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                            }
                        } else {
                            notiG100K(0, "Chưa Mua Tools !", "info");
                        }
                        break;
                    case 'clearrolemail':
                        $uid = trim(poststr('uid'));
                        $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                        mysqli_query("set names 'utf8'");
                        mysqli_select_db($dbname, $con);
                        $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        if ($row['sid'] != '') {
                            $login_url = $manageurl . "admin/login/";
                            $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                            $ch = curl_init($login_url); //初始化
                            curl_setopt($ch, CURLOPT_HEADER, 1);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                            $content = curl_exec($ch);
                            preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                            $cookie = $str[1];
                            $role_id = $row['sid'];
                            $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/mail_clean";
                            $attachments = $chargetype . '^' . $chargenum;
                            $date = date("Y-m-d H:i:s", time());
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                            $content = curl_exec($ch);
                            curl_close($ch);
                            mysqli_close($con);
                            notiG100K(0, "Thành Công!", "success");
                        } else {
                            mysqli_close($con);
                            notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                        }
                        break;
                    case 'clearresource':
                        $uid = trim(poststr('uid'));
                        $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                        mysqli_query("set names 'utf8'");
                        mysqli_select_db($dbname, $con);
                        $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        if ($row['sid'] != '') {
                            $login_url = $manageurl . "admin/login/";
                            $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                            $ch = curl_init($login_url); //初始化
                            curl_setopt($ch, CURLOPT_HEADER, 1);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                            $content = curl_exec($ch);
                            preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                            $cookie = $str[1];
                            $role_id = $row['sid'];
                            $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/resource_clean";
                            $attachments = $chargetype . '^' . $chargenum;
                            $date = date("Y-m-d H:i:s", time());
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                            $content = curl_exec($ch);
                            curl_close($ch);
                            mysqli_close($con);
                            notiG100K(0, "Thành Công!", "success");
                        } else {
                            mysqli_close($con);
                            notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                        }
                        break;
                    case 'yijian':
                        $uid = trim(poststr('uid'));
                        $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                        mysqli_query("set names 'utf8'");
                        mysqli_select_db($dbname, $con);
                        $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        if ($row['sid'] != '') {
                            $login_url = $manageurl . "admin/login/";
                            $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                            $ch = curl_init($login_url); //初始化
                            curl_setopt($ch, CURLOPT_HEADER, 1);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                            $content = curl_exec($ch);
                            preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                            $cookie = $str[1];
                            $role_id = $row['sid'];
                            $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/add?type=level&count=120&sid=/" . $role_id . "/";
                            $attachments = $chargetype . '^' . $chargenum;
                            $date = date("Y-m-d H:i:s", time());
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                            $content = curl_exec($ch);
                            curl_close($ch);
                            mysqli_close($con);
                            notiG100K(0, "Thành Công!", "success");
                        } else {
                            mysqli_close($con);
                            notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                        }
                        break;
                    case 'clearstone':
                        $uid = trim(poststr('uid'));
                        $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                        mysqli_query("set names 'utf8'");
                        mysqli_select_db($dbname, $con);
                        $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        if ($row['sid'] != '') {
                            $login_url = $manageurl . "admin/login/";
                            $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                            $ch = curl_init($login_url); //初始化
                            curl_setopt($ch, CURLOPT_HEADER, 1);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                            $content = curl_exec($ch);
                            preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                            $cookie = $str[1];
                            $role_id = $row['sid'];
                            $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/gem_stone_clean";
                            $attachments = $chargetype . '^' . $chargenum;
                            $date = date("Y-m-d H:i:s", time());
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                            $content = curl_exec($ch);
                            curl_close($ch);
                            mysqli_close($con);
                            notiG100K(0, "Thành Công!", "success");
                        } else {
                            mysqli_close($con);
                            notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                        }
                        break;
                    case 'clearherb':
                        $uid = trim(poststr('uid'));
                        $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Đã Đóng !!", "error");
                        mysqli_query("set names 'utf8'");
                        mysqli_select_db($dbname, $con);
                        $sql = "SELECT * FROM `$dbname`.`users` WHERE `account`='$uid' LIMIT 1";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        if ($row['sid'] != '') {
                            $login_url = $manageurl . "admin/login/";
                            $post_fields = array("username" => $qu['manageuser'], "password" => $qu['managepwd'],);
                            $ch = curl_init($login_url); //初始化
                            curl_setopt($ch, CURLOPT_HEADER, 1);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                            $content = curl_exec($ch);
                            preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                            $cookie = $str[1];
                            $role_id = $row['sid'];
                            $url = $manageurl . "admin/console/dldl_develop/users/edit/" . $role_id . "/" . $servers . "/magic_herb_clean";
                            $attachments = $chargetype . '^' . $chargenum;
                            $date = date("Y-m-d H:i:s", time());
                            $ch = curl_init($url);
                            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            //curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                            $content = curl_exec($ch);
                            curl_close($ch);
                            mysqli_close($con);
                            notiG100K(0, "Thành Công!", "success");
                        } else {
                            mysqli_close($con);
                            notiG100K(0, "Tài Khoản ".$uid." Chưa Tạo Nhân Vật !", "error");
                        }
                    default:
                        otiG100K(0, "Chức Năng Đang Cập Nhật!", "error");
                        break;
                }
            } else {
                notiG100K(0, "Loại yêu cầu không tồn tại!", "error");
            }
        } else {
            notiG100K(0, "Chưa Nhập Tài Khoản Game !", "error");
        }
    } else {
        notiG100K(0, "Chưa Chọn Server !", "error");
    }
} else {
    notiG100K(0, "Yêu cầu bất hợp pháp! Vui lòng tự trọng.", "error");
}
