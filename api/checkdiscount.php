<?php
require_once('../config.php');
//$_POST['user_id'])
	$codedis = $_POST['codedis'];
	$user = $_SESSION['username'];
	$me = $ketnoi->query("SELECT * FROM `discount` WHERE `code` = '{$codedis}' AND `user` = '{$user}'");
	$row = mysqli_fetch_array($me);
	if ($row) {
	    if($row['sudung'] == 1){
	        echo 'Code Đã Sử Dụng !!';
	    } else {
	        echo 'Sử Dụng Mã Giảm Giá Thành Công ! Bạn Được Giảm ' .$row['discount']. '%';
	    }
	} else {
		echo '1';
	}	
?>