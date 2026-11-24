<?php
require_once('../config.php');
//$_POST['user_id'])
	$codedis =  $_POST['codedis'];
	$tongtien = $_POST['tongtien'];
	$me = $ketnoi->query("SELECT * FROM `discount` WHERE `code` = '{$codedis}' ");
	$row = mysqli_fetch_array($me);
	if ($row) {
        if($row['sudung']!=1) {
            echo format_cash($tongtien - $tongtien * $row['discount']/100);
        } else {
            echo '2';
        }
	} else {
		echo '1';
	}	
?>