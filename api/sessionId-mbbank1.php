<?php
require_once('../config.php');
$userID = "0886069484";
$password = "4a9d4ae3ce0dd094b5d26aa654181f2a";

$gCaptcha = getCaptcha();                       //get Captcha từ MBBank
//echo $gCaptcha."\n";
$Captcha = giaiCaptcha($gCaptcha);              // giải captcha qua ecaptcha.vn
//echo $Captcha."\n";
$sessionId = getSessionID($Captcha,$userID,$password);    // login web mbbank láy sessionId
$token = $sessionId;
  $create = mysqli_query($ketnoi,"UPDATE `bank` SET 
    `username` = '$userID',
    `password` = '$password',
    `token` = '$token' WHERE `username` = '$userID'" );
if ($create) {
    echo($token);
} else {
    echo("That Bai");
}
function getCaptcha() {
    $url = "https://online.mbbank.com.vn/api/retail-web-internetbankingms/getCaptchaImage";
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $headers = array(
       "Authorization: Basic RU1CUkVUQUlMV0VCOlNEMjM0ZGZnMzQlI0BGR0AzNHNmc2RmNDU4NDNm",
       "Content-Type: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
    $data = '{
            	"refNo": "ca098d386660078cf38b49a661f17af9-2023092017464057",
            	"deviceIdCommon": "wr1mh01h-mbib-0000-0000-2022100414542469",
            	"sessionId": ""
            }';
    
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
    $resp = curl_exec($curl);
    curl_close($curl);
    
    $response = json_decode($resp);
    //var_dump($resp);
    return ($response->imageString);
    //echo ($response->imageString);

}


/*function giaiCaptcha($captcha) {

    $url = "https://ecaptcha.vn/api/captcha/mb";
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $headers = array(
       "Content-Type: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
    $data = '{
                "api_key" : "5e143c41994da7d8206ceb0a44dba10c",
                "img_base64" : "'.$captcha.'"
            }';
    
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
    $resp = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($resp);
    return ($response->captcha);
}*/

function giaiCaptcha($captcha) {
    $curl = curl_init();
    $dataPost = array(
     "api_key" => "91db9c2a72ac590647be9ee5a93de460",
     "img_base64" =>"$captcha"    
     );
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://ecaptcha.sieuthicode.net/api/captcha/mbbank',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>$dataPost,
    ));
    
    $response = curl_exec($curl);
    $data = json_decode($response, true);
    curl_close($curl);
    //print_r ($data['data']['captcha']);
    return ($data['data']['captcha']);
}

function getSessionID($Captcha,$userID,$password) {
    $url = "https://online.mbbank.com.vn/api/retail_web/internetbanking/doLogin";
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $header = array(
            'Accept: application/json, text/plain, */*',
            'Accept-Encoding: gzip, deflate, br',
            'Accept-Language: en-US,en;q=0.9,vi;q=0.8',
            'Authorization: Basic QURNSU46QURNSU4=',
            'Connection: keep-alive',
            'Content-Type: application/json; charset=UTF-8',
            'elastic-apm-traceparent: 00-17620ad87b0b1e04da1d1cf8e8d8c287-bfd8deead47f0f3c-01',
            'Host: online.mbbank.com.vn',
            'Origin: https://online.mbbank.com.vn',
            'Referer: https://online.mbbank.com.vn/pl/login?logout=1',
            'sec-ch-ua: "Chromium";v="104", " Not A;Brand";v="99", "Google Chrome";v="104"',
            'sec-ch-ua-mobile: ?0',
            'sec-ch-ua-platform: "Windows"',
            'Sec-Fetch-Dest: empty',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Site: same-origin',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36',
            'X-Request-Id: 7ed665bc35bb47f19b263447bd1cc180-2022090511445886',
        );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
    $data = 
    '{
    	"userId": "'.$userID.'",
    	"password": "'.$password.'",
    	"captcha": "'.$Captcha.'",
    	"sessionId": null,
    	"refNo": "ca098d386660078cf38b49a661f17af9-2023092017464057",
    	"deviceIdCommon": "wr1mh01h-mbib-0000-0000-2022100414542469"
    }';
    
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
    $resp = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($resp);
    var_dump($response);
    return ($response->sessionId);
}
?>

