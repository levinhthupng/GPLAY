<?php
require_once('../config.php');
$userID = "0886069484";
$rq_id = $ketnoi->query("SELECT * FROM `bank_auto` WHERE `status` = 'xuly' ORDER BY id desc LIMIT 1");
$rq_id1 = mysqli_fetch_array($rq_id);
$request_id =$rq_id1['request_id'];
$username =$rq_id1['username'];
$ckusr = $ketnoi->query("SELECT * FROM `bank` WHERE `username` = '$userID'");
$check = mysqli_num_rows($ckusr);
$rs = mysqli_fetch_array($ckusr);
$stk = $rs['stk'];
$sessionId = $rs['token'];
$kq = getHistory($sessionId,$stk);
$kq = json_decode($kq);
//var_dump ($kq);
$codediscount = 'G100K'.random('qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM', 12);
$list_transaction = $kq->transactionHistoryList;
if(isset($list_transaction)) {
    foreach ($list_transaction as $transaction)
    {
        $tranId = $transaction->refNo;
        $amount = $transaction->creditAmount;
        $comment = $transaction->description;
        $moneybalan = $transaction->availableBalance;
        $ketnoi->query("UPDATE `bank` SET `money` = '$moneybalan' WHERE `username` = '$userID'");
        $finishTime = date('d-m-Y H:i:s');
        $hinhthuc = "ATM";
        $mili = strtotime($finishTime);
        $check_code = $ketnoi->query("SELECT * FROM `bank_auto` WHERE `request_id` = '$request_id' AND `status` = 'xuly'");
        $check = $check_code->fetch_assoc();
        $check_requestid = $check['request_id'];
        $pos = strpos($comment, $check_requestid);
        //echo $check_requestid."</br>";
        echo $comment."</br>";
        //Kiểm Tra Nội Dung Và Lấy Usernamme
        /*$comment = preg_replace('/[.;]/i', ' ', $comment);
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
        echo $comment."</br>";*/
        if($pos !== false)
            {
                $money = str_replace('.', '', $amount);
                            $create =  $ketnoi->query("UPDATE `bank_auto` SET 
                                `tranId` = '$tranId',
                                `comment` = '$comment',
                                `time` = '$finishTime',
                                `mili` = '$mili',
                                `status` = 'hoantat',
                                `amount` = '$amount' WHERE `request_id` = '$request_id'" );
                            
                            if($site_discount == 'ON') {
                                if($amount >= $discount_value) {
                                    $check_discount = $ketnoi->query("SELECT * FROM `discount` WHERE `user` = '$username' AND `amount_event` = '$discount_value'");
                                    if($check_discount->fetch_assoc() == 0) {
                                        $check_level = $ketnoi->query("SELECT * FROM `users` WHERE `username` = '$username' ")->fetch_assoc()['level'];
                                        if ($check_level == 0) {
                                            $discount_ck = $discount_ck - 10;
                                            //echo $discount_ck;
                                        } else {
                                            $discount_ck = $discount_ck;
                                           // echo $discount_ck;
                                        }
                                        $adddiscount = $ketnoi->query("INSERT INTO `discount` SET 
                                        `code` = '".$codediscount."',
                                        `user` = '$check_user',
                                        `discount` = '$discount_ck',
                                        `amount_event` = '$discount_value',
                                        `createdate` = '$finishTime'");
                                        if ($adddiscount)
                                        {
                                            $ketnoi->query("INSERT INTO `log` SET 
                                            `content`= 'Bạn Nhận Được Mã Giảm Giá  ".$codediscount." ',
                                            `createdate` = now(),
                                            `username`= '$username' ");
                                        }
                                    }
                                }
                            } 
                                    
                            if ($create)
                                {
                                    send_noti ($money,$tranId);
                                    $ketnoi->query("INSERT INTO `log` SET 
                                    `content`= '+ ".format_cash($money)."  lý do: Nạp ATM Auto  #".$tranId." ',
                                    `createdate` = now(),
                                    `username`= '$username' ");
                                    if($site_km == 'ON') {
                                        $money = $money + ($money * 0.5);
                                    }  
                                    $ketnoi->query("UPDATE users SET 
                                    `money` = `money` + '".$money."',
                                    `total_nap` = `total_nap` + '".$money."' WHERE `username` = '$username' ");
                                    require('../api/tele_atm.php');
                                }    
                    
               
            }
         $id = "";
    }
} else {
    require_once('../api/sessionId-mbbank.php');
}

function getHistory($sessionId,$userID) {
    $url = "https://online.mbbank.com.vn/api/retail-transactionms/transactionms/get-account-transaction-history";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:121.0) Gecko/20100101 Firefox/121.0",
   "Authorization: Basic RU1CUkVUQUlMV0VCOlNEMjM0ZGZnMzQlI0BGR0AzNHNmc2RmNDU4NDNm",
   "Content-Type: application/json",
   "RefNo: 0886069484-2024011222490037",
   "Deviceid: raffy090-mbib-0000-0000-2024011222255269",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
$thangHienTai = date('m');
$data = '{
            	"accountNo": "'.$userID.'",
            	"fromDate": "01/'.$thangHienTai.'/2024",
            	"toDate": "'.date("d/m/Y").'",
            	"sessionId": "'.$sessionId.'",
            	"refNo": "0886069484-2024011222490037",
            	"deviceIdCommon": "raffy090-mbib-0000-0000-2024011222255269"
        }';

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
return $resp;
}

function send_noti ($totalAmount,$transId) {
  require_once("../vendors/autoload.php");

  $options = array(
    'cluster' => 'ap1',
    'useTLS' => true
  );
  $pusher = new Pusher\Pusher(
    '95889a064938e39c8363',
    '9cc560576642babf5ad6',
    '1501887',
    $options
  );

  $data['message'] = '+ '.format_cash($totalAmount).' lý do: Nạp ATM Auto  #'.$transId.' ';
  $data['type'] = 'success';
  $data['url'] = '/profile/';
  $pusher->trigger('G100K', 'RechargeBank', $data);
}