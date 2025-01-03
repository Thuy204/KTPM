<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM theloai WHERE theloai_id = '$id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Lỗi xóa: " . mysqli_error($conn);
    } else {
        header('Location: read.php');
        exit();
    }
} else {
    echo "ID không hợp lệ.";
}
?>
