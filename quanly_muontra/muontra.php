<?php
include '../config/db.php';

// Tìm kiếm mượn trả
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_docgia = $_POST['ten_docgia'];
    $ngaymuon = $_POST['ngaymuon'];
    $hantra = $_POST['hantra'];
    $ten_sach = $_POST['ten_sach'];
    $soluongs = $_POST['soluong'];
  
    // Kiểm tra ngày mượn và hạn trả
    if (strtotime($ngaymuon) >= strtotime($hantra)) {
        echo "<div class='alert alert-danger' role='alert'>Ngày mượn phải nhỏ hơn hạn trả!</div>";
    } else {
        // Lấy ID của độc giả dựa trên tên
        $docgia_result = $conn->query("SELECT docgia_id FROM docgia WHERE ten_docgia = '$ten_docgia'");
        if ($docgia_result->num_rows > 0) {
            $docgia_id = $docgia_result->fetch_assoc()['docgia_id'];

            // Thêm vào bảng muontra
            $sql = "INSERT INTO muontra (docgia_id, ngaymuon, hantra) VALUES ('$docgia_id', '$ngaymuon', '$hantra')";
            if ($conn->query($sql) === TRUE) {
                $muontra_id = $conn->insert_id;
                 
                // Thêm vào bảng ctmuontra
                foreach ($ten_sach as $index => $ten_sach_item) {
                    $soluong = $soluongs[$index];
                
                    $sach_result = $conn->query("SELECT sach_id FROM sach WHERE ten_sach = '$ten_sach_item'");
                    if ($sach_result->num_rows > 0) {
                        $sach_id = $sach_result->fetch_assoc()['sach_id'];
                        $sql_ct = "INSERT INTO ctmuontra (muontra_id, sach_id, ten_sach, soluong_ctmt) VALUES ('$muontra_id', '$sach_id', '$ten_sach_item', '$soluong')";
                        $conn->query($sql_ct);
                    }
                }
                echo "<div class='alert alert-success' role='alert'>Thêm thông tin mượn trả thành công!</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Lỗi: " . $conn->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>Không tìm thấy độc giả!</div>";
        }
    }
}
?>

<?php include '../view/head.php'; ?>

<div class="container mt-5">
    <h2>Quản lý mượn trả sách</h2>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form class="d-inline-flex" method="GET">
            <input class="form-control me-2" type="text" name="search" placeholder="Tìm kiếm theo tên người mượn" value="<?php echo htmlspecialchars($search_query); ?>">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
        </form>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBorrowModal">Thêm Mượn Trả</button>
    </div>
    <h3>Danh sách mượn trả</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>STT</th>
            <th>Mã Mượn Trả</th>
            <th>Người Mượn</th>
            <th>Ngày Mượn</th>
            <th>Hạn Trả</th>
            <th>Sách Mượn</th>
            <th>Hành Động</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT muontra.*, docgia.ten_docgia, GROUP_CONCAT(CONCAT(ctmuontra.ten_sach, ' (', ctmuontra.soluong_ctmt, ')') SEPARATOR ', ') as sachmuon 
                FROM muontra 
                LEFT JOIN ctmuontra ON muontra.muontra_id = ctmuontra.muontra_id 
                LEFT JOIN docgia ON muontra.docgia_id = docgia.docgia_id ";

        if ($search_query != "") {
            $sql .= "WHERE docgia.ten_docgia LIKE '%$search_query%' ";
        }

        $sql .= "GROUP BY muontra.muontra_id";
        $result = $conn->query($sql);
        $stt = 1;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $stt++ . "</td>
                        <td>" . $row["muontra_id"] . "</td>
                        <td>" . $row["ten_docgia"] . "</td>
                        <td>" . $row["ngaymuon"] . "</td>
                        <td>" . $row["hantra"] . "</td>
                        <td>" . $row["sachmuon"] . "</td>
                        <td>
                            <a href='edit.php?id=" . $row["muontra_id"] . "' class='btn btn-primary'><i class='bi bi-pencil-square'></i> Sửa</a>
                            <a href='delete.php?id=" . $row["muontra_id"] . "' class='btn btn-danger'><i class='bi bi-trash'></i> Xóa</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='7' class='text-center'>Không có dữ liệu</td></tr>";
        }
        $conn->close();
        ?>
        </tbody>
    </table>
</div>

<!-- Modal thêm mượn trả -->
<div class="modal fade" id="addBorrowModal" tabindex="-1" aria-labelledby="addBorrowModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBorrowModalLabel">Thêm Mượn Trả</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="ten_docgia" class="form-label">Tên Độc Giả</label>
                        <input type="text" class="form-control" id="ten_docgia" name="ten_docgia" placeholder="Nhập tên độc giả" required />
                    </div>
                    <div class="mb-3">
                        <label for="ngaymuon" class="form-label">Ngày Mượn</label>
                        <input type="date" class="form-control" id="ngaymuon" name="ngaymuon" required />
                    </div>
                    <div class="mb-3">
                        <label for="hantra" class="form-label">Hạn Trả</label>
                        <input type="date" class="form-control" id="hantra" name="hantra" required />
                    </div>
                    <div class="mb-3">
                        <label for="ten_sach" class="form-label">Tên Sách</label>
                        <div id="book_fields">
                            <div class="row mb-2">
                                <div class="col">
                                    <input type="text" class="form-control" name="ten_sach[]" placeholder="Tên Sách" required />
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" name="soluong[]" placeholder="Số lượng" required />
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="addBookField()">Thêm sách</button>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function addBookField() {
    var bookFields = document.getElementById('book_fields');
    var newField = document.createElement('div');
    newField.classList.add('row', 'mb-2');
    newField.innerHTML = `
        <div class="col">
            <input type="text" class="form-control" name="ten_sach[]" placeholder="Tên Sách" required>
        </div>
        <div class="col">
            <input type="number" class="form-control" name="soluong[]" placeholder="Số lượng" required>
        </div>
    `;
    bookFields.appendChild(newField);
}
</script>

</body>
</html>
