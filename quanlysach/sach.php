
<?php
include '../config/db.php';

// Tìm kiếm sách
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}
?>

<?php include '../view/head.php'; ?>

<div class="container mt-5">
    <h2>Quản lý sách</h2>
    <div class="">
        <form class="d-inline-flex" method="GET">
            <input class="form-control me-2" type="text" name="search" placeholder="Tìm kiếm theo tên sách" value="<?php echo htmlspecialchars($search_query); ?>">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
        </form>
        <a href="sach_add.php" class="btn btn-success">Thêm Sách</a>
    </div>
    <h3>Danh sách sách</h3>
    <table class="table table-bordered">
        <thead>
            
        
            <th>STT</th>
            <th>Mã Sách</th>
            <th>Tên Sách</th>
            <th>Thông Tin</th>
            <th>Tác Giả</th>
            <th>Thể Loại</th>
            <th>Nhà Xuất Bản</th>
            <th>Số lượng tồn kho</th>
            <th>Ngày Tạo</th>
            <th>Hành Động</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT sach.sach_id, sach.ten_sach, sach.mota_sach, tacgia.ten_tacgia, theloai.ten_theloai, nhaxuatban.ten_nxb, sach.soluong_tonkho, sach.ngaytao
                FROM sach
                LEFT JOIN tacgia ON sach.tacgia_id = tacgia.tacgia_id
                LEFT JOIN theloai ON sach.theloai_id = theloai.theloai_id
                LEFT JOIN nhaxuatban ON sach.nxb_id = nhaxuatban.nxb_id";

        if ($search_query != "") {
            $sql .= " WHERE sach.ten_sach LIKE '%$search_query%'";
        }

        $result = $conn->query($sql);
        $stt = 1;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $stt++ . "</td>
                        <td>" . $row["sach_id"] . "</td>
                        <td>" . $row["ten_sach"] . "</td>
                        <td>" . $row["mota_sach"] . "</td>
                        <td>" . $row["ten_tacgia"] . "</td>
                        <td>" . $row["ten_theloai"] . "</td>
                        <td>" . $row["ten_nxb"] . "</td>
                        <td>" . $row["soluong_tonkho"] . "</td>
                        <td>" . $row["ngaytao"] . "</td>
                        <td>
                            <a href='sach_edit.php?id=" . $row["sach_id"] . "' class='btn btn-primary'><i class='bi bi-pencil-square'></i> Sửa</a>
                         
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='10' class='text-center'>Không có dữ liệu</td></tr>";
        }
        $conn->close();
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
