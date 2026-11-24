<?php
include "../config.php";
if(isset($_SESSION['username']))
{
    $mailotp = check_string($_POST['maotp']);
    
    if ($mailotp == "") 
    {   
        $json['status'] = 0;
        $json['msg'] = "Chưa Nhập Mã Xác Minh!";
        $json['type'] = "error";
        exit(json_encode($json));
            //echo '<script type="text/javascript">swal("Thất Bại", " Vui lòng điền vào ô dưới!", "error");</script>';
            //echo('<script type="text/javascript">cuteToast({type: "error",message: "Chưa Nhập Mã Xác Minh!",timer: 1000})</script>');
    }
    else if ($mailotp != $user['token']) 
    {
        $json['status'] = 0;
        $json['msg'] = "OTP không đúng ! Vui lòng kiểm tra hoặc gửi lại Email !";
        $json['type'] = "error";
        exit(json_encode($json));
            //echo('<script type="text/javascript">cuteToast({type: "error",message: "OTP không đúng ! Vui lòng kiểm tra hoặc gửi lại Email !",timer: 1000})</script>');
            //echo '<script type="text/javascript">swal("Thất Bại", "OTP không đúng ! Vui lòng kiểm tra hoặc gửi lại Email !", "error");</script>';
    }
    else
    {
        $ketnoi->query("INSERT INTO `log` SET 
        `content` = 'Xác Thực Email, IP (".$ip_address."). ',
        `username` =  '".$user['username']."',
        `createdate` =  now() ");
    
        $ketnoi->query("UPDATE users SET `verify` =  '1' WHERE `username` = '".$user['username']."' ");
        $json['status'] = 1;
        $json['msg'] = "Xác minh Email thành công!";
        $json['type'] = "success";
        exit(json_encode($json));
            //die('<script type="text/javascript">cuteToast({type: "success",message: "Xác minh Email thành công!",timer: 2500});setTimeout(function(){ location.href = "" },2500);</script>');
    
           // die('<script type="text/javascript">swal("Thành Công","Thay đổi mật khẩu thành công!","success");setTimeout(function(){ location.href = "" },1000);</script>');
    }
}