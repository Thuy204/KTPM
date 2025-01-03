<?php
include '../config/db.php';

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $muontra_id = $_GET['id'];

    // Lấy thông tin mượn trả
    $sql = "SELECT muontra.*, docgia.ten_docgia FROM muontra 
            LEFT JOIN docgia ON muontra.docgia_id = docgia.docgia_id 
            WHERE muontra.muontra_id = '$muontra_id'";
    $result = $conn->query($sql);
    $muontra = $result->fetch_assoc();

    // Lấy chi tiết sách mượn
    $sql = "SELECT * FROM ctmuontra WHERE muontra_id = '$muontra_id'";
    $ctmuontra_result = $conn->query($sql);
    $ctmuontra = [];
    while ($row = $ctmuontra_result->fetch_assoc()) {
        $ctmuontra[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $muontra_id = $_POST['muontra_id'];
    $ten_docgia = $_POST['ten_docgia'];
    $ngaymuon = $_POST['ngaymuon'];
    $hantra = $_POST['hantra'];
    $ten_sach = $_POST['ten_sach'];
    $soluongs = $_POST['soluong'];

    // Lấy ID của độc giả dựa trên tên
    $docgia_result = $conn->query("SELECT docgia_id FROM docgia WHERE ten_docgia = '$ten_docgia'");
    if ($docgia_result->num_rows > 0) {
        $docgia_id = $docgia_result->fetch_assoc()['docgia_id'];

        // Cập nhật bảng muontra
        $sql = "UPDATE muontra SET docgia_id = '$docgia_id', ngaymuon = '$ngaymuon', hantra = '$hantra'
                WHERE muontra_id = '$muontra_id'";
        $conn->query($sql);

        // Xóa chi tiết mượn trả cũ
        $conn->query("DELETE FROM ctmuontra WHERE muontra_id = '$muontra_id'");

        // Thêm chi tiết mượn trả mới
        foreach ($ten_sach as $index => $ten_sach_item) {
            $soluong = $soluongs[$index];
            $sach_result = $conn->query("SELECT sach_id FROM sach WHERE ten_sach = '$ten_sach_item'");
            if ($sach_result->num_rows > 0) {
                $sach_id = $sach_result->fetch_assoc()['sach_id'];
                $sql_ct = "INSERT INTO ctmuontra (muontra_id, sach_id, ten_sach, soluong_ctmt)
                           VALUES ('$muontra_id', '$sach_id', '$ten_sach_item', '$soluong')";
                $conn->query($sql_ct);
            }
        }

        // Chuyển hướng về trang muontra.php
        header("Location: muontra.php");
        exit();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Không tìm thấy độc giả!</div>";
    }
}
?>

<?php include '../view/head.php'; ?>
<body>
<div class="container mt-5">
    <div class="form-container">
        <h2 class="text-center">Chỉnh sửa mượn trả sách</h2>
        <form method="POST">
            <input type="hidden" name="muontra_id" value="<?php echo $muontra['muontra_id']; ?>">
            <div class="mb-3">
                <label for="ten_docgia" class="form-label">Tên Độc Giả</label>
                <input type="text" class="form-control" id="ten_docgia" name="ten_docgia" value="<?php echo $muontra['ten_docgia']; ?>" required />
            </div>
            <div class="mb-3">
                <label for="ngaymuon" class="form-label">Ngày Mượn</label>
                <input type="date" class="form-control" id="ngaymuon" name="ngaymuon" value="<?php echo $muontra['ngaymuon']; ?>" required />
            </div>
            <div class="mb-3">
                <label for="hantra" class="form-label">Hạn Trả</label>
                <input type="date" class="form-control" id="hantra" name="hantra" value="<?php echo $muontra['hantra']; ?>" required />
            </div>
            <div class="mb-3">
                <div id="book_fields">
                    <?php foreach ($ctmuontra as $ct): ?>
                        <div class="row mb-2">
                            <div class="col">
                                <label for="ten_sach" class="form-label">Tên Sách</label>
                                <input type="text" class="form-control" name="ten_sach[]" value="<?php echo $ct['ten_sach']; ?>" required />
                            </div>
                            <div class="col">
                                <label for="soluong" class="form-label">Số Lượng</label>
                                <input type="number" class="form-control" name="soluong[]" value="<?php echo $ct['soluong_ctmt']; ?>" required />
                            </div>
                        </div>
                    <?php endforeach; ?>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="muontra.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</div>
</body>
</html>
