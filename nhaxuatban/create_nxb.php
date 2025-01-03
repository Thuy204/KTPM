<?php
require_once '../config/db.php';

if (isset($_POST['them_nxb'])) {
    // Lấy dữ liệu từ form
    $id = trim($_POST['id_nxb']);
    $ten = trim($_POST['ten_nxb']);
    $tt = trim($_POST['thongtin_nxb']);
    $img = trim($_POST['hinhanh_nxb']);
    
    // Kiểm tra dữ liệu đầu vào
    if (empty($id) || empty($ten) || empty($tt) || empty($img)) {
        echo "Tất cả các trường đều phải được điền.";
        exit();
    }

    // Sử dụng prepared statement để tránh SQL Injection
    $query = "INSERT INTO nhaxuatban (nxb_id, ten_nxb, thongtin_nxb, hinhanh_nxb) VALUES (?, ?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        // Liên kết tham số với câu truy vấn
        $stmt->bind_param("ssss", $id, $ten, $tt, $img);
        
        // Thực thi câu truy vấn
        if ($stmt->execute()) {
            header('Location: index.php');
        } else {
            echo "Đã xảy ra lỗi khi thêm dữ liệu.";
        }
        // Đóng statement
        $stmt->close();
    } else {
        echo "Lỗi chuẩn bị câu lệnh SQL.";
    }
}

// Đóng kết nối
$conn->close();
?>
