<?php
include '../view/head.php';
require_once '../config/db.php';

// Lấy từ khóa tìm kiếm nếu có
$search_keyword = '';
if (isset($_POST['search'])) {
  $search_keyword = $_POST['search_keyword'];
}

// Lấy dữ liệu từ bảng nhaxuatban
$sql = "SELECT * FROM nguoidung";
if (!empty($search_keyword)) {
  $sql .= " WHERE ten_nguoidung LIKE '%$search_keyword%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quản Lý Thông Tin Người Dùng</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet" />
  <style>
    .btn-icon {
      padding: 0.25rem 0.5rem;
      font-size: 1.2rem;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h2>Duyệt theo tài khoản</h2>
    <form method="post" action="">
      <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Tìm kiếm tài khoản" aria-label="Tìm kiếm người dùng" aria-describedby="button-search" name="search_keyword" value="<?php echo htmlspecialchars($search_keyword); ?>" />
        <button class="btn btn-outline-secondary" type="submit" id="button-search" name="search">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </form>
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0">Danh sách tài khoản</h3>
      <a href="create.php" class="btn btn-primary">Thêm mới thông tin tài khoản</a>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>STT</th>
          <th>ID</th>
          <th>Tên</th>
          <th>Email</th>
          <!-- <th>Mật khẩu</th> -->
          <th>Vai trò</th>
          <th>Sửa</th>
          <th>Xóa</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result->num_rows > 0) {
          $stt = 1;
          while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $stt++ . "</td>";
            echo "<td>" . $row["id_nguoidung"] . "</td>";
            echo "<td>" . $row["ten_nguoidung"] . "</td>";
            echo "<td>" . $row["email_nguoidung"] . "</td>";
            // echo "<td>" . $row["matkhau_nguoidung"] . "</td>";
            echo "<td>" . $row["vaitro_nguoidung"] . "</td>";
            echo "<td><a href='edit.php?id=".$row["id_nguoidung"]."' class='btn btn-success'>Sửa</a></td>";
            echo "<td><a onclick ='return confirm(\"Bạn có chắc chắn muốn xóa không?\");' 
                        href='delete.php?id=".$row['id_nguoidung']."' class='btn btn-danger'>Xóa</a></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='6'>Không có tài khoản nào.</td></tr>";
        }
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
