<?php
require_once "../config.php";
$rq_id = $ketnoi->query("SELECT * FROM `momo` WHERE `status` = 'xuly' ORDER BY id desc LIMIT 1");
$rq_id1 = mysqli_fetch_array($rq_id);
$request_id =$rq_id1['request_id'];
$username =$rq_id1['username'];

$ch = curl_init('https://api.sieuthicode.net/historyapimomo/447e9168-26c6-43b0-978b-518679d8e806');
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                        $response = curl_exec($ch);
                                        curl_close($ch);

//momo
/*$curl = curl_init();
$dataPost = array(
    "type" => "history",
    "token" =>"447e9168-26c6-43b0-978b-518679d8e806",
);
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https:/api.g100k.net/api/historymomo',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$dataPost,
));

$response = curl_exec($curl);

curl_close($curl);*/
//print_r($response);
//end
$data = json_decode($response);
print_r($response);
// Lấy mảng tranList
$tranList = $data->momoMsg;

if(isset($tranList)) {
    foreach($tranList->tranList as $key => $extra )
    {
      if($extra->io == '1'){
        $sourceName = $extra->partnerName;
        $transId = $extra->tranId;
        $sourceId = $extra->partnerId;
        $totalAmount = $extra->amount;
        $finishTime = date('d-m-Y H:i:s');
        $mili = strtotime($finishTime);
        $comment = $extra->comment;
        var_dump($comment);
        $check_code = $ketnoi->query("SELECT * FROM `momo` WHERE `request_id` = '$request_id' AND `status` = 'xuly'");
        $check = $check_code->fetch_assoc();
        $check_requestid = $check['request_id'];
        $pos = strpos($comment,$check_requestid);
        $hinhthuc = "Momo";
        if($pos !== false)
            {
                $create = $ketnoi->query("UPDATE `momo` SET 
                                                    `tranId` = '$transId',
                                                    `time` = '$finishTime',
                                                    `mili` = '$mili',
                                                    `amount` = '$totalAmount',
                                                    `partnerId` = '$sourceId',
                                                    `comment` = '$comment',
                                                    `status` = 'hoantat',
                                                    `partnerName` = '$sourceName'
                                        WHERE `request_id` = '$check_requestid'");
                            if($site_discount == 'ON') {
                                if($totalAmount >= $discount_value) {
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
                                        `user` = '$username',
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
                                    //echo $totalAmount;
                                    
                                    $check = $ketnoi->query("INSERT INTO `log` SET 
                                    `content`= '+ ".format_cash($totalAmount)."  lý do: Nạp MOMO Auto  #".$transId." ',
                                    `createdate` = now(),
                                    `username`= '$username' ");
                                    if ($check) {
                                        echo "OK";
                                    }
                                    if($site_km == 'ON') {
                                        $totalAmount = $totalAmount + ($totalAmount * 0.5);
                                    }  
                                    $ketnoi->query("UPDATE users SET 
                                    `money` = `money` + '".$totalAmount."',
                                    `total_nap` = `total_nap` + '".$totalAmount."' WHERE `username` = '$username' ");
                                    send_noti ($totalAmount,$transId);
                                    require('../api/tele.php');
                                }
                            
        }
      }
    }
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

  $data['message'] = '+ '.format_cash($totalAmount).' lý do: Nạp MOMO Auto  #'.$transId.' ';
  $data['type'] = 'success';
  $data['url'] = '/profile/';
  $pusher->trigger('G100K', 'RechargeMomo', $data);
}

