<?php
include '../frontend/head.php'; // Bao gồm phần đầu trang
include '../config/db.php'; // Kết nối cơ sở dữ liệu

$timtacgia = ''; // Khởi tạo biến để lưu từ khóa tìm kiếm

if (isset($_POST['timkiem'])) {
    $timtacgia = $_POST['tim_tacgia']; // Lấy từ khóa tìm kiếm từ form POST
}
?>
<div class="container">
    <h4>Kết quả tìm kiếm:</h4>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>ID</th>
                <th>Tên</th>
                <th>Giới tính</th>
                <th>Thông tin</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Truy vấn để lấy danh sách tác giả có tên chứa từ khóa tìm kiếm
        $query = "SELECT * FROM tacgia WHERE ten_tacgia LIKE '%$timtacgia%'";
        $result = mysqli_query($conn, $query);

        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<tr><td colspan='6' class='text-center'>Không tìm thấy thông tin!</td></tr>";
        } else {
            $num = 1; // Biến đếm số thứ tự
            while ($row = mysqli_fetch_array($result)) {
                echo "
                    <tr>
                        <td>" . ($num++) . "</td>
                        <td>" . $row["tacgia_id"] . "</td>
                        <td>" . $row["ten_tacgia"] . "</td>
                        <td>" . ($row["gioitinh_tacgia"] == 1 ? 'Nam' : 'Nữ') . "</td>
                        <td>" . $row["thongtin_tacgia"] . "</td>
                    </tr>";
            }
        }
        ?>
        </tbody>
    </table>
    <a href="../view/tacgia_view.php" class="btn btn-warning">Quay lại</a>
</div>
