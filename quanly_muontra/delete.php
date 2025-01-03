<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qly_thuvien";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $muontra_id = $_GET['id'];

    // Xóa chi tiết mượn trả
    $sql = "DELETE FROM ctmuontra WHERE muontra_id = '$muontra_id'";
    if ($conn->query($sql) === TRUE) {
        // Xóa bản ghi mượn trả
        $sql = "DELETE FROM muontra WHERE muontra_id = '$muontra_id'";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success' role='alert'>Xóa thông tin mượn trả thành công!</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Lỗi: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Lỗi: " . $conn->error . "</div>";
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>Không tìm thấy ID mượn trả!</div>";
}
$conn->close();
?>
<body>
<div class="container mt-5">
    <h2>Xóa mượn trả sách</h2>
    <a href="muontra.php" class="btn btn-primary">Trở về trang chủ</a>
</div>
</body>
</html>
