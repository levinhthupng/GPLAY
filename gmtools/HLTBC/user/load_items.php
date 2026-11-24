<?php
// Đường dẫn đến file item.txt
$file_path = 'item.txt';

// Kiểm tra nếu file tồn tại
if (file_exists($file_path)) {
    $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $options = '';
    foreach ($lines as $line) {
        $line = trim($line);
        $txts = explode(';', $line);

        if (count($txts) === 2) {
            $options .= '<option value="' . htmlspecialchars($txts[0]) . '">' . htmlspecialchars($txts[1]) . '</option>';
        }
    }

    echo $options; // Trả về danh sách <option>
} else {
    echo '<option value="">File not found</option>';
}
?>