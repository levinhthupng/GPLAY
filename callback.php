<?php
require_once('config.php');
error_reporting(0);

include 'to9xvn_tsr.php';
$codediscount = 'G100K'.random('qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM', 12);
	$callback_sign = md5($partner_key.$_GET['code'].$_GET['serial']);



		if($_GET['callback_sign'] == $callback_sign) { 
	$getdata['status'] = $_GET['status'];
				$getdata['message'] = $_GET['message'];
				$getdata['request_id'] = $_GET['request_id'];   /// Mã giao dịch của bạn
				$getdata['trans_id'] = $_GET['trans_id'];   /// Mã giao dịch của website webthedfull.com
				$getdata['declared_value'] = $_GET['declared_value'];  /// Mệnh giá mà bạn khai báo lên
				$getdata['value'] = $_GET['value'];  /// Mệnh giá thực tế của thẻ
				$getdata['amount'] = $_GET['amount'];   /// Số tiền bạn nhận về (VND)
				$getdata['code'] = $_GET['code'];   /// Mã nạp
				$getdata['serial'] = $_GET['serial'];  /// Serial thẻ
				$getdata['telco'] = $_GET['telco'];   /// Nhà mạng
  $code =  $_GET['code'];  
  $seri =  $_GET['serial']; 
    $card = $ketnoi->query("SELECT * FROM cards WHERE `pin` = '$code' and `seri` = '$seri'  ")->fetch_array();
    echo ($_GET['status']);
    if ($_GET['status'] == '1')
    {
        $thucnhan = $card['thucnhan'];
        //Nạp Nhận Mã Giam Gia
        if($site_discount == 'ON') {
            $amount = $getdata['value'];
                if($amount >= $discount_value) {
                    $check_discount = $ketnoi->query("SELECT * FROM `discount` WHERE `user` = '".$card['username']."' AND `amount_event` = '$discount_value'");
                    if($check_discount->fetch_assoc() == 0) {
                        $check_level = $ketnoi->query("SELECT * FROM `users` WHERE `username` = '".$card['username']."' ")->fetch_assoc()['level'];
                                    if ($check_level == 0) {
                                        $discount_ck = $discount_ck - 10;
                                        //echo $discount_ck;
                                    } else {
                                        $discount_ck = $discount_ck;
                                       // echo $discount_ck;
                                    }
                        $adddiscount = $ketnoi->query("INSERT INTO `discount` SET 
                            `code` = '".$codediscount."',
                            `user` = '".$card['username']."',
                            `discount` = '$discount_ck',
                            `amount_event` = '$discount_value',
                            `createdate` = now()");
                    if ($adddiscount)
                    {
                        $ketnoi->query("INSERT INTO `log` SET 
                                `content`= 'Bạn Nhận Được Mã Giảm Giá  ".$codediscount." ',
                                `createdate` = now(),
                                `username`= '".$card['username']."' ");
                    }
                }
            }
        } 
        //END Nạp Nhận Mã Giam Gia
        
        if($site_km == 'ON') {
            $thucnhan = $thucnhan + ($thucnhan * 0.5);
        }  
        send_noti($thucnhan);
        $ketnoi->query("UPDATE `cards` SET `status` = 'hoantat', `note` = 'Nạp Card thành công, thực nhận $thucnhan' WHERE `pin` = '$code' and `seri` = '$seri'");
        $ketnoi->query("UPDATE users SET `money` = `money` + '$thucnhan', `total_nap` = `total_nap` + '$thucnhan' WHERE `username` = '".$card['username']."' ");
        $ketnoi->query("INSERT INTO `log` SET 
              `content` = 'Nạp Card thành công, thực nhận $thucnhan ',
              `createdate` = now(),
              `username` = '".$card['username']."' ");
    }
    else if ($_GET['status'] == '2') 
    {
        $thucnhan = $card['amount'];
        send_noti($thucnhan);
        $ketnoi->query("UPDATE `cards` SET `status` = 'thesai', `note` = 'Nạp Card thành công Nhưng Sai Mệnh Giá, thực nhận $thucnhan' WHERE `pin` = '$code' and `seri` = '$seri'");
        $ketnoi->query("UPDATE users SET `money` = `money` + '$thucnhan', `total_nap` = `total_nap` + '$thucnhan' WHERE `username` = '".$card['username']."' ");
        $ketnoi->query("INSERT INTO `log` SET 
              `content` = 'Nạp Card Sai Mệnh Giá, thực nhận $thucnhan ',
              `createdate` = now(),
              `username` = '".$card['username']."' ");
    } else
    {
        $ketnoi->query("UPDATE cards SET status = 'thatbai' WHERE `pin` = '$code' and `seri` = '$seri' ");
    }
}
else
{   
    echo json_encode(array('status' => "error", 'msg' => "Lỗi"));
}
function send_noti($thucnhan) {
  require_once("./vendors/autoload.php");

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

  $data['message'] = "Nạp Card thành công, thực nhận $thucnhan";
  $data['type'] = 'success';
  $data['url'] = '/profile/';
  $pusher->trigger('G100K', 'card', $data);
}
?>