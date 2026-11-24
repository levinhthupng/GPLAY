<?php
require_once('../config.php');
//require_once('../api/token-tpbank.php');
$username = "0345309149"; 
//$password = "12082001Lvt";
//$token1 = get_token($username, $password);
//$token = json_decode($token);
//$token = $kq->access_token;
//  $create = mysqli_query($ketnoi,"UPDATE `bank` SET 
//    `username` = '$username',
//    `password` = '$password',
//    `token` = '$token' WHERE `username` = '$username'" );
$ngay_bat_dau_check = '20220318';
$ngay_ket_thuc_check = date("Ymd");
$ckusr = $ketnoi->query("SELECT * FROM `bank` WHERE `username` = '$username'");
$check = mysqli_num_rows($ckusr);
$rs = mysqli_fetch_array($ckusr);
$kq = get_history($rs['token'], $rs['stk']);
$kq = json_decode($kq);
$tratoken =  json_encode($kq);
$codediscount = 'G100K'.random('qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM', 12);
$list_transaction = $kq->transactionInfos;
if(isset($list_transaction)) {
    foreach ($list_transaction as $transaction)
    {
        $tranId = $transaction->id;
        $amount = $transaction->amount;
        $comment = $transaction->description;
        $moneybalan = $transaction->runningBalance;
        $ketnoi->query("UPDATE `bank` SET `money` = '$moneybalan' WHERE `username` = '$username'");
        $finishTime = date('d-m-Y H:i:s');
        $hinhthuc = "ATM";
        //Kiểm Tra Nội Dung Và Lấy Usernamme
        if ($comment == trim($comment) && strpos($comment, '.') !== false) {
            $ktcmt = 1;
        } else if ($comment == trim($comment) && strpos($comment, ' ') !== false) {
        	$ktcmt = 2;
        }
        if($ktcmt == 2) {
          $datacm = explode(' ', $comment);
          for($i = 0; $i <= count($datacm); $i++) {
                  if(strtoupper($datacm[$i]) == "G100K") {
                      $id = $datacm[$i + 1];
                      break;
                  }      
          }
        } 
        else if($ktcmt == 1) { 
        	$sokytu = strlen($comment);
                if($sokytu > 100) {
                    $comment = explode(".",$comment);
                    $comment = $comment[3];
                } else {
                    $comment = $comment;
                }
            $id = parse_order_id($comment);  
        } else {
            $id = parse_order_id($comment);
        }
        echo $comment."</br>";
        if ($id)
            {
                $check_code = $ketnoi->query("SELECT * FROM `bank_auto` WHERE `tranId` = '$tranId' ");
                $check_username = $ketnoi->query("SELECT * FROM `users` WHERE `username` = '$id' ");
                if($check_username->fetch_assoc() != 0)
                    {
                        $array_user = $check_username->fetch_array();
                        if($check_code->fetch_assoc() == 0)
                        {
                            
                            $money = str_replace('.', '', $amount);
                            $create =  $ketnoi->query("INSERT INTO `bank_auto` SET 
                                `tranId` = '$tranId',
                                `username` = '$id',
                                `comment` = '$comment',
                                `time` = '$finishTime',
                                `amount` = '$amount'");
                            
                            if($site_discount == 'ON') {
                                if($amount >= $discount_value) {
                                    $check_discount = $ketnoi->query("SELECT * FROM `discount` WHERE `user` = '$id' AND `amount_event` = '$discount_value'");
                                    if($check_discount->fetch_assoc() == 0) {
                                        $check_level = $ketnoi->query("SELECT * FROM `users` WHERE `username` = '$id' ")->fetch_assoc()['level'];
                                        if ($check_level == 0) {
                                            $discount_ck = $discount_ck - 10;
                                            //echo $discount_ck;
                                        } else {
                                            $discount_ck = $discount_ck;
                                           // echo $discount_ck;
                                        }
                                        $adddiscount = $ketnoi->query("INSERT INTO `discount` SET 
                                        `code` = '".$codediscount."',
                                        `user` = '$id',
                                        `discount` = '$discount_ck',
                                        `amount_event` = '$discount_value',
                                        `createdate` = '$finishTime'");
                                        if ($adddiscount)
                                        {
                                            $ketnoi->query("INSERT INTO `log` SET 
                                            `content`= 'Bạn Nhận Được Mã Giảm Giá  ".$codediscount." ',
                                            `createdate` = now(),
                                            `username`= '$id' ");
                                        }
                                    }
                                }
                            } 
                                    
                            if ($create)
                                {
                                    $ketnoi->query("INSERT INTO `log` SET 
                                    `content`= '+ ".format_cash($money)."  lý do: Nạp ATM Auto  #".$tranId." ',
                                    `createdate` = now(),
                                    `username`= '$id' ");
                                    $ketnoi->query("UPDATE users SET 
                                    `money` = `money` + '".$money."',
                                    `total_nap` = `total_nap` + '".$money."' WHERE `username` = '$id' ");
                                    require('../api/tele.php');
                                }
                            
                        }
                    }
                    
               
            }
         $id = "";
    }
} else {
    require_once('../api/token-tpbank.php');
}

function get_history($token,$stk_tpbank){
$url = "https://ebank.tpb.vn/gateway/api/smart-search-presentation-service/v1/account-transactions/find";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Connection: keep-alive",
   "DEVICE_ID: LYjkjqGZ3HhGP5520GxPP2j94RDMC7Xje77MI7",
   "PLATFORM_VERSION: 100",
   "DEVICE_NAME: Chrome",
   "SOURCE_APP: HYDRO",
   "Authorization: Bearer ".$token,
   "XSRF-TOKEN=df4fec36-650c-4693-8f5d-4f565741b3bd",
   "Content-Type: application/json",
   "Accept: application/json, text/plain, */*",
   "sec-ch-ua-mobile: ?0",
   "User-Agent:	okhttp/3.12.1",
   "PLATFORM_NAME: WEB",
   "APP_VERSION: 1.3",
   "Origin: https://ebank.tpb.vn",
   "Sec-Fetch-Site: same-origin",
   "Sec-Fetch-Mode: cors",
   "Sec-Fetch-Dest: empty",
   "Referer: https://ebank.tpb.vn/retail/vX/main/inquiry/account/transaction?id=".$stk_tpbank,
   "Accept-Language: vi,en;q=0.9,vi-VN;q=0.8,fr-FR;q=0.7,fr;q=0.6,en-US;q=0.5",
   "Cookie: _ga=GA1.2.682624826.1650083552; _gid=GA1.2.342493977.1650083552; _gcl_au=1.1.1711985075.1650083552;NSC_JOvknwund5ryo3dc4qxfamdit155ccq=ffffffff09da124b45525d5f4f58455e445a4a4229aa; Authorization=".$token,
);
//echo json_encode($headers);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = '{"accountNo":"'.$stk_tpbank.'","currency":"VND","fromDate":"20220512","toDate":"'.date("Ymd").'","keyword":""}';
//echo $data;
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
return $resp;
}