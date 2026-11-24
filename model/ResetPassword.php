<?php
/*MÃ NGUỒN ĐƯỢC PHÁT TRIỂN BỞI CMSNT.CO DEV NTTHANH - LH ZALO 0947838128*/
if(isset($_POST['token']) && isset($_POST['btnChangePass']))
{
    $password = check_string($_POST['password']);
    $repassword = check_string($_POST['repassword']);
    $token = check_string($_POST['token']);
    $query = $ketnoi->query("SELECT * FROM users WHERE token = '$token' ");
    $query_array = $query->fetch_array();
    $password = md5($password);
    $repassword = md5($repassword);
    if($query->num_rows == 0)
    {
        //echo '<script type="text/javascript">swal("Thất Bại", " Token không hợp lệ !", "error");</script>';
        echo('<script type="text/javascript">cuteToast({type: "error",message: "Token không hợp lệ !",timer: 2500});</script>');
    }
    else if ($password == "" || $repassword == "") 
    {
        //echo '<script type="text/javascript">swal("Thất Bại", " Vui lòng điền vào ô dưới!", "error");</script>';
        echo('<script type="text/javascript">cuteToast({type: "error",message: " Vui lòng điền vào ô dưới!",timer: 2500});</script>');
    }
    else if ($password != $repassword) 
    {
        //echo '<script type="text/javascript">swal("Thất Bại", " Nhập lại mật khẩu không đúng!", "error");</script>';
        echo('<script type="text/javascript">cuteToast({type: "error",message: " Nhập lại mật khẩu không đúng!",timer: 2500});</script>');
    }
    else
    {
        $ketnoi->query("INSERT INTO `log` SET 
        `content` = 'Khôi phục lại mật khẩu IP (".$ip_address."). ',
        `username` =  '".$query_array['username']."',
        `createdate` =  now() ");
        $ketnoi->query("UPDATE users SET `password` =  '$password', `token` = null WHERE `token` = '$token' ");
       // die('<script type="text/javascript">swal("Thành Công","Thay đổi mật khẩu thành công!","success");setTimeout(function(){ location.href = "/login/" },1000);</script>');
        die('<script type="text/javascript">cuteToast({type: "success",message: "Thay đổi mật khẩu thành công!",timer: 2500});setTimeout(function(){ location.href = "/login/" },1000);</script>');
    }
}
/*MÃ NGUỒN ĐƯỢC PHÁT TRIỂN BỞI CMSNT.CO DEV NTTHANH - LH ZALO 0947838128*/
?>