<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Kiểm tra id có hợp lệ hay không
    if (!empty($id) && is_numeric($id)) {
        // Sử dụng prepared statement để tránh SQL Injection
        $query = "DELETE FROM nhaxuatban WHERE nxb_id = ?";
        
        if ($stmt = $conn->prepare($query)) {
            // Liên kết tham số và thực thi câu lệnh
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                // Xóa thành công, chuyển hướng về trang danh sách
                header('Location: index.php');
                exit();
            } else {
                // Lỗi khi xóa
                echo "Lỗi xóa dữ liệu.";
            }
            // Đóng statement
            $stmt->close();
        } else {
            echo "Lỗi chuẩn bị câu lệnh SQL.";
        }
    } else {
        echo "ID không hợp lệ.";
    }
} else {
    echo "Không có ID được cung cấp.";
}

// Đóng kết nối
$conn->close();
?>
