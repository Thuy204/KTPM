<?php
require_once '../config/db.php';

if (isset($_POST['them_theloai'])) {
    $id = $_POST['theloai_id'];
    $ten = $_POST['ten_theloai'];
    $thongtin = $_POST['thongtin_theloai'];

    if ($id == "" || empty($id)) {
        echo 'ID không được để trống!';
        exit();
    } else {
        $query = "INSERT INTO theloai (theloai_id, ten_theloai, thongtin_theloai) VALUES ('$id', '$ten', '$thongtin')";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo 'Dữ liệu không hợp lệ: ' . mysqli_error($conn);
        } else {
            header('Location: read.php');
            exit();
        }
    }
}
?>
