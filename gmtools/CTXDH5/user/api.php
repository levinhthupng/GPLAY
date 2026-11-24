<?php
// 菜鸟阁Q9851320 功能添加  请尊重每一个学习的人.勿删！！！
function loginGetCookie($url,$user,$pswd){
         $ch = curl_init($url); 
		 $post = array(
		  "username" => "$user" ,
	      "password" =>  "$pswd",
	      "verify_code" =>  "",
		);
		
		  curl_setopt($ch, CURLOPT_HEADER, 1);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
          curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
		  $content=curl_exec($ch);
          preg_match('/Set-Cookie:(.*);/iU',$content,$str); 
          $cookie = $str[1]; //获得COOKIE
		  return $cookie;
}


function getUID($url, $uid, $cookie) {
    $endpoint = "$url";
    $postData = [
        "pf_key"    => "$uid",
        "view_type" => "pf_key",
    ];
    
    
    $ch = curl_init($endpoint);
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query($postData),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,   // tự theo 30x
        CURLOPT_MAXREDIRS      => 5,
        CURLOPT_COOKIE         => $cookie,
        CURLOPT_USERAGENT      => "Mozilla/5.0",
    ]);
    $body = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    
    $uid = null;
    
    /* Cách 1: lấy từ URL cuối cùng */
    if (!empty($info['url'])) {
        parse_str(parse_url($info['url'], PHP_URL_QUERY) ?? '', $q);
        $uid = $q['uid'] ?? null;
    }
    
    /* Cách 2: nếu URL không có uid, dò trong HTML (liên kết/label/input) */
    if (!$uid && preg_match('/[?&]uid=(\d+)/i', $body, $m)) {
        $uid = $m[1];
    }
    if (!$uid && preg_match('/\bUID\s*=\s*(\d+)/i', $body, $m)) {
        $uid = $m[1];
    }
    if (!$uid && preg_match('/\bUid:\s*(\d+)/i', $body, $m)) {
        $uid = $m[1];
    }
    if (!$uid && preg_match('/name=["\']?uid["\']?.*?value=["\']?(\d+)/i', $body, $m)) {
        $uid = $m[1];
    }
    
    if ($uid) {
        return [
            'uid' => $uid,
        ];
    } else {
        return [
            'uid' => $uid,
        ];
    }

}

function userhquid($url, $uid, $qid, $cookie) {
    // 第一次请求获取用户列表页面
    $ch = curl_init($url);
    $post = array(
        "session_key" => $uid,
        "exact" => "1",
        "zone" => $qid,
    );
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch) || $httpCode !== 200) {
        curl_close($ch);
        return false; // 请求失败
    }
    curl_close($ch);

    // 解析提取用户详情页链接
    $linkPattern = '/<a\s+href="([^"]*uid_zone=[^"]*)"/i';
    if (!preg_match($linkPattern, $response, $linkMatches)) {
        return false; // 未找到链接
    }
    
    $detailUrl = html_entity_decode($linkMatches[1]); // 解码HTML实体

    // 第二次请求获取用户详情页
    $chDetail = curl_init($detailUrl);
    curl_setopt($chDetail, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($chDetail, CURLOPT_COOKIE, $cookie);
    curl_setopt($chDetail, CURLOPT_FOLLOWLOCATION, true); // 跟随重定向userhquid
    
    $detailResponse = curl_exec($chDetail);
    $detailCode = curl_getinfo($chDetail, CURLINFO_HTTP_CODE);
    
    if (curl_errno($chDetail) || $detailCode !== 200) {
        curl_close($chDetail);
        return false; // 详情页请求失败
    }
    curl_close($chDetail);

    // 解析提取UID值
    $uidValue = false;
    $longUidValue = false;
    
    // 匹配普通UID
    if (preg_match('/<td[^>]*>\s*Uid\s*<\/td>\s*<td[^>]*>\s*(\d+)\s*<\/td>/is', $detailResponse, $uidMatches)) {
        $uidValue = $uidMatches[1];
    }
    
    // 匹配长UID - 改进后的正则表达式
    if (preg_match('/<td[^>]*>\s*长UID\s*<\/td>\s*<td[^>]*>\s*(\d+)\s*<\/td>/is', $detailResponse, $longMatches)) {
        $longUidValue = $longMatches[1];
    } 
    // 第二种可能的匹配模式（针对不同HTML结构）
    elseif (preg_match('/<td[^>]*>\s*长UID\s*<\/td>\s*<td[^>]*>[\s\S]*?(\d+)[\s\S]*?<\/td>/is', $detailResponse, $longMatches)) {
        $longUidValue = $longMatches[1];
    }
    
    // 如果长UID仍然未找到，尝试更宽松的匹配
    if ($longUidValue === false) {
        if (preg_match('/长UID[^<]*<\/td>\s*<td[^>]*>\s*(\d+)\s*<\/td>/i', $detailResponse, $longMatches)) {
            $longUidValue = $longMatches[1];
        }
    }

    // 返回两种UID值
    return [
        'uid' => $uidValue,
        'long_uid' => $longUidValue
    ];
}

function getPendingGifts($url,$cookies = '', $timeout = 10, $verifySSL = false) {
    $result = [
        'status' => false,
        'code' => 0,
        'data' => null,
        'error' => null,
        'gift_id' => null
    ];

    $ch = null;
    try {
        // 目标URL
        $targetUrl = $url;
        
        $ch = curl_init();
        $options = [
            CURLOPT_URL => $targetUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_SSL_VERIFYPEER => $verifySSL,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8'
            ],
        ];

        // 确保正确传递Cookie
        if (!empty($cookies)) {
            $options[CURLOPT_COOKIE] = $cookies;
        }

        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $errorNo = curl_errno($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (!$errorNo && $httpCode == 200 && $response) {
            $result['status'] = true;
            $result['code'] = $httpCode;
            $result['data'] = $response;
            
            // 超简单提取方法：取第一个表格行的第一个数字ID
            $pattern = '/<tr>\s*<td>\s*(\d+)\s*<\/td>/';
            if (preg_match($pattern, $response, $matches)) {
                $result['gift_id'] = $matches[1];
            }
        } else if (!$errorNo) {
            $result['error'] = "HTTP状态码: $httpCode";
        } else {
            $result['error'] = curl_error($ch);
        }
    } catch (Exception $e) {
        $result['error'] = 'Exception: ' . $e->getMessage();
    } finally {
        if (is_resource($ch)) {
            curl_close($ch);
        }
    }

    return $result;
}

function sendMail($url, $formData, $cookies = '', $timeout = 10, $verifySSL = false) {
    $result = [
        'status' => false,
        'code' => 0,
        'data' => null,
        'error' => null
    ];

    $ch = null;
    try {
        $ch = curl_init();
        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($formData),
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_SSL_VERIFYPEER => $verifySSL,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8'
            ],
        ];

        // 如果有 cookie，则加入 CURLOPT_COOKIE
        if (!empty($cookies)) {
            $options[CURLOPT_COOKIE] = $cookies;  // 直接传入cookie字符串
        }

        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        $errorNo = curl_errno($ch);

        if (!$errorNo) {
            $result['status'] = true;
            $result['code'] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $result['data'] = $response;
        } else {
            $result['error'] = curl_error($ch);
        }
    } catch (Exception $e) {
        $result['error'] = 'Exception: ' . $e->getMessage();
    } finally {
        if (is_resource($ch)) {
            curl_close($ch);
        }
    }

    return $result;
}

?>
