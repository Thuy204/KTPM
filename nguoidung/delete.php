<?php
require_once '../config/db.php';

if (isset($_GET["id"])) {
  $id = $_GET["id"];
  $sql = "DELETE FROM nguoidung WHERE id_nguoidung=$id";

  if ($conn->query($sql) === TRUE) {
    echo "Xóa thành công";
  } else {
    echo "Lỗi: " . $conn->error;
  }
}

$conn->close();
header("Location: index.php"); // Chuyển hướng về trang quản lý nhà xuất bản sau khi xóa
exit();
?>
