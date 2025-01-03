<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Thể loại</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .box h2 {
            float: left;
            margin: 10px;
        }
        .box form {
            float: right;
            margin: 10px;
        }
        .img {
            width: 5rem;
            height: 6rem;
            border: 1px solid #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <?php
        // Đoạn mã này include các file cần thiết và khởi tạo kết nối đến CSDL
        include '../view/head.php'; // Thay đổi đường dẫn nếu cần
        include '../config/db.php'; // Thay đổi đường dẫn nếu cần
    ?>
    <div class="container">
        <div class="box">
            <h2>DANH SÁCH THỂ LOẠI</h2>
            <!-- Form tìm kiếm -->
            <form action="search.php" method="POST">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Search" name="tim_theloai">
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" name="timkiem">Tìm kiếm</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- Bảng hiển thị danh sách thể loại -->
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Thông tin</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Truy vấn danh sách thể loại từ CSDL
                    $query = "SELECT * FROM theloai";
                    $result = mysqli_query($conn, $query);
                    $num = 1;
                    // Kiểm tra và hiển thị kết quả
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "
                            <tr>
                                <td>" . $num++ . "</td>
                                <td>" . $row["theloai_id"] . "</td>
                                <td>" . $row["ten_theloai"] . "</td>
                                <td>" . $row["thongtin_theloai"] . "</td>
                                <td><a href='edit.php?id=" . $row["theloai_id"] . "' class='btn btn-success'>Sửa</a></td>
                                <td><a onclick='return confirm(\"Bạn có chắc chắn muốn xóa không?\");' 
                                       href='delete.php?id=" . $row['theloai_id'] . "' class='btn btn-danger'>Xóa</a></td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Không có dữ liệu</td></tr>";
                    }
                ?>
            </tbody>
        </table>
        <!-- Nút thêm mới và modal -->
        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Thêm mới</button>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="create.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLongTitle">Thêm mới thể loại</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form nhập liệu -->
                            <div class="form-group">
                                <label>ID</label>
                                <input type="number" name="theloai_id" placeholder="Nhập ID" class="form-control">
                                <label>Tên</label>
                                <input type="text" name="ten_theloai" placeholder="Nhập Tên" class="form-control">
                                <label>Thông tin</label>
                                <input type="text" name="thongtin_theloai" placeholder="Nhập Thông tin" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <input type="submit" class="btn btn-success" name="them_theloai" value="Thêm mới">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
