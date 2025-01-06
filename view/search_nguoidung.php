<?php
    include '../frontend/head.php';
    include '../config/db.php';
?>
<?php
    if (isset($_POST['timkiem'])) {
        $timnguoidung = $_POST['tim_nguoidung'];
    }
?>
<div class="container">
    <h4>Kết quả tìm kiếm:</h4>
    <table class="table table-striped table-hover">
        <thead>
            <th>STT</th>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Vai trò</th>
        </thead>
        <tbody>
<?php
    $query = "SELECT * FROM nguoidung WHERE ten_nguoidung LIKE '%$timnguoidung%'";
    $result = mysqli_query($conn, $query);
    if (!$result || mysqli_num_rows($result) == 0) {
        echo "<tr><td colspan='6'>Không tìm thấy thông tin!</td></tr>";
    } else {
        $num = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "
                <tr>
                    <td>" . ($num++) . "</td>
                    <td>" . $row["id_nguoidung"] . "</td>
                    <td>" . $row["ten_nguoidung"] . "</td>
                    <td>" . $row["email_nguoidung"] . "</td>
                    <td>" . $row["matkhau_nguoidung"] . "</td>
                    <td>" . ($row["vaitro_nguoidung"] == 1 ? 'Sinh viên' : 'Nhân viên') . "</td>
                </tr>";
        }
    }
?>
        </tbody>
    </table>
    <a href="../view/nguoidung_view.php" class="btn btn-warning">Quay lại</a>
</div>
