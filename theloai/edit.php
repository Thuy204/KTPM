<?php
// Bao gồm các phần header và kết nối đến CSDL
include '../view/head.php';
require_once '../config/db.php';

// Biến để lưu thông tin thể loại từ CSDL
$row = [];

// Kiểm tra nếu có id được truyền qua URL (chế độ chỉnh sửa)
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Truy vấn để lấy thông tin thể loại có theloai_id tương ứng
    $query = "SELECT * FROM theloai WHERE theloai_id = '$id'";
    $result = mysqli_query($conn, $query);

    // Kiểm tra kết quả truy vấn và lưu vào biến $row
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Không tìm thấy thông tin thể loại";
    }
}

// Xử lý khi form chỉnh sửa được submit
if (isset($_POST['sua_theloai'])) {
    $id = $_POST['theloai_id'];
    $ten = $_POST['ten_theloai'];
    $thongtin = $_POST['thongtin_theloai'];

    // Truy vấn update dữ liệu vào CSDL
    $query_update = "UPDATE theloai SET ten_theloai = '$ten', thongtin_theloai = '$thongtin' WHERE theloai_id = '$id'";
    $result_update = mysqli_query($conn, $query_update);

    // Kiểm tra kết quả và thông báo cho người dùng
    if ($result_update) {
        echo "<script type='text/javascript'>
                alert('Cập nhật dữ liệu thành công!');
                window.location.href='read.php';
              </script>";
    } else {
        echo "Lỗi cập nhật thông tin: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa Thể loại</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container" style="justify-content: center; margin-top: 50px;">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>ID</label>
                <input type="number" name="theloai_id" placeholder="Enter ID" class="form-control" 
                       value="<?php echo isset($row['theloai_id']) ? $row['theloai_id'] : ''; ?>" readonly>
                <label>Tên</label>
                <input type="text" name="ten_theloai" placeholder="Enter Tên" class="form-control"
                       value="<?php echo isset($row['ten_theloai']) ? $row['ten_theloai'] : ''; ?>">
                <label>Thông tin</label>
                <input type="text" name="thongtin_theloai" placeholder="Enter Thông tin" class="form-control"
                       value="<?php echo isset($row['thongtin_theloai']) ? $row['thongtin_theloai'] : ''; ?>">
            </div>
            <input type="submit" class="btn btn-success" style="margin: 10px" name="sua_theloai" value="CẬP NHẬT">
            <a href="read.php" class="btn btn-warning">HỦY</a>
        </form>
    </div>
    <!-- Bootstrap JS và các thư viện khác -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
