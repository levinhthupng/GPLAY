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
            	"refNo": "2022100519072596",
            	"deviceIdCommon": "raffy090-mbib-0000-0000-2024011222255269",
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

function giaiCaptcha($captcha) {
    $IMG = 'data:image/png;base64,'.$captcha;
    $url = 'https://api.g100k.net/base64.php';
    
    $data = array(
        'dataIMG' => $IMG
        );
        
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Lỗi cURL: ' . curl_error($ch);
    }
    curl_close($ch);
    return ($result);
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

/*function giaiCaptcha($captcha) {
    $dataPost = [
        "username" => "levinhthuong",
        "api_key" => "dd42aec1217a8860ce707dcebd9dcd5b",
        "img_base64" => "$captcha"
    ];
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://dichvudark.vn/api/captcha/mbbank",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $dataPost,
    ));
    
    $response = curl_exec($curl);
    $data = json_decode($response, true);
    curl_close($curl);
    //print_r ($data['data']['captcha']);
    return ($data['data']['captcha']);
}
*/
function getSessionID($Captcha,$userID,$password) {
    $url = "https://online.mbbank.com.vn/api/retail_web/internetbanking/doLogin";
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $headers = array(
       "Authorization: Basic RU1CUkVUQUlMV0VCOlNEMjM0ZGZnMzQlI0BGR0AzNHNmc2RmNDU4NDNm",
       "Content-Type: application/json",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
    $data = 
    '{
    	"userId": "'.$userID.'",
    	"password": "'.$password.'",
    	"captcha": "'.$Captcha.'",
    	"sessionId": null,
    	"refNo": "c6c8604fdf5b77849c9255aa59e3d90e-2022100519184442",
    	"deviceIdCommon": "raffy090-mbib-0000-0000-2024011222255269"
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

