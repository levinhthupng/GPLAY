<?php 
include "../config.php";
if(isset($_SESSION['username']) )
{
    $code = check_string($_POST['code']);
    $query = $ketnoi->query("SELECT * FROM giftcode WHERE code = '$code' ");
    $array = $query->fetch_array();
    $query_log = $ketnoi->query("SELECT * FROM log_giftcode WHERE code = '$code' AND username = '".$user['username']."' ");
    if($user['verify'] == 0)
    {
        $json['status'] = 0;
	    $json['msg'] = "Bạn chưa xác minh Email !!!";
	    $json['type'] = "error";
	    exit(json_encode($json));
    }
    if(strlen($code) <= 0)
    {
        $json['status'] = 0;
	    $json['msg'] = "Vui lòng nhập Giftcode !";
	    $json['type'] = "warning";
	    exit(json_encode($json));
    }
    if(empty($array))
    {
        $json['status'] = 0;
	    $json['msg'] = "Giftcode không tồn tại trong hệ thống !";
	    $json['type'] = "error";
	    exit(json_encode($json));
    }
    if($array['dieukien'] > $user['total_nap'])
    {
        $json['status'] = 0;
	    $json['msg'] = "Bạn không đủ điều kiện sử dụng Giftcode này!";
	    $json['type'] = "error";
	    exit(json_encode($json));
    }
    if($array['level'] > $user['level'])
    {
        $json['status'] = 0;
	    $json['msg'] = "Giftcode này chỉ dành cho Fan Cứng!";
	    $json['type'] = "error";
	    exit(json_encode($json));
    }
    if($array['soluong'] <= $array['sudung'])
    {
        $json['status'] = 0;
	    $json['msg'] = "Giftcode đã được sử dụng !";
	    $json['type'] = "error";
	    exit(json_encode($json));
    }
    if($query_log->num_rows != 0)
    {
        $json['status'] = 0;
	    $json['msg'] = "Bạn đã sử dụng Giftcode này rồi !";
	    $json['type'] = "error";
	    exit(json_encode($json));
    }
    else
    {
        $ketnoi->query("UPDATE giftcode SET sudung = sudung + 1 WHERE code = '$code' ");
        $create = $ketnoi->query("INSERT INTO log_giftcode SET 
        username = '".$user['username']."', 
        code = '$code', 
        money = '".$array['money']."', 
        createdate = now() ");
        if($create)
        {
            $content = 'Sử dụng Giftcode '.$code.' (+'.$array['money'].')';
            $ketnoi->query("UPDATE users SET `money` = `money` + '".$array['money']."' WHERE username = '".$user['username']."' ");
            $ketnoi->query("INSERT INTO `log` SET 
            username = '".$user['username']."', 
            content = '$content',
            createdate = now() ");
            $json['status'] = 1;
    	    $json['msg'] = "Sử dụng Giftcode Thành Công!";
    	    $json['type'] = "success";
    	    exit(json_encode($json));
        }
    }
}

?>