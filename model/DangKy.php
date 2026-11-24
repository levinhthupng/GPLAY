<?php

if( isset($_GET['ref']) )
{
    $id = check_string($_GET['ref']);
    $row = $ketnoi->query("SELECT * FROM users WHERE id = '$id' ")->fetch_array();
    $_SESSION['ref'] = $row['username'];
    $ref = $_SESSION['ref'];
}
if( isset($_SESSION['ref']) )
{
    $ref = $_SESSION['ref'];
}
else 
{
    $ref = NULL;
}

if(isset($_POST['btnDangKy']))
{
    $username = check_string($_POST['username']);
    $email = check_string($_POST['email']);
    $password = check_string($_POST['password']);
    $fullname = check_string($_POST['fullname']);
    $password = md5($password);
    $query_username = $ketnoi->query("SELECT * FROM users WHERE username = '$username' ");
    $query_email = $ketnoi->query("SELECT * FROM users WHERE email = '$email' ");
    $query_ip = $ketnoi->query("SELECT * FROM users WHERE ip = '$ip_address' ");
    $code = random('QWERTYUIOPASDFGHJKLZXCVBNM','12');
    if(check_username($username) == False)
    {
        //die('<script type="text/javascript">Swal.fire("Thất Bại", "Vui lòng nhập Username hợp lệ", "error");setTimeout(function(){ location.href = "" },1000);</script>');
        die('<script type="text/javascript">cuteToast({type: "error",message: "Vui lòng nhập Username hợp lệ",timer: 2500});setTimeout(function(){ location.href = "" },2500);</script>');
    }
    if(check_email($email) == False)
    {
       // die('<script type="text/javascript">Swal.fire("Thất Bại", "Vui lòng nhập Email hợp lệ", "error");setTimeout(function(){ location.href = "" },1000);</script>');
        die('<script type="text/javascript">cuteToast({type: "error",message: "Vui lòng nhập Email hợp lệ",timer: 2500});setTimeout(function(){ location.href = "" },2500);</script>');
    }
    if ($username == "" || $email == "" || $password =="") 
    {
        echo('<script type="text/javascript">cuteToast({type: "error",message: "'.$lang['msg1'].'",timer: 2500});</script>');
        //echo '<script type="text/javascript">Swal.fire("Thất Bại", "'.$lang['msg1'].'", "error");</script>';
    }
    else if($query_username->num_rows != 0)
    {
        //echo '<script type="text/javascript">Swal.fire("Thất Bại", "'.$lang['msg2'].'", "error");</script>';
        echo('<script type="text/javascript">cuteToast({type: "error",message: "'.$lang['msg2'].'",timer: 2500});</script>');
    }
    else if($query_email->num_rows != 0)
    {
       // echo '<script type="text/javascript">Swal.fire("Thất Bại", "'.$lang['msg3'].'", "error");</script>';
        echo('<script type="text/javascript">cuteToast({type: "error",message: "'.$lang['msg7'].'",timer: 2500});</script>');
    }
    else if($query_ip->num_rows > 1)
    {
       // echo '<script type="text/javascript">Swal.fire("Thất Bại", "'.$lang['msg4'].'", "error");</script>';
        echo('<script type="text/javascript">cuteToast({type: "error",message: "'.$lang['msg4'].'",timer: 2500});</script>');
    }
    else
    {
        $create = $ketnoi->query("INSERT INTO `users` SET 
        `password` = '".$password."',
        `username` = '".$username."',
        `fullname` = '".$fullname."',
        `ref` = '$ref',
        `email` = '".$email."',
        `code` = '".$code."',
        `money` = '0',
        `ip` = '".$ip_address."',
        `createdate` = now() ");
        if ($create)
        {
            $_SESSION['username'] = $username;
            //die('<script type="text/javascript">Swal.fire("Thành Công", "'.$lang['msg5'].'","success");setTimeout(function(){ location.href = "/" },1000);</script>');
            die('<script type="text/javascript">cuteToast({type: "success",message: "'.$lang['msg5'].'",timer: 2500});;setTimeout(function(){ location.href = "/" },1000);</script>');
        }
    }
}

?>

