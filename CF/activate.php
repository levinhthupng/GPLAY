<?php
// activate.php – MOCK server gốc
// Trả JSON 200 OK, KHÔNG redirect

header('Content-Type: application/json; charset=utf-8');
http_response_code(200);

// Lấy MAC từ URL
// /CF/activate.php/08-BF-B8-06-8A-E4
$uri = $_SERVER['REQUEST_URI'];
$parts = explode('/', trim($uri, '/'));
$mac = end($parts);

// Validate MAC đơn giản
if (!$mac || strlen($mac) < 10) {
    echo json_encode([
        "error" => "INVALID_MAC"
    ]);
    exit;
}

// Thời gian ISO giống server thật
$time = date('Y-m-d\TH:i:s.007');

// ===== RESPONSE GIỐNG SERVER GỐC =====
$response = [
    "mac"       => strtoupper($mac),
    "name"      => "G100K-HK20 - 171.225.170.212 - -",
    "starttime" => $time,
    "endtime"   => $time,
    "active"    => 1, // 1 = active, 0 = inactive
    "ver"       => "FULL-AR-24-11-25-v1",
    "rada"      => null
];

// Trả JSON (KHÔNG pretty để giống server thật)
echo json_encode($response, JSON_UNESCAPED_UNICODE);
