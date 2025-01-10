<?php
    include '../frontend/head.php';
    include '../config/db.php';
?>
<?php
    if(isset($_POST['timkiem'])){
        $timsach = $_POST['tim_sach'];
    }
?>
<div class="container">
    <h4>Kết quả tìm kiếm:</h4>
    <table class="table table-striped table-hover">
        <thead>
        <th>STT</th>
            <th>ID Sách</th>
            <th>Tên Sách</th>
            <th>Tác Giả</th>
            <th>Nhà Xuất Bản</th>
            <th>Thể Loại</th>
            <th>Mô Tả</th>
            <th>Số Lượng Tồn Kho</th>
        </thead>
        <tbody>
<?php
    $query = "SELECT sach.sach_id, sach.ten_sach, tacgia.ten_tacgia, theloai.ten_theloai, nhaxuatban.ten_nxb, sach.soluong_tonkho, sach.mota_sach
              FROM sach
              LEFT JOIN tacgia ON sach.tacgia_id = tacgia.tacgia_id
              LEFT JOIN theloai ON sach.theloai_id = theloai.theloai_id
              LEFT JOIN nhaxuatban ON sach.nxb_id = nhaxuatban.nxb_id
              WHERE sach.ten_sach LIKE '%$timsach%'";
    $result = mysqli_query($conn, $query);
    if (!$result || mysqli_num_rows($result) == 0) {
        echo "Không tìm thấy thông tin!";
    } else {
        $num = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "
                <tr>
                    <td>" . ($num++) . "</td>
                    <td>" . $row["sach_id"] . "</td>
                    <td>" . $row["ten_sach"] . "</td>
                    <td>" . $row["ten_tacgia"] . "</td>
                    <td>" . $row["ten_nxb"] . "</td>
                    <td>" . $row["ten_theloai"] . "</td>
                    <td>" . $row["mota_sach"] . "</td>
                    <td>" . $row["soluong_tonkho"] . "</td>
                </tr>";
        }
        echo "</tbody>
            </table>";
    }
?>
<a href="sach_view.php" class="btn btn-warning">Quay lại</a>
</div>
