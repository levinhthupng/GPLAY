<?php
if (!defined('VERIFY_HOST'))    define('VERIFY_HOST', '163.61.183.80:82');
if (!defined('VERIFY_SESSID'))  define('VERIFY_SESSID', '2u2d6uec5m8spasjebld6lptqi');
if (!defined('VERIFY_REFERER')) define('VERIFY_REFERER', 'http://163.61.183.80:82/admin/');
if (!defined('VERIFY_UA'))      define('VERIFY_UA', 'Mozilla/5.0');
function fetch_verify_sessid(array $opts = []): array
{
    $host = $opts['host'] ?? VERIFY_HOST;
    $user = "admin";
    $pass = "12082001Lvt@@";
    $ua   = $opts['ua']   ?? VERIFY_UA;

    $loginUrl = "http://{$host}/module/login.php";

    $ch = curl_init($loginUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => true,
        CURLOPT_POST           => true,
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_HTTPHEADER     => [
            "User-Agent: {$ua}",
            "X-Requested-With: XMLHttpRequest",
        ],
        CURLOPT_POSTFIELDS => http_build_query([
            'username' => $user,
            'password' => $pass,
        ]),
    ]);

    $resp = curl_exec($ch);
    if ($resp === false) {
        return ['ok'=>false,'error'=>'CURL_FAIL','msg'=>curl_error($ch)];
    }

    $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    curl_close($ch);

    $header = substr($resp, 0, $headerSize);

    if (preg_match('/PHPSESSID=([^;]+)/', $header, $m)) {
        return [
            'ok'   => true,
            'sess' => $m[1],
        ];
    }

    return ['ok'=>false,'error'=>'NO_SESSION'];
}
var_dump(fetch_verify_sessid());
?>

