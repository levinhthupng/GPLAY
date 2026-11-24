<?php
include('../config.php'); // Thay thế bằng file kết nối cơ sở dữ liệu của bạn

$result = mysqli_query($ketnoi,"SELECT * FROM `users` ORDER BY id desc"); // Thay thế bằng truy vấn của bạn


$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>
