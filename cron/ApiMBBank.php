<?php
require_once('../config.php');
$userID = "0886069484";
$data = json_decode(file_get_contents('php://input'));
    if(!is_object($data)) {
        echo json_encode(['success'=>FALSE, 'message' => 'No data']);
        die();
    }else {

    // Khoi tao cac bien
    $gateway = $data->gateway;
    $transaction_date = $data->transactionDate;
    $account_number = $data->accountNumber;
    $sub_account = $data->subAccount;

    $transfer_type = $data->transferType;
    $transfer_amount = $data->transferAmount;
    $accumulated = $data->accumulated;

    $code = $data->code;
    $transaction_content = $data->content;
    $reference_number = $data->referenceCode;
    $body = $data->description;

    $amount_in = 0;
    $amount_out = 0;
    $gateway;
    // Kiem tra giao dich tien vao hay tien ra
if($transfer_type == "in") {
    $amount_in = $transfer_amount;
}
else if($transfer_type == "out") {
        $amount_out = $transfer_amount;
}
        $tranId = $data->referenceCode;
        $amount = $amount_in;
        $comment = $data->code;
        $finishTime = $transaction_date;
        $hinhthuc = "ATM";
        $mili = strtotime($finishTime);
        $rq_id = $ketnoi->query("SELECT * FROM `bank_auto` WHERE `status` = 'xuly' AND `request_id` = '$comment'");
        $rq_id1 = mysqli_fetch_array($rq_id);
        $request_id =$rq_id1['request_id'];
        $username =$rq_id1['username'];
        //echo json_encode(['success'=>TRUE, 'comment' => $comment , 'tranId' => $tranId, 'amount' => $amount]);
        
        $pos = strpos(strtoupper($comment), strtoupper($request_id));
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
                $money = $amount;
                            $create =  $ketnoi->query("UPDATE `bank_auto` SET 
                                `tranId` = '$tranId',
                                `comment` = '$transaction_content',
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
                                    
                                    $ketnoi->query("INSERT INTO `log` SET 
                                    `content`= '+ ".format_cash($money)."  lý do: Nạp ATM Auto  #".$tranId." ',
                                    `createdate` = now(),
                                    `username`= '$username' ");
                                    if($site_km == 'ON') {
                                        $money = $money * 2;
                                    }  
                                    $ketnoi->query("UPDATE users SET 
                                    `money` = `money` + '".$money."',
                                    `total_nap` = `total_nap` + '".$money."' WHERE `username` = '$username' ");
                                    //require('../api/tele_atm.php');
                                    send_noti ($money,$tranId,$username);
                                    echo json_encode(['success'=>TRUE, 'comment' => $comment , 'tranId' => $tranId, 'amount' => $amount]);
                                }    
                    
               
            } else {
                echo json_encode(['success'=>TRUE, 'comment' => $comment , 'tranId' => $tranId, 'amount' => $amount, 'content' => "Da Cong Hoac Khong Ton tai Ma GD"]);
            }
         $id = "";
    
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

function send_noti ($totalAmount,$transId,$username) {
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
  $pusher->trigger('G100K', 'RechargeBank'.$username, $data);
}