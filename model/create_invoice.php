<?php 
include "../config.php";
if(isset($_SESSION['username']) )
{
    $finishTime = date('d-m-Y H:i:s');
    $mili = strtotime($finishTime);
    $amount_momo = check_string($_POST['amount_momo']);
    $request_id = 'G100K'.random('qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM', 6);
    if($amount_momo < 10000)
    {
        $json['status'] = 0;
	    $json['msg'] = "Số Tiền Phải >= 10.000 !";
	    $json['type'] = "error";
	    $json['url'] = "/pay/momo/";
	    exit(json_encode($json));
    }
    else
    {
        $create = $ketnoi->query("INSERT INTO `momo` SET `request_id` = '$request_id',`input_amount` = '$amount_momo',`username` = '".$user['username']."',`time` = '$finishTime', `mili` = '$mili', `status` = 'xuly'");
        if($create)
        {
            $json['status'] = 1;
    	    $json['msg'] = "Quét Mã QR Để Tiến Hành Thanh Toán";
    	    $json['type'] = "success";
    	    $json['amount'] = $amount_momo;
    	    $json['request_id'] = $request_id;
    	    exit(json_encode($json));
        }
    }
}

?>