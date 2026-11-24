<?php
include "../config.php";
if(isset($_SESSION['username']) )

{
    $loaithe = check_string($_POST['loaithe']);
    $menhgia = check_string($_POST['menhgia']);
    $seri = check_string($_POST['seri']);
    $pin = check_string($_POST['pin']);
    $mili = strtotime(date('Y-m-d H:i:s'));
    $code1 = random('qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPASDFGHJKLZXCVBNM', 12);
    $thucnhan = $menhgia - $menhgia * $site['site_ck_card'] / 100;
    if (strlen($seri) < 5 || strlen($pin) < 5)
    {
        $json['status'] = 0;
	    $json['msg'] = "Mã thẻ hoặc seri không đúng định dạng!";
	    $json['type'] = "error";
	    exit(json_encode($json));
    }
    else
    {
         
		$command = 'charging';  // Nap the

        require_once('../to9xvn_tsr.php'); 

        $request_id = rand(100000000, 999999999); /// Order id của bạn, ví dụ này lấy ngẫu nhiên để test
            $telco = $loaithe;
            $amount = $menhgia;
            $serial = $seri;
            $code = $pin;
            $dataPost = array();
			$dataPost['partner_id'] = $partner_id;
			$dataPost['request_id'] = $request_id;
			$dataPost['telco'] = $telco;
			$dataPost['amount'] = $amount;
			$dataPost['serial'] = $serial;
			$dataPost['code'] = $code;
			$dataPost['command'] = $command;
			$sign = creatSign($partner_key, $dataPost);
			$dataPost['sign'] = $sign;
			
            $data = http_build_query($dataPost);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            curl_setopt($ch, CURLOPT_REFERER, $actual_link);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);

            $obj = json_decode($result);
            $tbcmmm = $obj->message;
            if ($obj->status == 99) {
              $create = $ketnoi->query("INSERT INTO `cards` SET 
              `code` = '".$code1."',
              `seri` = '".$seri."',
              `pin` = '".$pin."',
              `loaithe` = '".$loaithe."',
              `menhgia` = '".$menhgia."',
              `thucnhan` = '".$thucnhan."',
              `username` = '".$my_username."',
              `mili` = '$mili',
              `status` = 'xuly',
              `note` = '',
              `createdate` = now() ");
          
                $json['status'] = 0;
        	    $json['msg'] = "$tbcmmm";
        	    $json['type'] = "success";
        	    exit(json_encode($json));
              }
              else
              {
                //echo '<script type="text/javascript">Swal.fire("Error","Nạp thẻ lỗi '.$tbcmmm.'","error");</script>';
                $json['status'] = 0;
        	    $json['msg'] = "Nạp thẻ lỗi $tbcmmm";
        	    $json['type'] = "error";
        	    exit(json_encode($json));
              }
            
        
    }
}
/*MÃ NGUỒN ĐƯỢC PHÁT TRIỂN BỞI CMSNT.CO DEV NTTHANH - LH ZALO 0947838128*/
?>