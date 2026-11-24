<?php
session_start();
//error_reporting(0);
include('head.php');
include('nav.php');
include "../APIMM.php";
    $Momo = new Momo;
    $imei = $Momo->generateImei();
	$phone = $_POST['phone'];
	$password = $_POST['password'];
	$time = date('Y-m-d H:i:s');
	$ckusr = $ketnoi->query("SELECT * FROM api WHERE phone = '$phone'");
	$check = mysqli_num_rows($ckusr);
	if(isset($phone) && isset($password)){		
		if($phone == "")
		{
				$json['status'] = 1;
	            $json['msg'] = "<b> Warning - </b>Bạn chưa nhập SDT";
	            $json['type'] = "warning";
	            exit(json_encode($json));
			} 
		else if ($password == "") {
				$json['status'] = 1;
            	$json['msg'] = "<b> Warning - </b>Bạn chưa nhập password";
            	$json['type'] = "warning";
            	exit(json_encode($json));
		}
		else if($check == 0 || $check == NULL)
            {
                
                @$log = $ketnoi->query("INSERT INTO api (phone,pass,imei) VALUES ('{$phone}','{$password}','{$imei}')");
    			//@$up = mysqli_query($ketnoi,"SELECT * FROM api_momo WHERE phone = '$phone'");
    			//$rs = mysqli_fetch_array($up);
    			if($log)
    			{   
                        //print(GET_OTP($data));
    			    if ($Momo->regNewDevice($imei)) {
        			    $json['status'] = true;
        				$json['msg'] = "<b> Success - </b>Đã gửi mã OTP";
        				$json['type'] = "success";
        				exit(json_encode($json));
    			    }
        			else
        			{
        				$json['status'] = true;
        				$json['msg'] = "<b> Danger - </b>Gửi OTP Không Thành Công";
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
		else
		{
		    @$log = $ketnoi->query("UPDATE api SET `phone` = '{$phone}', `pass` = '{$password}', `imei` = '{$imei}'");
		    if($log)
    			{   
    			    
                        //print(GET_OTP($data));
    			    if ($Momo->regNewDevice($imei)) {
        			    $json['status'] = true;
        				$json['msg'] = "<b> Success - </b>Đã gửi mã OTP";
        				$json['type'] = "success";
        				exit(json_encode($json));
    			    }
        			else
        			{
        				$json['status'] = true;
        				$json['msg'] = "<b> Danger - </b>Gửi OTP Không Thành Công";
        				$json['type'] = "danger";
        				exit(json_encode($json));
        			}
    			}
    		else {
    		    $json['status'] = 1;
                $json['msg'] = "<b> Danger - </b>SDT Đã tồn tại trên hệ thống";
                $json['type'] = "danger";
                exit(json_encode($json));
    		}	
		}
	}
?>	