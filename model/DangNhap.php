<?php 
if(isset($_POST['btnDangNhap']))
{
    $username = check_string($_POST['username']);
    $password = check_string($_POST['password']);
    $password = md5($password);
    $query = $ketnoi->query("SELECT * FROM users WHERE username = '$username' OR email = '$username'")->fetch_array();
    if ($username == "" || $password =="") 
    {
        echo '<script type="text/javascript">cuteToast({type: "error",message: "'.$lang['msg6'].'",timer: 2500});</script>';
        
    }
    else if(empty($query))
    {
        echo '<script type="text/javascript">cuteToast({type: "error",message: "'.$lang['msg7'].'",timer: 2500});</script>';
    }   
    else if($password != $query['password'])
    {
        echo('<script type="text/javascript">cuteToast({type: "error",message: "'.$lang['msg8'].'",timer: 2500});</script>');       //echo '<script type="text/javascript">Swal.fire("Thất Bại", "'.$lang['msg8'].'", "error");</script>';
    }
    else
    {
        $ketnoi->query("UPDATE users SET ip = '$ip_address' WHERE username = '$username' OR email = '$username'");
        $_SESSION['username'] = $query['username'];
        //GHI NHẬT KÝ HOẠT ĐỘNG
        //$ketnoi->query("INSERT INTO `log` SET `content` = 'Thực hiện đăng nhập vào hệ thống ! ', `createdate` = now(), `username` = '$username' ");
        die('<script type="text/javascript">cuteToast({type: "success",message: "Đăng Nhập Thành Công!",timer: 2500});setTimeout(function(){ location.href = "/" },2500);</script>');
        //die('<script type="text/javascript">Swal.fire("Success","Đăng Nhập Thành Công!","success");setTimeout(function(){ location.href = "/" },1000);</script>');
    }
}
?>

