<?php

function getHexGuid($a){
	$r='';
	while($a){
		$r = sprintf("%02X%s",bcmod($a,256),$r);
		$a = bcdiv($a,256);
	}
	return $r;
}

function mima($data,$key) {
    $signbb = md5($data.$key);
    return $signbb;
}
//更多资源下载www.qcymw.com
function post_curl($url, $data_string) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 1);	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	$result = curl_exec($ch);
	if(curl_errno($ch)){
		print_r(curl_error($ch));
	}
	curl_close($ch);
	return $result;	
}