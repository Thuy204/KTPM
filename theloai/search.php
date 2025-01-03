<?php
include '../view/head.php';
include '../config/db.php';

if (isset($_POST['timkiem'])) {
    $timtheloai = $_POST['tim_theloai'];
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
                <th>Thông tin</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (isset($timtheloai)) {
            $query = "SELECT * FROM theloai WHERE ten_theloai LIKE '%$timtheloai%'";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                echo "<tr><td colspan='4'>Không tìm thấy thông tin!</td></tr>";
            } else {
                $num = 1;
                while ($row = mysqli_fetch_array($result)) {
                    echo "
                    <tr>
                        <td>" . ($num++) . "</td>
                        <td>" . $row["theloai_id"] . "</td>
                        <td>" . $row["ten_theloai"] . "</td>
                        <td>" . $row["thongtin_theloai"] . "</td>
                    </tr>";
                }
            }
        }
        ?>
        </tbody>
    </table>
    <a href="read.php" class="btn btn-warning">Quay lại</a>
</div>
