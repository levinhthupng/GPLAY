<?php
session_start();
//error_reporting(0);
include('head.php');
include('nav.php');
include "../APIMM.php";
    $Momo = new Momo;
	$otp = $_POST['otp'];
	$phone = $_POST['phone'];
	$time = date('Y-m-d H:i:s');
	$ckusr = $ketnoi->query("SELECT * FROM api WHERE phone = '$phone'");
	$check = mysqli_num_rows($ckusr);
	$rs = mysqli_fetch_array($ckusr);
	if(isset($otp)){		
		if($otp == "")
		{
				$json['status'] = 1;
	            $json['msg'] = "<b> Warning - </b>Bạn chưa nhập OTP";
	            $json['type'] = "warning";
	            exit(json_encode($json));
		} 
		else if($check == 0 || $check == NULL)
            {
                
			$json['status'] = 1;
            $json['msg'] = "<b> Danger - </b>Vui Lòng GET OTP Trước";
            $json['type'] = "danger";
            exit(json_encode($json));
                
            }
		else
		{
                @$log = $ketnoi->query("UPDATE api SET `otp` = '{$otp}' WHERE phone = '$phone'");
    			//@$up = mysqli_query($ketnoi,"SELECT * FROM api_momo WHERE phone = '$phone'");
    			//$rs = mysqli_fetch_array($up);
    			if($log)
    			{   
                    $result = $Momo->verifyDevice($rs['imei'], $otp);
                    $jsonDecode = json_decode($result);
                    $pHash = $jsonDecode->pHash;
                    $check1 = $ketnoi->query("UPDATE api SET `pHash` = '{$pHash}' WHERE `phone` = {$phone}");
    			    if ($check1) {
        			    $json['status'] = true;
        				$json['msg'] = "<b> Success - </b>Thêm Thành Công";
        				//$json['msg'] = "$rkey";
        				$json['type'] = "success";
        				exit(json_encode($json));
    			    }
        			else
        			{
        				$json['status'] = true;
        				$json['msg'] = "<b> Danger - </b>Thêm Thất Bại";
        				$json['type'] = "danger";
        				exit(json_encode($json));
        			}
    			}
    			else
    			{
    				$json['status'] = true;
    				$json['msg'] = "<b> Danger - </b>Thất Bại";
    				$json['type'] = "danger";
    				exit(json_encode($json));
    			}
			
		}
	}
?>	