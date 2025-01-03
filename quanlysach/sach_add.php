<?php
include '../config/db.php';

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_sach = $_POST['ten_sach'];
    $tacgia_id = $_POST['tacgia_id'];
    $theloai_id = $_POST['theloai_id'];
    $nxb_id = $_POST['nxb_id'];
    $mota_sach = $_POST['mota_sach'];
    $soluong_tonkho = $_POST['soluong_tonkho'];
    $ngaytao = date('Y-m-d');

    $sql = "INSERT INTO sach (ten_sach, tacgia_id, theloai_id, nxb_id, mota_sach, soluong_tonkho, ngaytao)
            VALUES ('$ten_sach', '$tacgia_id', '$theloai_id', '$nxb_id', '$mota_sach', '$soluong_tonkho', '$ngaytao')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success' role='alert'>Thêm sách thành công!</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Lỗi: " . $conn->error . "</div>";
    }
}

// Lấy danh sách tác giả
$tacgia_result = $conn->query("SELECT tacgia_id, ten_tacgia FROM tacgia");
$theloai_result = $conn->query("SELECT theloai_id, ten_theloai FROM theloai");
$nxb_result = $conn->query("SELECT nxb_id, ten_nxb FROM nhaxuatban");
?>

<?php include '../view/head.php'; ?>

<body>
<div class="container mt-5">
    <div class="form-container">
        <h2 class="text-center">Thêm sách mới</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="ten_sach" class="form-label">Tên Sách</label>
                <input type="text" class="form-control" id="ten_sach" name="ten_sach" placeholder="Tên Sách" required />
            </div>
            <div class="mb-3">
                <label for="tacgia_id" class="form-label">Tác Giả</label>
                <select class="form-control" id="tacgia_id" name="tacgia_id" required>
                    <option value="">Chọn tác giả</option>
                    <?php while ($row = $tacgia_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['tacgia_id']; ?>"><?php echo $row['ten_tacgia']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="theloai_id" class="form-label">Thể Loại</label>
                <select class="form-control" id="theloai_id" name="theloai_id" required>
                    <option value="">Chọn thể loại</option>
                    <?php while ($row = $theloai_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['theloai_id']; ?>"><?php echo $row['ten_theloai']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nxb_id" class="form-label">Nhà Xuất Bản</label>
                <select class="form-control" id="nxb_id" name="nxb_id" required>
                    <option value="">Chọn nhà xuất bản</option>
                    <?php while ($row = $nxb_result->fetch_assoc()): ?>
                        <option value="<?php echo $row['nxb_id']; ?>"><?php echo $row['ten_nxb']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="mota_sach" class="form-label">Mô Tả</label>
                <textarea class="form-control" id="mota_sach" name="mota_sach" placeholder="Mô Tả"></textarea>
            </div>
            <div class="mb-3">
                <label for="soluong_tonkho" class="form-label">Số Lượng Tồn Kho</label>
                <input type="number" class="form-control" id="soluong_tonkho" name="soluong_tonkho" placeholder="Số Lượng Tồn Kho" required />
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="sach.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</div>
</body>
</html>
