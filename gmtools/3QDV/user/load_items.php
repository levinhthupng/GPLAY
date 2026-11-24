<?php
$file_path = 'item.txt'; // Đường dẫn file
// Kiểm tra nếu file tồn tại
if (file_exists($file_path)) {
    $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Duyệt qua các dòng và xử lý
    foreach ($lines as $line) {
        $line = trim($line); // Loại bỏ ký tự thừa
        $txts = explode('|', $line);

        if (count($txts) === 2) {
            echo '<option value="' . htmlspecialchars($txts[0]) . '">' . htmlspecialchars($txts[1]) . '</option>';
        }
    }
} else {
    // Trả về thông báo lỗi nếu không tìm thấy file
    echo '<option value="">File not found</option>';
}
?>