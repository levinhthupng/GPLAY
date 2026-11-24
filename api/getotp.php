
<?php
header('Content-type: text/html; charset=utf-8');
include('APIMM.php');
$Momo = new Momo;
$imei = $Momo->generateImei();
$kq = $Momo->regNewDevice("bd1a285c-7e11-d98d-8838-795bc3763e77");
//echo  utf8_encode(json_encode($kq));
echo $kq;
//$result = $Momo->verifyDevice($rs['imei'], $otp);
?>