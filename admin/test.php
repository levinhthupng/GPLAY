<?php
include('../api/APIMM.php');

$Momo = new Momo;
//$imei = strtoupper($Momo->generateImei());
//$imei1 = $Momo->checkPhone($imei);
//echo $imei;
//echo $imei1;

echo utf8_encode($Momo->verifyDevice("24716391-FCA6-4D4A-920E-E53FA45FFDC2", "7941"));		

?>