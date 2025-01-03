<?php
include '../view/head.php';
require_once '../config/db.php';

// Lấy từ khóa tìm kiếm nếu có
$search_keyword = '';
if (isset($_POST['search'])) {
  $search_keyword = $_POST['search_keyword'];
}

// Lấy dữ liệu từ bảng nhaxuatban sử dụng prepared statements để tránh SQL Injection
$sql = "SELECT * FROM nhaxuatban";
if (!empty($search_keyword)) {
  $sql .= " WHERE ten_nxb LIKE ?";
  $stmt = $conn->prepare($sql);
  $search_keyword = "%" . $search_keyword . "%";
  $stmt->bind_param("s", $search_keyword);
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản lý Nhà Xuất Bản</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .btn-icon {
      padding: 0.25rem 0.5rem;
      font-size: 1.2rem;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h2>Duyệt theo nhà xuất bản</h2>
    <form method="post" action="">
      <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Tìm kiếm nhà xuất bản" aria-label="Tìm kiếm nhà xuất bản" aria-describedby="button-search" name="search_keyword" value="<?php echo htmlspecialchars($search_keyword); ?>" />
        <button class="btn btn-outline-secondary" type="submit" id="button-search" name="search">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </form>
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0">Danh sách nhà xuất bản</h3>
      <a href="create.php" class="btn btn-primary">Thêm mới nhà xuất bản</a>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>STT</th>
          <th>ID</th>
          <th>Tên</th>
          <th>Thông tin</th>
          <th>Hình ảnh</th> 
          <th>Sửa</th>
          <th>Xóa</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
          $stt = 1; // Khai báo biến đếm
          while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $stt++ . "</td>"; // Hiển thị và tăng biến đếm
            echo "<td>" . $row["nxb_id"] . "</td>";
            echo "<td>" . $row["ten_nxb"] . "</td>";
            echo "<td>" . $row["thongtin_nxb"] . "</td>";

            // Kiểm tra nếu có hình ảnh, nếu không thì hiển thị hình ảnh mặc định
            $imagePath = !empty($row["hinhanh_nxb"]) ? "../img/nxb/".$row["hinhanh_nxb"] : '../img/default.png';
            echo "<td><img src='" . $imagePath . "' alt='img' width='50'></td>";
            
            echo "<td><a href='edit.php?id=".$row["nxb_id"]."' class='btn btn-success'>Sửa</a></td>";
            echo "<td><a onclick ='return confirm(\"Bạn có chắc chắn muốn xóa không?\");' 
                        href='delete.php?id=".$row['nxb_id']."' class='btn btn-danger'>Xóa</a></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='7' class='text-center'>Không có nhà xuất bản nào.</td></tr>";
        }
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
