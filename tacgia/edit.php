<?php
include '../view/head.php';
require_once '../config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT * FROM tacgia WHERE tacgia_id = '$id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Không có dữ liệu";
    } else {
        $row = mysqli_fetch_assoc($result);
    }
}

if (isset($_POST['sua_tacgia'])) {
    $ten = $_POST['ten_tacgia'];
    $gioitinh = $_POST['gioitinh_tacgia'];
    $thongtin = $_POST['thongtin_tacgia'];
    $file_name = '';

    // Kiểm tra xem người dùng có tải lên hình ảnh hay không
    if (isset($_FILES['tacgia_img']) && $_FILES['tacgia_img']['error'] == 0) {
        $file = $_FILES['tacgia_img'];
        $file_name = $file['name'];
        move_uploaded_file($file['tmp_name'], '../img/tacgia/' . $file_name);
    } else {
        // Nếu không có hình ảnh mới, giữ nguyên hình ảnh cũ
        $file_name = $row['hinhanh_tacgia'];
    }

    $query = "UPDATE tacgia SET ten_tacgia = '$ten', gioitinh_tacgia = '$gioitinh', thongtin_tacgia = '$thongtin', hinhanh_tacgia = '$file_name'
    WHERE tacgia_id = '$id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Lỗi cập nhật thông tin: " . mysqli_error($conn);
    } else {
        echo "<script type='text/javascript'>
                alert('Cập nhật dữ liệu thành công!');
                window.location.href='index.php';
              </script>";
    }
}
?>

<div class="container" style="justify-content: center; margin-top: 50px;">
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>ID</label>
            <input type="number" name="tacgia_id" placeholder="Enter ID" class="form-control" value="
            <?php echo isset($row['tacgia_id']) ? $row['tacgia_id'] : ''; ?>" disabled>

            <label>Tên</label>
            <input type="text" name="ten_tacgia" placeholder="Enter Tên" class="form-control" value="
            <?php echo isset($row['ten_tacgia']) ? $row['ten_tacgia'] : ''; ?>">
            
            <label>Giới tính</label>
            <div class="radio">
                <label><input type="radio" name="gioitinh_tacgia" value="1" 
                <?php echo isset($row['gioitinh_tacgia']) && $row['gioitinh_tacgia'] == 1 ? 'checked' : ''; 
                ?>>Nam</label>
                <label><input type="radio" name="gioitinh_tacgia" value="0" 
                <?php echo isset($row['gioitinh_tacgia']) && $row['gioitinh_tacgia'] == 0 ? 'checked' : '';
                ?>>Nữ</label>
            </div>
            
            <label>Thông tin</label>
            <input type="text" name="thongtin_tacgia" placeholder="Enter Thông tin" class="form-control" value="
            <?php echo isset($row['thongtin_tacgia']) ? $row['thongtin_tacgia'] : ''; ?>">

            <label>Hình ảnh</label>
            <input type="file" name="tacgia_img" class="form-control">
        </div>
        <input type="submit" class="btn btn-success" style="margin: 10px" name="sua_tacgia" value="UPDATE">
        <a href="read.php" class="btn btn-warning">HỦY</a>
    </form>
</div>
