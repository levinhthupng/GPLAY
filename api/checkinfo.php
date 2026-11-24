<?php
require_once('../config.php');
//$_POST['user_id'])
	$user_id = $_POST['tengame'];
	$check =  $_POST['check'];
	$me = $ketnoi->query("SELECT * FROM `category` WHERE `code` = '{$user_id}'");
	$row = mysqli_fetch_array($me);
	if ($row) {
	    if($check == 'money') {
	        echo format_cash($row[$check]);
	    } else {
		echo $row[$check];
	    }
	} else {
		echo 'Code Không Hợp Lệ Vui Lòng Nhập Lại !!';
	}	
?>