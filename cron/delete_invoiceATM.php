<?php
declare(strict_types=1);
require_once('../config.php'); // phải khởi tạo $ketnoi (mysqli)

header('Content-Type: application/json; charset=utf-8');

// --- Tham số ---
$defaultGraceMinutes = 5;
$grace = isset($_GET['grace']) ? (int)$_GET['grace'] : $defaultGraceMinutes;
if ($grace < 1 || $grace > 120) $grace = $defaultGraceMinutes;

$dryRun = isset($_GET['dry']) ? ((string)$_GET['dry'] === '1') : false;

$out = [
    'success' => false,
    'deleted_count' => 0,
    'deleted_ids' => [],
    'skipped_ids' => [],
    'message' => '',
    'meta' => [
        'grace_minutes' => $grace,
        'now' => date('Y-m-d H:i:s'),
        'dry_run' => $dryRun,
    ],
];

if (!isset($ketnoi) || !($ketnoi instanceof mysqli)) {
    http_response_code(500);
    $out['message'] = 'Database connection is not available.';
    echo json_encode($out, JSON_UNESCAPED_UNICODE);
    exit;
}

// (tuỳ chọn) đặt chế độ kiểm cách ly phù hợp
// $ketnoi->query("SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED");

// Bắt đầu transaction để tránh race-condition
$ketnoi->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);

try {
    $status = 'xuly';

    // Khoá các dòng cần xét để đảm bảo nhất quán
    $sqlLock = "SELECT id, request_id, `time` FROM `bank_auto` WHERE `status` = ? FOR UPDATE";
    $stmt = $ketnoi->prepare($sqlLock);
    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $ketnoi->error);
    }
    $stmt->bind_param('s', $status);
    if (!$stmt->execute()) {
        throw new Exception('Execute failed: ' . $stmt->error);
    }

    // Dùng bind_result để tương thích môi trường không có mysqlnd (tránh get_result()).
    $stmt->bind_result($id, $request_id, $timeStr);

    $now = time();
    $toDelete = [];
    $skipped = [];

    // Hàm parse thời gian an toàn (thử nhiều format)
    $parseTime = static function (?string $raw) : ?int {
        if ($raw === null) return null;
        $raw = trim((string)$raw);
        if ($raw === '') return null;

        // 1) strtotime thẳng
        $ts = strtotime($raw);
        if ($ts !== false) return $ts;

        // 2) d-m-Y H:i:s
        $dt = DateTime::createFromFormat('d-m-Y H:i:s', $raw);
        if ($dt !== false) return $dt->getTimestamp();

        // 3) Y-m-d H:i:s
        $dt = DateTime::createFromFormat('Y-m-d H:i:s', $raw);
        if ($dt !== false) return $dt->getTimestamp();

        // 4) ISO 8601
        $dt = DateTime::createFromFormat(DateTime::ATOM, $raw);
        if ($dt !== false) return $dt->getTimestamp();

        return null;
    };

    while ($stmt->fetch()) {
        $rowId = (int)$id;
        $ts = $parseTime($timeStr);

        if ($ts === null) {
            $skipped[] = ['id' => $rowId, 'reason' => 'invalid_time', 'time_raw' => (string)$timeStr];
            continue;
        }

        $deadline = $ts + ($grace * 60);

        if ($now >= $deadline) {
            $toDelete[] = $rowId;
        } else {
            $skipped[] = [
                'id' => $rowId,
                'reason' => 'not_due',
                'not_before' => date('Y-m-d H:i:s', $deadline),
                'seconds_left' => max(0, $deadline - $now),
            ];
        }
    }
    $stmt->close();

    if (empty($toDelete)) {
        $out['success'] = true;
        $out['message'] = 'Không có hoá đơn quá hạn cần xoá.';
        $out['skipped_ids'] = $skipped;
        $ketnoi->commit();
        echo json_encode($out, JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($dryRun) {
        $out['success'] = true;
        $out['message'] = 'Dry-run: các id dưới đây sẽ bị xoá nếu chạy thật.';
        $out['deleted_count'] = count($toDelete);
        $out['deleted_ids'] = array_values($toDelete);
        $out['skipped_ids'] = $skipped;
        $ketnoi->commit(); // nhả khoá
        echo json_encode($out, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Xoá theo lô để tránh gói quá lớn
    $deletedAll = 0;
    $chunkSize = 500;

    for ($i = 0, $n = count($toDelete); $i < $n; $i += $chunkSize) {
        $chunk = array_slice($toDelete, $i, $chunkSize);

        // Tạo placeholders cho IN (...)
        $placeholders = implode(',', array_fill(0, count($chunk), '?'));
        // Kiểu dữ liệu: tất cả id là int, thêm 1 's' cho status ở cuối
        $types = str_repeat('i', count($chunk)) . 's';

        $sqlDel = "DELETE FROM `bank_auto` WHERE `id` IN ($placeholders) AND `status` = ?";
        $stmtDel = $ketnoi->prepare($sqlDel);
        if (!$stmtDel) {
            throw new Exception('Prepare delete failed: ' . $ketnoi->error);
        }

        // bind_param cần THAM CHIẾU
        $params = [];
        $params[] = &$types;

        // Đảm bảo phần tử là biến độc lập (tránh tham chiếu tới mảng con có thể gây cảnh báo trên một số bản PHP)
        $bindValues = [];
        foreach ($chunk as $val) {
            $iv = (int)$val;
            $bindValues[] = $iv; // giữ biến riêng
        }
        // đẩy tham chiếu các biến vào params
        foreach ($bindValues as $k => $v) {
            $params[] = &$bindValues[$k];
        }

        $statusParam = $status;
        $params[] = &$statusParam;

        // Gọi bind_param động
        if (!call_user_func_array([$stmtDel, 'bind_param'], $params)) {
            throw new Exception('bind_param failed (delete): ' . $stmtDel->error);
        }

        if (!$stmtDel->execute()) {
            throw new Exception('Execute delete failed: ' . $stmtDel->error);
        }

        // affected_rows trả số hàng xoá trong lô này
        $deletedAll += max(0, $stmtDel->affected_rows);
        $stmtDel->close();
    }

    $ketnoi->commit();

    $out['success'] = true;
    $out['message'] = 'Xoá bulk thành công.';
    $out['deleted_count'] = $deletedAll;
    $out['deleted_ids'] = array_values($toDelete);
    $out['skipped_ids'] = $skipped;

    echo json_encode($out, JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    // Nếu connection đã chết, rollback có thể phát sinh warning — bọc lại cho an toàn
    try { $ketnoi->rollback(); } catch (\Throwable $ignore) {}
    http_response_code(500);
    $out['message'] = 'Error: ' . $e->getMessage();
    echo json_encode($out, JSON_UNESCAPED_UNICODE);
}
