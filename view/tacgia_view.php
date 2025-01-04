<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tác giả</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
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
    <!-- Bao gồm phần header và cấu hình -->
    <?php
        include '../frontend/head.php';
        include '../config/db.php';
        include '../model/qlytacgia_model.php';
    ?>
    <div class="container">
        <div class="box">
            <h2>DANH SÁCH TÁC GIẢ</h2>
            <!-- Form tìm kiếm -->
            <form action="search_tacgia.php" method="POST">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Tìm kiếm tác giả" name="tim_tacgia">
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" type="submit" name="timkiem">Tìm kiếm</button>
                    </div>
                    <div class="col">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addAuthorModal">Thêm mới tác giả</button>
                    </div>
                </div>
            </form>
        </div>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Giới tính</th>
                    <th>Thông tin</th>
                    <th>Hình ảnh</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="tacgia_table">
                <!-- Dữ liệu tác giả sẽ được tải động từ server -->
            </tbody>
        </table>
        <!-- Modal thêm mới tác giả -->
        <div class="modal fade" id="addAuthorModal" tabindex="-1" role="dialog" aria-labelledby="addAuthorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAuthorModalLabel">Thêm mới tác giả</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form thêm mới tác giả -->
                        <form id="addAuthorForm">
                            <div class="form-group">
                                <label for="ten_tacgia">Tên</label>
                                <input type="text" class="form-control" id="ten_tacgia" name="ten_tacgia" placeholder="Nhập tên tác giả">
                            </div>
                            <div class="form-group">
                                <label>Giới tính</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gioitinh_tacgia" id="gioitinh_nam" value="1" checked>
                                    <label class="form-check-label" for="gioitinh_nam">Nam</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gioitinh_tacgia" id="gioitinh_nu" value="0">
                                    <label class="form-check-label" for="gioitinh_nu">Nữ</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="thongtin_tacgia">Thông tin</label>
                                <input type="text" class="form-control" id="thongtin_tacgia" name="thongtin_tacgia" placeholder="Nhập thông tin tác giả">
                            </div>
                            <div class="form-group">
                                <label for="hinhanh_tacgia">Hình ảnh</label>
                                <input type="file" class="form-control-file" id="hinhanh_tacgia" name="hinhanh_tacgia">
                            </div>
                            <button type="submit" class="btn btn-success">Thêm mới</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal sửa tác giả -->
    <div class="modal fade" id="editAuthorModal" tabindex="-1" role="dialog" aria-labelledby="editAuthorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAuthorModalLabel">Chỉnh sửa tác giả</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editAuthorForm">
                        <input type="hidden" id="edit_tacgia_id" name="tacgia_id">
                        <div class="form-group">
                            <label for="edit_ten_tacgia">Tên tác giả</label>
                            <input type="text" class="form-control" id="edit_ten_tacgia" name="ten_tacgia" required>
                        </div>
                        <div class="form-group">
                            <label>Giới tính</label>
                            <div>
                                <label>
                                    <input type="radio" name="edit_gioitinh_tacgia" value="0" required> Nam
                                </label>
                                <label>
                                    <input type="radio" name="edit_gioitinh_tacgia" value="1"> Nữ
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_quocgia_tacgia">Quốc gia</label>
                            <input type="text" class="form-control" id="edit_quocgia_tacgia" name="quocgia_tacgia" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_hinhanh_tacgia">Hình ảnh</label>
                            <input type="file" class="form-control-file" id="edit_hinhanh_tacgia" name="hinhanh_tacgia">
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>
</html>

<script>

// Hàm load dữ liệu tác giả
function loadTacgia() {
    fetch('http://localhost/KTPM/controller/qlytacgia_controller.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json' // Đặt tiêu đề Content-Type là application/json
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        const tableBody = document.getElementById('tacgia_table');
        tableBody.innerHTML = ''; // Xóa dữ liệu cũ
        data.forEach(tacgia => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${tacgia.tacgia_id}</td>
                <td>${tacgia.ten_tacgia}</td>
                <td>${tacgia.gioitinh_tacgia === "0" ? 'Nam' : 'Nữ'}</td>
                <td>${tacgia.thongtin_tacgia}</td>
                <td><img src='../img/tacgia/${tacgia.hinhanh_tacgia}' alt='img' width='50'></td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editTacgia(${tacgia.tacgia_id})">Sửa</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteTacgia(${tacgia.tacgia_id})">Xóa</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    })
    .catch(error => console.error('Lỗi:', error));
}

// Hàm xử lý khi submit form thêm tác giả
document.getElementById('addTacgiaForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Ngừng hành động mặc định (reload trang)

    // Tạo đối tượng dữ liệu
    const data = {
        ten_tacgia: document.getElementById('ten_tacgia').value,
        gioitinh_tacgia: document.querySelector('input[name="gioitinh_tacgia"]:checked')?.value,
        thongtin_tacgia: document.getElementById('thongtin_tacgia').value,
        hinhanh_tacgia: document.getElementById('hinhanh_tacgia').files[0]
    };

    // Kiểm tra xem tất cả các trường có dữ liệu
    if (!data.ten_tacgia || !data.gioitinh_tacgia || !data.thongtin_tacgia || !data.hinhanh_tacgia) {
        alert('Vui lòng điền đầy đủ thông tin!');
        return;
    }

    // Gửi dữ liệu đến server qua fetch API
    const formData = new FormData();
    formData.append('ten_tacgia', data.ten_tacgia);
    formData.append('gioitinh_tacgia', data.gioitinh_tacgia);
    formData.append('thongtin_tacgia', data.thongtin_tacgia);
    formData.append('hinhanh_tacgia', data.hinhanh_tacgia);

    fetch('http://localhost/QLTV/controller/qlytacgia_controller.php', {
        method: 'POST',
        body: formData // Gửi dữ liệu dạng FormData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Hiển thị thông báo từ server
        $('#addTacgiaModal').modal('hide'); // Đóng modal
        // Reset các trường nhập liệu
        document.getElementById('ten_tacgia').value = '';
        document.querySelector('input[name="gioitinh_tacgia"]:checked').checked = false; // Đặt lại radio button
        document.getElementById('thongtin_tacgia').value = '';
        document.getElementById('hinhanh_tacgia').value = '';
        loadTacgia(); // Tải lại danh sách tác giả
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Đã xảy ra lỗi: ' + error.message);
    });
});

// Hàm chỉnh sửa tác giả
function editTacgia(tacgia_id) {
    fetch(`http://localhost/QLTV/controller/qlytacgia_controller.php?id=${tacgia_id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Lỗi HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(tacgia => {
            if (tacgia) {
                document.getElementById('edit_ten_tacgia').value = tacgia.ten_tacgia;
                const gioitinh = document.querySelectorAll('input[name="edit_gioitinh_tacgia"]');
                gioitinh.forEach(input => {
                    input.checked = (input.value === tacgia.gioitinh_tacgia);
                });
                document.getElementById('edit_thongtin_tacgia').value = tacgia.thongtin_tacgia;
                document.getElementById('edit_hinhanh_tacgia').value = tacgia.hinhanh_tacgia;
                document.getElementById('tacgia_id').value = tacgia.tacgia_id;
                $('#editTacgiaModal').modal('show');
            } else {
                alert("Không tìm thấy thông tin tác giả!");
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert("Lỗi khi tải thông tin tác giả!");
        });
}

document.getElementById('editTacgiaForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Ngừng reload trang
    // Tạo đối tượng dữ liệu
    const data = {
        tacgia_id: document.getElementById('tacgia_id').value,
        ten_tacgia: document.getElementById('edit_ten_tacgia').value,
        gioitinh_tacgia: document.querySelector('input[name="edit_gioitinh_tacgia"]:checked')?.value,
        thongtin_tacgia: document.getElementById('edit_thongtin_tacgia').value,
        hinhanh_tacgia: document.getElementById('edit_hinhanh_tacgia').files[0]
    };

    const formData = new FormData();
    formData.append('tacgia_id', data.tacgia_id);
    formData.append('ten_tacgia', data.ten_tacgia);
    formData.append('gioitinh_tacgia', data.gioitinh_tacgia);
    formData.append('thongtin_tacgia', data.thongtin_tacgia);
    if (data.hinhanh_tacgia) formData.append('hinhanh_tacgia', data.hinhanh_tacgia);

    fetch('http://localhost/QLTV/controller/qlytacgia_controller.php', {
        method: 'PUT',
        body: formData // Gửi dữ liệu dạng FormData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Hiển thị thông báo từ server
        $('#editTacgiaModal').modal('hide'); // Đóng modal
        loadTacgia(); // Tải lại danh sách tác giả sau cập nhật
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Đã xảy ra lỗi: ' + error.message);
    });
});

// Hàm xóa tác giả
function deleteTacgia(tacgia_id) {
    if (confirm("Bạn có chắc chắn muốn xóa tác giả này?")) {
        fetch(`http://localhost/QLTV/controller/qlytacgia_controller.php?tacgia_id=${tacgia_id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Lỗi HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 200) {
                alert("Xóa thành công!");
                loadTacgia();  // Gọi lại hàm để tải lại dữ liệu sau khi xóa
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert("Đã xảy ra lỗi khi cố gắng xóa!");
        });
    }
}

window.onload = loadTacgia;

</script>