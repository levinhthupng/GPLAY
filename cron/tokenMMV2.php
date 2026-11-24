<?php
require_once "../config.php";
$ckusr = $ketnoi->query("SELECT * FROM `api`");
$check = mysqli_num_rows($ckusr);
$rs = mysqli_fetch_array($ckusr);
$url = "https://owa.momo.vn/public/login";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = <<<DATA
{
	"user": "0886069484",
	"pass": "120820",
	"msgType": "USER_LOGIN_MSG",
	"momoMsg": {
		"_class": "mservice.backend.entity.msg.LoginMsg",
		"isSetup": false
	},
	"extra": {
		"pHash": "N3cA0w8EeuRGID7sZrfOHYNRldtcpmMR1ao7jjS8M7DDsP85Pbqz+YyWFs1ngFTa",
		"IDFA": "",
		"SIMULATOR": false,
		"TOKEN": "dOyzVukayU2CmJYhSMTV54:APA91bGOWf2nQfqCfdm_15J35z2sJxbPvXo1Xk1sd7mATnBDVz7En8q13CZiZDWytUz8F_eR0bhy7P4tDGfvvBs090_RQCTm4rLqDaNzIGl5-fC9luLlxVwI75FirMq-lQfRbaQztBlO",
		"ONESIGNAL_TOKEN": "dOyzVukayU2CmJYhSMTV54:APA91bGOWf2nQfqCfdm_15J35z2sJxbPvXo1Xk1sd7mATnBDVz7En8q13CZiZDWytUz8F_eR0bhy7P4tDGfvvBs090_RQCTm4rLqDaNzIGl5-fC9luLlxVwI75FirMq-lQfRbaQztBlO",
		"SECUREID": "",
		"MODELID": "774d2188d70281b0ee02bbbacdccbd56c8d7f324e390ea987b2fa4476eebe5d2",
		"DEVICE_TOKEN": "26F28D7BF84DF97FFD89609E4E854FBEF662C5991B34C7398345F0AECC77EDE2",
		"checkSum": "JMXqF8AN3mpAlMH91H8lCKr8E7RTXuyvDh0YF19bpLuiY4xcJpodkjZjs1XXWAns5DaTMCFkP4OtkJW9KDNZVQ=="
	},
	"appVer": 40201,
	"appCode": "4.0.20",
	"lang": "vi",
	"deviceOS": "ios",
	"channel": "APP",
	"buildNumber": 0,
	"appId": "vn.momo.platform",
	"cmdId": "1685263744561000000",
	"time": 1685263744561
}
DATA;

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
$jsonDecode = json_decode($resp);
var_dump($resp);
$token = ($jsonDecode->extra->AUTH_TOKEN);
$balance = ($jsonDecode->extra->BALANCE);
$fullname = ($jsonDecode->extra->FULL_NAME);
$phone = $rs['phone'];
$ketnoi->query("UPDATE `api` SET `balance` = '$balance', `token` = '$token', `name` = '$fullname'  WHERE `phone` = '$phone'");
echo $token;
?>

