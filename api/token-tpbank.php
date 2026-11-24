<?php
require_once('../config.php');
$username = "0345309149"; 
$password = "12082001Lvt";
$kq = get_token($username, $password);
$kq = json_decode($kq);
$token = json_encode($kq);
$token = $kq->access_token;
  $create = mysqli_query($ketnoi,"UPDATE `bank` SET 
    `username` = '$username',
    `password` = '$password',
    `token` = '$token' WHERE `username` = '$username'" );
if ($create) {
    echo($token);
} else {
    echo("That Bai");
}

function get_token($username, $password)
{
    $url = "https://ebank.tpb.vn/gateway/api/auth/login";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
        "DEVICE_ID: LYjkjqGZ3HhGP5520GxPP2j94RDMC7Xje77MI7",
        "PLATFORM_VERSION: 101",
        "DEVICE_NAME: Chrome",
        "SOURCE_APP: HYDRO",
        "Authorization: Bearer",
        "Content-Type: application/json",
        "Accept: application/json, text/plain, */*",
        "Referer: https://ebank.tpb.vn/retail/vX/login?returnUrl=%2Fmain",
        "sec-ch-ua-mobile: ?0",
        "User-Agent: okhttp/3.12.1",
        "PLATFORM_NAME: WEB",
        "APP_VERSION: 1.3",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $data = '{"username":"' . $username . '","password":"' . $password . '"}';

    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);
    return $resp;
}