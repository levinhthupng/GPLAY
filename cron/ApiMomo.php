<?php
require_once "../config.php";
require_once "../api/APIMM.php";
$ckusr = $ketnoi->query("SELECT * FROM `api`");
$check = mysqli_num_rows($ckusr);
$rs = mysqli_fetch_array($ckusr);
$token = $rs['token'];
$phone = $rs['phone'];
$code1 = random('qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM', 12);
$codediscount = 'G100K'.random('qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM', 12);
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://m.mservice.io/hydra/v2/user/noti',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>
  json_encode([
    "userId" => $phone,
    "fromTime" => (time()-36000)*1000,
    "toTime" => time()*1000,
    "limit" => 100,
    "cursor" => ""
  ]),
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer '.$token,
    'Content-Type: application/json'
  ),
));


$response = curl_exec($curl);
curl_close($curl);
$response = json_decode($response);
$arr =[];
if(isset($response)) {
    foreach($response->message->data->notifications as $key => $data )
    {
      if($data->refId == 'receive_money_p2p'){
        $extra = json_decode($data->extra);
        $partnerName = $extra->partnerName;
        $tranId = $extra->tranId;
        $partnerId = $extra->partnerId;
        $amount = $extra->amount;
        $comment = $extra->comment;
        $finishTime = $data->time;
        $hinhthuc = "Momo";
        $finishTime = date('d-m-Y H:i:s', $finishTime /1000);
        $mili = strtotime($finishTime);
        $id = parse_order_id($comment);
        echo($comment);
        exit();
        if ($id)
            {
                $check_code = $ketnoi->query("SELECT * FROM `momo` WHERE `tranId` = '$tranId' ");
                $check_username = $ketnoi->query("SELECT * FROM `users` WHERE `username` = '$id' ");
                if($check_username)
                    {
                        $array_user = $check_username->fetch_array();
                        if($check_code->fetch_assoc() == 0)
                        {
                            $money = str_replace('.', '', $amount);
                            $create = $ketnoi->query("INSERT INTO `momo` SET 
                                `request_id` = '".$code1."',
                                `tranId` = '$tranId',
                                `username` = '$id',
                                `comment` = '$comment',
                                `time` = '$finishTime',
                                `mili` = '$mili',
                                `partnerId` = '$partnerId',
                                `amount` = '$amount',
                                `partnerName` = '$partnerName'");
                                
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
                                    `content`= '+ ".format_cash($money)."  lý do: Nạp MOMO Auto  #".$tranId." ',
                                    `createdate` = now(),
                                    `username`= '$id' ");
                                    if($site_km == 'ON') {
                                        $money = $money + ($money * 0.5);
                                    }  
                                    $ketnoi->query("UPDATE users SET 
                                    `money` = `money` + '".$money."',
                                    `total_nap` = `total_nap` + '".$money."' WHERE `username` = '$id' ");
                                }
                            require('../api/tele.php');
                        }
                    }
                }
      }
    }
} else {
    require_once('./tokenMM.php');
}

?>