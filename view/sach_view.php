<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <title>Quản lý cơ sở vật chất</title>
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
        include '../frontend/head.php';
        include '../config/db.php';
        include '../model/qlydocgia_model.php';
    ?>
 <body>
    <div class="container">
        <div class="box">
            <h2>DANH SÁCH SÁCH</h2>
            <form action="search_sach.php" method="POST">
                <div class="row align-items-end">
                    <div class="col">
                        <input type="text" placeholder="Tìm kiếm sách" name="tim_sach" class="form-control">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" name="timkiem">Tìm kiếm</button>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">Thêm mới</button>
                    </div>
                </div>
            </form>
        </div>

        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sách</th>
                    <th>Tác giả</th>
                    <th>Thể loại</th>
                    <th>NXB</th>
                    <th>Số lượng tồn kho</th>
                    <th>Mô tả sách</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="sach_table">
                <!-- Dữ liệu sách sẽ được điền vào đây qua AJAX -->
            </tbody>
        </table>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm mới sách</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                    <div class="form-group">
                            <label for="sach_id">ID sách</label>
                            <input type="text" class="form-control" id="sach_id" required>
                        </div>
                        <div class="form-group">
                            <label for="ten_sach">Tên sách</label>
                            <input type="text" class="form-control" id="ten_sach" required>
                        </div>
                        <div class="form-group">
                            <label for="tacgia_id">ID Tác giả</label>
                            <input type="text" class="form-control" id="tacgia_id" required>
                        </div>
                        <div class="form-group">
                            <label for="theloai_id">ID Thể loại</label>
                            <input type="text" class="form-control" id="theloai_id" required>
                        </div>
                        <div class="form-group">
                            <label for="nxb_id">ID NXB</label>
                            <input type="text" class="form-control" id="nxb_id" required>
                        </div>
                        <div class="form-group">
                            <label for="mota_sach">Mô tả</label>
                            <input type="text" class="form-control" id="mota_sach" required>
                        </div>
                        <div class="form-group">
                            <label for="soluong_tonkho">Số lượng tồn kho</label>
                            <input type="number" class="form-control" id="soluong_tonkho" required>
                        </div>
                
                        <button type="submit" class="btn btn-primary">Thêm sách</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Sửa thông tin sách</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_sach_id" class="form-label">ID Sách</label>
                            <input type="text" class="form-control" id="edit_sach_id" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="edit_ten_sach" class="form-label">Tên sách</label>
                            <input type="text" class="form-control" id="edit_ten_sach" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tacgia_id" class="form-label">Tác giả</label>
                            <input type="text" class="form-control" id="edit_tacgia_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_theloai_id" class="form-label">Thể loại</label>
                            <input type="text" class="form-control" id="edit_theloai_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nxb_id" class="form-label">NXB</label>
                            <input type="text" class="form-control" id="edit_nxb_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_mota_sach" class="form-label">Mô tả</label>
                            <input type="text" class="form-control" id="edit_mota_sach" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_soluong_tonkho" class="form-label">Số lượng tồn kho</label>
                            <input type="number" class="form-control" id="edit_soluong_tonkho" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
// Hàm load dữ liệu sách
function loadSach() {
    fetch('http://localhost/KTPM/controller/qlysach_controller.php', {
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
        const tableBody = document.getElementById('sach_table');
        tableBody.innerHTML = ''; // Xóa dữ liệu cũ
        data.forEach(sach => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${sach.sach_id}</td>
                <td>${sach.ten_sach}</td>
                <td>${sach.tacgia_id}</td>
                <td>${sach.nxb_id}</td>
                <td>${sach.theloai_id}</td>
                <td>${sach.mota_sach}</td>
                <td>${sach.soluong_tonkho}</td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editSach(${sach.sach_id})">Cập nhật</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteSach(${sach.sach_id})">Xoá</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    })
    .catch(error => console.error('Lỗi:', error));
}

// Hàm xử lý khi submit form thêm sách
document.getElementById('addForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Ngừng hành động mặc định (reload trang)

    // Tạo đối tượng dữ liệu
    const data = {
        sach_id: document.getElementById('sach_id').value,
        ten_sach: document.getElementById('ten_sach').value,
        tacgia: document.getElementById('tacgia_id').value,
        nxb_id: document.getElementById('nxb_id').value,
        theloai_id: document.getElementById('theloai_id').value,
        mota_sach: document.getElementById('mota_sach').value,
        soluong_tonkho: document.getElementById('soluong_tonkho').value
    };

    // Kiểm tra xem tất cả các trường có dữ liệu
    if (!data.sach_id || !data.ten_sach || !data.tacgia_id || !data.nxb_id || !data.theloai_id || !data.mota_sach || !data.soluong_tonkho) {
        alert('Vui lòng điền đầy đủ thông tin!');
        return;
    }
    // Gửi dữ liệu đến server qua fetch API
    fetch('http://localhost/KTPM/controller/qlysach_controller.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' // Đặt tiêu đề Content-Type là application/json
        },
        body: JSON.stringify(data) // Chuyển đối tượng thành chuỗi JSON
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Hiển thị thông báo từ server
        $('#addModal').modal('hide'); // Đóng modal
        // Reset các trường nhập liệu
        document.getElementById('sach_id').value = '';
        document.getElementById('ten_sach').value = '';
        document.getElementById('tacgia_id').value = '';
        document.getElementById('nxb_id').value = '';
        document.getElementById('theloai_id').value = '';
        document.getElementById('mota_sach').value = '';
        document.getElementById('soluong_tonkho').value = '';
        loadSach(); // Tải lại danh sách sách
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Đã xảy ra lỗi: ' + error.message);
    });
});

// Hàm chỉnh sửa sách
function editSach(sach_id) {
    fetch(`http://localhost/KTPM/controller/qlysach_controller.php?id=${sach_id}`) 
        .then(response => {
            if (!response.ok) {
                throw new Error(`Lỗi HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(sach => {
            if (sach) {
                document.getElementById('edit_sach_id').value = sach.sach_id;
                document.getElementById('edit_ten_sach').value = sach.ten_sach;
                document.getElementById('edit_tacgia_id').value = sach.tacgia_id;
                document.getElementById('edit_nxb_id').value = sach.nxb_id;
                document.getElementById('edit_theloai_id').value = sach.theloai_id;
                document.getElementById('edit_mota_sach').value = sach.mota_sach;
                document.getElementById('edit_soluong_tonkho').value = sach.soluong_tonkho;
                document.getElementById('sach_id').value = sach.sach_id;
                $('#editModal').modal('show');
            } else {
                alert("Không tìm thấy thông tin sách!");
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert("Lỗi khi tải thông tin sách!");
        });
}

// Xử lý form chỉnh sửa sách
document.getElementById('editForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Ngừng reload trang

    // Tạo đối tượng dữ liệu
    const data = {
        sach_id: document.getElementById('sach_id').value,
        ten_sach: document.getElementById('edit_ten_sach').value,
        tacgia_id: document.getElementById('edit_tacgia_id').value,
        nxb_id: document.getElementById('edit_nxb_id').value,
        theloai_id: document.getElementById('edit_theloai_id').value,
        mota_sach: document.getElementById('edit_mota_sach').value,
        soluong_tonkho: document.getElementById('edit_soluong_tonkho').value
    };

    // Gửi dữ liệu đến server qua fetch API
    fetch('http://localhost/KTPM/controller/qlysach_controller.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json' // Đặt tiêu đề Content-Type là application/json
        },
        body: JSON.stringify(data) // Chuyển đổi đối tượng thành chuỗi JSON
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Hiển thị thông báo từ server
        $('#editModal').modal('hide'); // Đóng modal
        // Reset các trường nhập liệu
        document.getElementById('sach_id').value = '';
        document.getElementById('edit_ten_sach').value = '';
        document.getElementById('edit_tacgia_id').value = '';
        document.getElementById('edit_nxb_id').value = '';
        document.getElementById('edit_theloai_id').value = '';
        document.getElementById('edit_mota_sach').value = '';
        document.getElementById('edit_soluong_tonkho').value = '';
        loadSach(); // Tải lại danh sách sách
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Đã xảy ra lỗi: ' + error.message);
    });
});

// Hàm xóa sách
function deleteSach(sach_id) {
    if (confirm("Bạn có chắc chắn muốn xóa sách này?")) {
        fetch(`http://localhost/KTPM/controller/qlysach_controller.php?sach_id=${sach_id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',  // Đảm bảo rằng headers là json
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
                loadSach();  // Gọi lại hàm để tải lại dữ liệu sau khi xóa
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

// Gọi hàm loadSach khi trang được tải
window.onload = loadSach;
</script>

