<?php 
require_once "../api/APIMM.php";
require_once "../config.php";
$ckusr = $ketnoi->query("SELECT * FROM `api`");
$check = mysqli_num_rows($ckusr);
$rs = mysqli_fetch_array($ckusr);
$token = $rs['token'];
$phone = $rs['phone'];
$getTranId = $ketnoi->query("SELECT * FROM momo WHERE status = 'xuly' LIMIT 1");
if(mysqli_num_rows($getTranId)==1) {
$checkTranId = mysqli_num_rows($getTranId);
$rsTranId = mysqli_fetch_array($getTranId);
$tranId = $rsTranId['tranId'];
$partnerId = $rsTranId['partnerId'];
$partnerName = $rsTranId['partnerName'];
$hinhthuc = "Momo";
$finishTime = $rsTranId['time'];
$Momo = new Momo;
$time   = $Momo->getTimeNow();
$test = $Momo->getTimeNow();
$requestKeyRaw = $Momo->randomString(32);
$key = "-----BEGIN RSA PUBLIC KEY-----\nMEgCQQDjtTNZJnbMWXON/mhhLzENzQW8TOH/gaOZ72u6FEzfjyWSfGsP6/rMIVjY\n2w44ZyqNG2p45PGmp3Y8bquPAQGnAgMBAAE=\n-----END RSA PUBLIC KEY-----\n";
$requestKey = $Momo->_encodeRSA($requestKeyRaw, $key);
$url = "https://api.momo.vn/sync/transhis/details";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
    "agent_id: 20024504",
    "user_phone: $phone",
    "sessionkey: c89cf886-8a3f-4c22-b90b-529004737954",
    "Host: api.momo.vn",
    "Content-Type: application/json",
    "Accept: application/json",
    "Authorization: Bearer ".$token,
    "userid: $phone",
    "User-Agent: MoMoPlatform-Release/31100 CFNetwork/978.0.7 Darwin/18.7.0",
    "requestkey: $requestKey"
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = array(
			'requestId' => $time,
            'transId' => $tranId,
            'appVer' => 40051,
            'appCode' => '4.0.5',
            'lang' => "vi",
            'deviceOS' => 'IOS',
            'channel' => "APP",
            'buildNumber' => 0,
            "appId" => "vn.momo.transactionhistory",
		);

curl_setopt($curl, CURLOPT_POSTFIELDS, $Momo->_encode(json_encode($data), $requestKeyRaw));

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
$decodeRq = json_decode($Momo->_decode($resp, $requestKeyRaw));
$getComment = json_decode($decodeRq->momoMsg->serviceData);
$comment = ($getComment->COMMENT_VALUE);
echo($comment);
$money = $decodeRq->momoMsg->totalAmount;
$id = parse_order_id($comment);
if ($id)
            {
               
                $check_code = $ketnoi->query("SELECT * FROM `momo` WHERE `tranId` = '$tranId' ");
                $check_username = $ketnoi->query("SELECT * FROM `users` WHERE `username` = '$id' ");
                if($check_username)
                    {
                        if($check_code)
                        { 
                            $create = $ketnoi->query("UPDATE `momo` SET 
                                `username` = '$id',
                                `comment` = '$comment',
                                `status` = 'hoantat' WHERE `tranId` = '$tranId'");
                                
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
?>


