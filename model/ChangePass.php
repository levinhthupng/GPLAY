<?php
include "../config.php";
if(isset($_SESSION['username']))
{
    $password = check_string($_POST['password']);
    $newpassword = check_string($_POST['newpassword']);
    $repassword = check_string($_POST['repassword']);
    //$mailotp = check_string($_POST['maotp']);
    $password = md5($password);
    $newpassword = md5($newpassword);
    $repassword = md5($repassword);

    if ($password == "" || $repassword == "" || $newpassword == "") 
    {
        $json['status'] = 0;
	    $json['msg'] = "Vui lòng điền vào ô dưới!";
	    $json['type'] = "warning";
	    exit(json_encode($json));
        //echo('<script type="text/javascript">cuteToast({type: "error",message: "Vui lòng điền vào ô dưới!",timer: 1000})</script>');
    }
    else if ($password != $user['password']) 
    {
        //echo '<script type="text/javascript">swal("Thất Bại", " Mật khẩu hiện tại không chính xác!", "error");</script>';
        $json['status'] = 0;
	    $json['msg'] = " Mật khẩu hiện tại không chính xác!";
	    $json['type'] = "error";
	    exit(json_encode($json));
    }
    else
    {
        $ketnoi->query("INSERT INTO `log` SET 
        `content` = 'Thay đổi mật khẩu, IP (".$ip_address."). ',
        `username` =  '".$user['username']."',
        `createdate` =  now() ");

        $ketnoi->query("UPDATE users SET `password` =  '$newpassword' WHERE `username` = '".$user['username']."' ");
        $json['status'] = true;
	    $json['msg'] = "Thay đổi mật khẩu thành công!";
	    $json['type'] = "success";
	    exit(json_encode($json));
        //die('<script type="text/javascript">cuteToast({type: "success",message: "Thay đổi mật khẩu thành công!",timer: 2500});setTimeout(function(){ location.href = "" },2500);</script>');

       // die('<script type="text/javascript">swal("Thành Công","Thay đổi mật khẩu thành công!","success");setTimeout(function(){ location.href = "" },1000);</script>');
    }
}
