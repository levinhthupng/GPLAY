<?php
include "../config.php";
if(isset($_SESSION['username']))
{
        $email = $user['email'];
        $get_token = random('0123456789', '6');
        $query = $ketnoi->query("SELECT * FROM users WHERE email = '$email' ");
        if ($email == "") 
        {
            $json['status'] = 0;
    	    $json['msg'] = $lang['msg10'];
    	    $json['type'] = "error";
    	    exit(json_encode($json));
        }
        else if(strlen($email) < 5)
        {
            $json['status'] = 0;
    	    $json['msg'] = $lang['msg11'];
    	    $json['type'] = "error";
    	    exit(json_encode($json));
        }
        else if($query->num_rows == 0)
        {
            $json['status'] = 0;
    	    $json['msg'] = $lang['msg12'];
    	    $json['type'] = "error";
    	    exit(json_encode($json));
        }
        else
        {
            //var_dump ("UPDATE `users` SET `token` = '".$get_token."' WHERE `email` = '".$email."' ");
            $ketnoi->query("UPDATE `users` SET `token` = '".$get_token."' WHERE `email` = '".$email."' ");
            $guitoi = $email;   
            $subject = 'MÃ XÁC NHẬN EMAIL G100K';
            $bcc = $site_tenweb;
            $hoten ='Client';
            $noi_dung = '
            <div style="background-color:#f9f9f9" bgcolor="#f9f9f9">
        <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#f9f9f9" style="background-color:#f9f9f9;border-collapse:collapse;font-size:1px!important;line-height:100%!important;min-width:320px;width:100%!important;margin:0;padding:0">
            <tbody><tr>
                <td align="center" valign="top">
                    <div style="height:20px;line-height:20px;font-size:15px;background-color:#f9f9f9;padding:0;margin:0" bgcolor="#f9f9f9">&nbsp;</div>
                    <table cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;max-width:700px;min-width:320px">
                        <tbody><tr>
                            <td width="20" style="width:20px;max-width:20px;min-width:20px;background-color:#f9f9f9;padding:0" bgcolor="#f9f9f9">&nbsp;</td>
                            <td valign="top" align="center">
                                <div style="height:2px;line-height:2px;font-size:1px;background-color:#00a94f;padding:0;margin:0" bgcolor="#00a94f">&nbsp;</div>
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" style="border-collapse:collapse;border-color:#dddddd;border-style:solid;border-width:0 1px 1px 1px;width:100%">
                                    <tbody><tr>
                                        <td width="40" style="width:40px;max-width:40px;min-width:40px;background-color:#ffffff;padding:0" bgcolor="#ffffff">&nbsp;</td>
                                        <td style="background-color:white;color:#525252;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:15px;line-height:22px;overflow:hidden" bgcolor="white">
                                            <div style="height:30px;line-height:30px;font-size:25px;background-color:#ffffff;padding:0;margin:0" bgcolor="#ffffff">&nbsp;</div>
                                            <div>
                                                
    
    
    <div style="margin:0 0 15px 0">
        Hi '.$user['username'].',
    </div>
    
    <div style="margin:0 0 15px 0">
        Bạn vừa thực hiện yêu cầu gửi mã xác minh email.
    </div>
    
    <div style="margin:0 0 15px 0">
        Mã xác minh của bạn là : <b>'.$get_token.'</b>
     </div>
    
    <div style="margin:0 0 15px 0">
        Thật tuyệt vời khi bạn đã tham gia server chúng tôi !
    </div>
    
    
    
    
        <div style="text-align:center;margin-top:15px;font-family:Helvetica Neue,Helvetica,Arial,sans-serif">
                <a href="https://g100k.net" target="_blank" data-saferedirecturl="https://g100k.net">G100K.NET - SERVER GAME LẬU TOP 1 VIỆT NAM</a>
        </div>
    
                                            </div>
                                            <div style="height:30px;line-height:30px;font-size:25px;background-color:#ffffff;padding:0;margin:0" bgcolor="#ffffff">&nbsp;</div>
                                        </td>
                                        <td width="40" style="width:40px;max-width:40px;min-width:40px;background-color:#ffffff;padding:0" bgcolor="#ffffff">&nbsp;</td>
                                    </tr>
                                </tbody></table>
                                
    
    
        <table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="border-collapse:collapse;width:100%">
            <tbody><tr>
                <td width="40" style="width:40px;max-width:40px;min-width:40px;background-color:#f9f9f9" bgcolor="#f9f9f9">&nbsp;</td>
                <td>
                    <div style="height:20px;line-height:20px;font-size:15px;padding:0;margin:0;background-color:#f9f9f9" bgcolor="#f9f9f9">&nbsp;</div>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;color:#999999;width:100%">
                        <tbody><tr>
                                <td valign="middle" align="left" bgcolor="#f9f9f9" width="50" style="width:50px;min-width:50px;text-align:left;background-color:#f9f9f9">
                                    <img src="https://ci5.googleusercontent.com/proxy/CxgSqPzKrIzP9GExSAR8rIf0kMpB4bEfDNG-z87SaDOcZYSuLW3swTR1OrFjc57XIWzcEQTD3iRx97q5zBOzqLuJLRFccrfxPPRVXQ=s0-d-e1-ft#https://sqlbackupandftp.com/content/img/sbflogo-email.png" height="32" width="32" border="0" style="display:inline-block;height:32px;width:32px;max-width:100%;outline:none;border:none" class="CToWUd">
                                </td>
                            <td align="left" valign="middle" bgcolor="#f9f9f9" style="text-align:left;background-color:#f9f9f9;color:#999999;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:13px;line-height:20px;overflow:hidden">
                                You are receiving this email because you have an account at <a href="https://g100k.net" target="_blank" data-saferedirecturl="https://g100k.net">G100K.NET</a>.
                            </td>
                        </tr>
                    </tbody></table>
                </td>
                <td width="40" style="width:40px;max-width:40px;min-width:40px;background-color:#f9f9f9" bgcolor="#f9f9f9">&nbsp;</td>
            </tr>
        </tbody></table>
    
                                
    
    
    
                            </td>
                            <td width="20" style="width:20px;max-width:20px;min-width:20px;background-color:#f9f9f9;padding:0" bgcolor="#f9f9f9">&nbsp;</td>
                        </tr>
                    </tbody></table>
                    <div style="height:20px;line-height:20px;font-size:15px;background-color:#f9f9f9;padding:0;margin:0" bgcolor="#f9f9f9">&nbsp;</div>
                </td>
            </tr>
        </tbody></table><div class="yj6qo"></div><div class="adL">
    </div></div>';
            sendCSM($guitoi, $hoten, $subject, $noi_dung, $bcc);   
            $json['status'] = 1;
    	    $json['msg'] = $lang['msg13'];
    	    $json['type'] = "success";
    	    exit(json_encode($json));
            //die('<script type="text/javascript">swal("Thành Công","'.$lang['msg13'].'","success");setTimeout(function(){ location.href = "" },3000);</script>');
        }
    
}
?>
