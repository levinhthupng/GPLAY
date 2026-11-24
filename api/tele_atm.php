<?php
/**
 * @package NOTAD API MOMO
 * @author  LÊ HỒNG SƠN : 0387654818
 * @copyright   Copyright (c) 2021, notad.net
 * @link    https://notad.net
 * @since   Version 1.0
 * @method Sell Api Lịch sử giao dịch VCB, TCB 0387654818 
 */
$sdtkh =$username;
$tenkh = $username;
$idd = $tranId;
$mountt = number_format($money);
$hinhthuc = $hinhthuc;
$msg = $finishTime;
$noidung = $comment;
$curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.telegram.org/bot1817291347:AAGrpIU3ghxwD3_nX_x7vMfe4y371q2hUw0/sendMessage",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => array(
        'chat_id' => 1715079810,
        'text' => "Nhật Kí Giao Dịch:\nMã giao dịch: $idd\nHình Thức: $hinhthuc\nKhách hàng: $sdtkh\nSố tiền: $mountt\nLời nhắn: $noidung\nTime: $msg"
      ),
    ));
    $response = curl_exec($curl);
    if (curl_errno($curl)) {
      $error_msg = curl_error($curl);
      // handle error here
    }
    curl_close($curl);
?>