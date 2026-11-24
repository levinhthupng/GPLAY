<?php
include 'config.php';
if ($_POST) {
    $checknum = "g100k";
    $quid = trim(poststr('qu'));
    $qu = $quarr [$quid];
    $uid = trim(poststr('uid'));
    $dbname = $qu ['db_name'];
    $dbname1 = $qu ['db_name1'];
    $prefix = $qu ['prefix'];
    $prebs = $qu ['prebs'];
    $url = $qu ['url'];
    $time = time();
    if ($checknum == $gmcode) {
        if ($quid >= 1) {
            if ($uid != '') {
                $sql = "SELECT * FROM $dbname.ny_role WHERE name='{$prefix}{$uid}'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                $activate = $row ['activate'];
                if ($row ['role_id'] != '') {
                    $roleid = $row ['role_id'];
                    $account = $row ['account'];
                    $username = str_replace("local_", "", $account);
                    $package = $row ['package'];
                    if ($_POST ['type']) {
                        $type = trim($_POST ['type']);
                        switch ($type) {

                            case 'AddXu' :
                                if ($activate == 1) {
                                    $coin = trim(poststr('coin'));
                                    if ($coin == '') {
                                        notiG100K(0, "Chưa Nhập Số Xu Muốn Cộng", "error");
                                    } else {
                                        $sql = "UPDATE  $dbname1.yzf_account SET `ptb` = `ptb` + '$coin.00'  WHERE   username='{$username}' ;";
                                        if (mysqli_query($conn, $sql)) {
                                            notiG100K(0, "Cộng Xu Thành Công", "success");
                                        } else {
                                            notiG100K(0, "Cộng Xu Thất Bại1", "error");
                                        }
                                        mysqli_close($conn);
                                    }
                                } else {
                                    notiG100K(0, "Chưa Mua Tools ! Vui Lòng Truy Cập G100K.NET Để Mua!", "error");
                                }
                                break;


                            case 'ClearItem' :
                                $redis = new Redis();
                                if ($redis->connect('159.65.6.249', 6379)) {
                                    $redis->select(1);//
                                    $TableName = "BagInfo";
                                    //  //进入1号分片
                                    //$uid = $roleid;
                                    $data = NULL;
                                    $result = $redis->hSet($TableName, strval($roleid), $data);

                                    if ($result === 1) {
                                        echo "Thêm mới thành công.";
                                    } elseif ($result === 0) {
                                        $sql = "delete from $dbname.ny_consume_produce where role_id={$roleid} and type=1;";
                                        mysqli_query($conn, $sql);
                                        if (mysqli_query($conn, $sql)) {
                                            notiG100K(0, "Xóa đạo cụ thành công: online sau 5 phút", "success");
                                        } else {
                                            notiG100K(0, "Không Thể Xóa ! Thử Lại Sau", "warning");
                                        }
                                    } else {
                                        notiG100K(0, "Không Thể Xóa ! Thử Lại Sau", "warning");
                                    }

                                } else {
                                    notiG100K(0, "Kết Nối Thất Bại!", "error");
                                }
                                break;
                            case 'charge' :
                                $goodsid = trim($_POST ['chargenum']);
                                if ($goodsid == '') {
                                    notiG100K(0, "Chưa Chọn Gói Nạp", "warning");
                                }
                                $payinfo = getmoney();
                                $payid = $payinfo[$goodsid][0];
                                $rmb = $payinfo[$goodsid][1];
                                $num = $payinfo[$goodsid][2];
                                $orderNo = time() . mt_rand(100, 999);
                                $sql = "INSERT INTO $dbname1.`ny_gift_order` (`group`, `server`, `package`, `order_num`, `corder_num`, `account`, `role_id`, `role_name`, `role_level`, `index`, `money`, `reward_item_id`, `index_name`, `first`, `create_time`, `send_time`, `admin`, `checked`) VALUES ('1', '{$prebs}', '{$package}', '{$orderNo}', '{$orderNo}', '{$account}', '{$roleid}', '{$uid}', '0', '{$payid}', '{$rmb}', null, '{$num}', '1', '{$time}', '{$time}', '1', '0');";
                                mysqli_query($conn, $sql);
                                $id = mysqli_insert_id($conn);
                                $login_url = $url . "/center/admin.php?ctrl=index&act=login";
                                $post_fields = array("username" => $qu['username'], "password" => $qu['password'], "login_token" => $qu['login_token']);
                                $ch = curl_init($login_url); //初始化
                                curl_setopt($ch, CURLOPT_HEADER, 1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                $content = curl_exec($ch);
                                preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                                $cookie = $str[1];
                                $gifturl = $url . "/center/admin.php?ctrl=giftOrder&act=check&id={$id}";

                                $ch = curl_init($gifturl);
                                curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                                curl_setopt($ch, CURLOPT_HEADER, 0);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                $result = curl_exec($ch);
                                curl_close($ch);
                                mysqli_close($con);
                                if ($result == 0) {
                                    notiG100K(0, "Gửi Thành Công", "success");
                                } else {
                                    notiG100K(0, "Gửi Thất Bại", "error");
                                }
                                /*
                                * 邮件
                                */
                                break;
                            case 'daoju' :
                                $item = $_POST ['mailid'];
                                $itemnum = $_POST ['mailnum'];
                                if ($item != "") {
                                    if ($itemnum != "") {
                                    } else {
                                        notiG100K(0, "Chưa Chọn Vật Phẩm", "warning");
                                    }
                                } else {
                                    notiG100K(0, "Chưa Chọn Vật Phẩm", "warning");
                                }
                                if ($activate == 1) {
                                    $items = "{\"source\":{\"1\":[$item,$itemnum]},\"item\":[]}";
                                    $sql = "INSERT INTO $dbname1.`ny_mail` (`groups`, `admin`, `role_id`, `role_name`, `servers`, `sender`, `agreer`, `title`, `content`, `attach`, `send_type`, `book_time`, `status`, `is_send`, `create_time`, `send_time`, `msg`) VALUES ('1', 'GM', '{$roleid}', '{$account}', '{$prebs}', 'HT', NULL, 'G100K - TOOLS VIP', 'G100K - TOOLS VIP', '{$items}', '0', '0', '1', '0', '{$time}', NULL, '');";
                                    mysqli_query($conn, $sql);
                                    $id = mysqli_insert_id($conn);
                                    $login_url = $url . "/center/admin.php?ctrl=index&act=login";
                                    $post_fields = array("username" => $qu['username'], "password" => $qu['password'], "login_token" => $qu['login_token']);
                                    $ch = curl_init($login_url); //初始化
                                    curl_setopt($ch, CURLOPT_HEADER, 1);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
                                    $content = curl_exec($ch);
                                    preg_match('/Set-Cookie:(.*);/iU', $content, $str);
                                    $cookie = $str[1];
                                    $gifturl = $url . "/center/admin.php?ctrl=mail&act=send&id={$id}";

                                    $ch = curl_init($gifturl);
                                    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
                                    curl_setopt($ch, CURLOPT_HEADER, 0);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                    $result = curl_exec($ch);
                                    curl_close($ch);
                                    mysqli_close($con);
                                    if ($result == 0) {
                                        notiG100K(0, "Gửi Vật Phẩm Thành Công", "success");
                                    } else {
                                        notiG100K(0, "Gửi Vật Phẩm Thất Bại !", "error");
                                    }
                                } else {
                                    notiG100K(0, "Chưa Mua Tools ! Vui Lòng Truy Cập G100K.NET Để Mua!", "error");
                                }
                                break;
                            default :
                                notiG100K(0, "Chức Năng Không Tồn Tại !!!", "error");
                                break;
                        }
                    } else {
                        notiG100K(0, "Loại được yêu cầu không tồn tại!", "error");
                    }
                } else {
                    notiG100K(0, "Nhân vật không tồn tại!", "error");
                }
            } else {
                notiG100K(0, "Sai ID!", "error");
            }
        } else {
            notiG100K(0, "Lỗi máy chủ!", "error");
        }
    } else {
        notiG100K(0, "Sai mã GM!", "error");
    }
} else {
    notiG100K(0, "Bug Con Cặc !", "error");
}