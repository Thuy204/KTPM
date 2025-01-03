<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Lấy thông tin nhà xuất bản từ CSDL
    $query = "SELECT * FROM nhaxuatban WHERE nxb_id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "Không có dữ liệu";
            exit();
        }
    } else {
        echo "Lỗi chuẩn bị câu lệnh SQL.";
        exit();
    }
}

// Kiểm tra và xử lý khi người dùng nhấn nút "UPDATE"
if (isset($_POST['sua_nxb'])) {
    $ten = $_POST['ten_nxb'];
    $sl = $_POST['thongtin_nxb'];
    $hinhanh = $_POST['hinhanh_nxb'];

    // Kiểm tra dữ liệu đầu vào
    if (empty($ten) || empty($sl)) {
        echo "Vui lòng điền đầy đủ thông tin.";
    } else {
        // Sử dụng prepared statement để tránh SQL Injection
        $query = "UPDATE nhaxuatban SET ten_nxb = ?, thongtin_nxb = ?, hinhanh_nxb = ? WHERE nxb_id = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("sssi", $ten, $sl, $hinhanh, $id);
            if ($stmt->execute()) {
                echo "<script type='text/javascript'>
                        alert('Cập nhật dữ liệu thành công!');
                        window.location.href='index.php';
                    </script>";
            } else {
                echo "Lỗi cập nhật dữ liệu.";
            }
        } else {
            echo "Lỗi chuẩn bị câu lệnh SQL.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin nhà xuất bản</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
    <link rel="stylesheet" href="../view/style.css">
</head>
<body>
    <div class="edit">
        <div class="container" style="justify-content: center;">
            <form method="POST">
                <h3 class="text-center mt-2 mb-3">Sửa thông tin nhà xuất bản</h3>
                <div class="mt-2 mb-3">
                    <label>ID</label>
                    <input type="number" name="id_nxb" class="form-control" value="<?php echo isset($row['nxb_id']) ? $row['nxb_id'] : ''; ?>" disabled>
                </div>
                <div class="mt-2 mb-3">
                    <label>Tên</label>
                    <input type="text" name="ten_nxb" class="form-control" value="<?php echo isset($row['ten_nxb']) ? $row['ten_nxb'] : ''; ?>" required>
                </div>
                <div class="mt-2 mb-3">
                    <label>Thông tin</label>
                    <input type="number" name="thongtin_nxb" class="form-control" value="<?php echo isset($row['thongtin_nxb']) ? $row['thongtin_nxb'] : ''; ?>" required>
                </div>
                <div class="mt-2 mb-3">
                    <label>Hình ảnh</label>
                    <input type="text" name="hinhanh_nxb" class="form-control" value="<?php echo isset($row['hinhanh_nxb']) ? $row['hinhanh_nxb'] : ''; ?>" placeholder="Nhập URL hình ảnh">
                </div>
                <div class="text-center mb-2">
                    <a href="index.php" class="btn btn-secondary">HỦY</a>
                    <input type="submit" class="btn btn-success" name="sua_nxb" value="Cập nhật">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
