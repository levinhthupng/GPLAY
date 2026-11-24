<?php
require_once('../config.php');
$finishTime = date('d-m-Y H:i:s');
$mili_now = strtotime($finishTime);
$rq_id = $ketnoi->query("SELECT * FROM `bank_auto` WHERE `status` = 'xuly' ORDER BY id desc LIMIT 1");
$rq_id1 = mysqli_fetch_array($rq_id);
$date = $rq_id1['time'];
$code = $rq_id1['request_id'];
$mili = strtotime(date('d-m-Y H:i:s', strtotime('+5 minutes', strtotime($date))));
if ($mili_now >= $mili ) {
   $create = $ketnoi->query("DELETE FROM `bank_auto` WHERE `request_id` = '$code'");
   echo 'Xóa Thành Công ID:' .$code;
}
?>