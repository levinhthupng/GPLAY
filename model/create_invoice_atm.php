<?php 
include "../config.php";
if(isset($_SESSION['username']) )
{
    $finishTime = date('d-m-Y H:i:s');
    $mili = strtotime($finishTime);
    $amount_atm = check_string($_POST['amount_amt']);
    $request_id = 'GK'.random('qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM', 6);
    if($amount_atm < 10000)
    {
        $json['status'] = 0;
	    $json['msg'] = $amount_atm;
	    $json['type'] = "error";
	    $json['url'] = "/pay/bank/";
	    exit(json_encode($json));
    }
    else
    {
        $create = $ketnoi->query("INSERT INTO `bank_auto` SET `request_id` = '$request_id',`input_amount` = '$amount_atm',`username` = '".$user['username']."',`time` = '$finishTime', `mili` = '$mili',`status` = 'xuly'");
        if($create)
        {
            $json['status'] = 1;
    	    $json['msg'] = "Quét Mã QR Để Tiến Hành Thanh Toán";
    	    $json['type'] = "success";
    	    $json['amount'] = $amount_atm;
    	    $json['request_id'] = $request_id;
    	    exit(json_encode($json));
        }
    }
}

?>