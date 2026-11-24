<?php
include 'config.php';
if ($_POST) {
    $quid = trim(poststr('qu'));
    $qu = $quarr[$quid];
    $uid = trim(poststr('uid'));
    $dbip = $qu['host'];
    $dbname = $qu['dbname'];
    $dbuser = $qu['user'];
    $dbpwd = $qu['pwd'];
    $quname = $qu['name'];
    $signkey = $qu['key'];
    $url = $qu['url'];

    if ($quid >= 1 || $quid != '') {
        if ($uid != '') {
            if ($_POST['type']) {
                $type = trim($_POST['type']);
                switch ($type) {
                    case 'charge' :
                            $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Sập", "error");
                                mysqli_select_db($con, $dbname);
                                $sql = "SELECT * FROM `tb_player` where  `playerName` = '$uid' limit 1";
                                $result = mysqli_query($con, $sql);
                                $row = mysqli_fetch_array($result);
                                $playerId = $row['playerId'];
                                $userId = $row['userId'];
                                mysqli_close($con);
                                if ($playerId == '') {
                                    notiG100K(0, "〖" . $quname . "〗Không có nhân vật này.", "error");
                                }
                            $chargetype = trim(poststr('chargenum'));
                            switch($chargetype){
                    			case 2:
                    				$gold  = 2000000;
                    				$xu = 1;
                    				break;
                    			case 3:
                    				$gold  = 5000000;
                    				$xu = 1;
                    				break;
                    			case 4:
                    				$gold  = 10000000;
                    				$xu = 1;
                    				break;
                    			case 5:
                    				$gold  = 20000000;
                    				$xu = 1;
                    				break;
                    			case 6:
                    				$gold  = 100000000;
                    				$xu = 1;
                    				break;
                    			case 7:
                    				$gold  = 200000000;
                    				$xu = 1;
                    				break;
                    			case 8:
                    				$gold  = 500000000;
                    				$xu = 1;
                    				break;
                    			case 9: //the thang
                    				$gold  = 25000000;
                    				$xu = 1;
                    				break;
                    			case 10: // the chi ton
                    				$gold  = 50000000;
                    				$xu = 1;
                    				break;
                    			case 11:
                    				$gold  = 2000000;
                    				$xu = 1;
                    				break;
                    				
                    			case 12:
                    				$gold  = 5000000;
                    				$xu = 1;
                    				break;
                    			//gói nạp ngày - 3
                    			case 13:
                    				$gold = 10000000;
                    				$xu = 1;
                    				break;
                    			// thẻ tháng
                    			case 14:
                    				$gold = 5000000;
                    				$xu = 1;
                    				break;
                    				
                    			
                    		}
                    		$subject = $chargetype;
                    		$amount = $gold;
                			$charge_id = $chargetype;
                            $cmd = 5;
                            $orderNum = date('YmdHis') . md5(uniqid(microtime(true) . mt_rand()));
                            $time = time();
                            $sign = md5($playerId . $amount . $time . $subject . $signkey);
                            $postdata = array("cmd" => $cmd, "playerId" => $playerId, "num" => $amount, "orderNum" => $orderNum, "time" => $time, "sign" => $sign, "subject" => $subject);
                        	$result=get($url, $postdata);
                            if($result=='Thành công'){
                                notiG100K(0, "Nạp Free Thành Công", "success");
                            }
                            else{
                                notiG100K(0, "Nạp Free Thất Bại", "error");
                            }
                            
                        break;
                    case 'daoju':
                        $con = @mysqli_connect($dbip, $dbuser, $dbpwd) or notiG100K(0, "Server Sập", "error");
                        
                        //mysqli_query("SET NAMES utf8");
                        mysqli_select_db($con, $dbname);
                        $sql = "SELECT * FROM `tb_player` where  `playerName` = '$uid' limit 1";
                        $result = mysqli_query($con, $sql);
                        $row = mysqli_fetch_array($result);
                        $playerId = $row['playerId'];
                        $userId = $row['userId'];
                        $activate = $row['stars'];
                        mysqli_close($con);
                        if ($playerId == '') {
                            notiG100K(0, "〖" . $quname . "〗Không có nhân vật này.", "error");
                        }
                        $title = "G100K - TOOLS VIP";
                        $content = "G100K - TOOLS VIP";
                        $mailid = trim(poststr('mailid'));
                        if ($mailid == '') {
                            notiG100K(0, "Vật Phẩm Không Tồn tại", "error");
                        }
                        $find = false;
                        $file = fopen("item.txt", "r");
                        while (!feof($file)) {
                            $line = fgets($file);
                            $txts = explode(';', $line);
                            if ($txts[0] == $mailid) {
                                $find = true;
                                $itemtype = trim($txts[2]);
                                $itemname = trim($txts[1]);
                                break;
                            }
                        }
                        fclose($file);
                        if ($find == false) {
                            notiG100K(0, "Vật Phẩm Không Tồn tại", "error");
                        }
                        $mailnum = trim(poststr('mailnum'));
                        if ($mailnum == '' || $mailnum < 0 || $mailnum > 2000000000) {
                            notiG100K(0, "Số Lượng Từ 0-2000000000", "error");
                        }
                        if ($activate == 1) {
                        $cmd = 3;
                        $time = time();
                        $postdata = array("cmd" => $cmd, "mails" => json_encode(array(array("type" => 1, "sendId" => 0, "sendName" => "G100K - TOOLS VIP", "title" => $title, "context" => $content, "rewards" => array(array("type" => $itemtype, "id" => $mailid, "num" => $mailnum)), "rules" => array("4" => (string)$playerId))), 320));
                        $result = get1($url, $postdata);
                        if ($result == '10001') {
                            notiG100K(0, "Gửi Vật Phẩm Thành Công", "success");
                            
                        } else {
                            notiG100K(0, "Gửi Vật Phẩm Thất Bại", "error");
                        }
                        } else {
                            notiG100K(0, "Chưa Mua Tools", "error");
                        }
                    break;

                    default:
                        notiG100K(0, "Hệ thống là bất thường, xin vui lòng thử lại", "error");
                    break;
                }
            } else {
                notiG100K(0, "Loại yêu cầu không tồn tại", "error");
            }
        } else {
           notiG100K(0, "Tên vai trò không chính xác", "error");
        }
    } else {
        notiG100K(0, "Máy chủ không chính xác", "error");
    }
} else {
    notiG100K(0, "Yêu Cầu Không Tồn Tại", "error");
}
