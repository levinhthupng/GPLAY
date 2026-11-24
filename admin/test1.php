<?php

// Đường dẫn đến file txt chứa đoạn mã
$file_path = 'file.txt';

$file = fopen($file_path, "r");

// Lặp qua từng dòng trong file
while (!feof($file)) {
    // Đọc một dòng từ file
    $line = fgets($file);

    // Tách các giá trị trong dòng đó thành mảng con dựa trên dấu chấm phẩy
    $values = explode(";", $line);

    // Lấy số và chuỗi từ mảng $values
    $number = $values[0];
    $string = $values[1];

    // In số và chuỗi ra màn hình nếu số bằng 11 và chuỗi là "Bánh Bao (Nhỏ)"
    
        echo "$number ;";
        echo "$string </br>";
    
}

// Đóng file
fclose($file);

?>