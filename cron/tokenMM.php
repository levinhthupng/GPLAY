<?php
require_once "../config.php";
require_once "../api/APIMM.php";
$ckusr = $ketnoi->query("SELECT * FROM `api`");
$check = mysqli_num_rows($ckusr);
$rs = mysqli_fetch_array($ckusr);
$Momo = new Momo;
$result = $Momo->userLogin($rs['pHash']);
$jsonDecode = json_decode($result);
$token = ($jsonDecode->AUTH_TOKEN);
$balance = ($jsonDecode->balance);
$phone = $rs['phone'];
$ketnoi->query("UPDATE `api` SET `balance` = '$balance', `token` = '$token' WHERE `phone` = '$phone'");
echo $token;
?>