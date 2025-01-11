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
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <!-- Bao gồm phần header và cấu hình -->
    <?php
        include '../view/head.php';
        include '../config/db.php';
        include '../model/qlytacgia_model.php';
    ?>
    <div class="container">
        <div class="box">
            <h2>DANH SÁCH TÁC GIẢ</h2>
            <!-- Form tìm kiếm -->
            <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Tìm kiếm tác giả" name="tim_tacgia">
                    </div>
                    <div class="col-auto">

                    <button type="submit" class="btn btn-primary" onclick="searchTacgia()">Tìm kiếm</button>
                    </div>
                    <div class="col-auto">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addAuthorModal">Thêm mới tác giả</button>
                    </div>
                </div>
        </div>
        <div class="table-container">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Giới tính</th>
                    <th>Thông tin</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="tacgia_table">
                <!-- Dữ liệu tác giả sẽ được tải động từ server -->
            </tbody>
        </table>
        </div>
        
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
                        <form id="addTacgiaForm">
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
                            <button type="submit" class="btn btn-success">Thêm mới</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal sửa tác giả -->
    <div class="modal fade" id="editAuthorModal" tabindex="-1" aria-labelledby="editAuthorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editTacgiaForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAuthorModalLabel">Sửa Thông Tin Tác Giả</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tacgia_id" class="form-label">ID</label>
                            <input type="text" class="form-control" id="tacgia_id" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="edit_ten_tacgia" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="edit_ten_tacgia" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giới tính</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_gioitinh_tacgia" value="0" id="edit_tinhtrang_moi" required>
                                <label class="form-check-label" for="edit_gtinh_nam">Nam</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_gioitinh_tacgia" value="1" id="edit_tinhtrang_cu">
                                <label class="form-check-label" for="edit_gioitinh_nu">Nữ</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_thongtin_tacgia" class="form-label">Thông tin</label>
                            <input type="phone" class="form-control" id="edit_thongtin_tacgia" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Câp nhật</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>   
    </form>
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
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editTacgia(${tacgia.tacgia_id})">Cập nhập</button>
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
        thongtin_tacgia: document.getElementById('thongtin_tacgia').value
    };

    // Kiểm tra xem tất cả các trường có dữ liệu
    if (!data.ten_tacgia || !data.gioitinh_tacgia || !data.thongtin_tacgia ) {
        alert('Vui lòng điền đầy đủ thông tin!');
        return;
    }
 // Gửi dữ liệu đến server qua fetch API
 fetch('http://localhost/KTPM/controller/qlytacgia_controller.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' // Đặt tiêu đề Content-Type là application/json
        },
        body: JSON.stringify(data) // Chuyển đổi đối tượng thành chuỗi JSON
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Hiển thị thông báo từ server
        $('#addModal').modal('hide'); // Đóng modal
        // Reset các trường nhập liệu
        document.getElementById('ten_tacgia').value = '';
        document.querySelector('input[name="gioitinh_tacgia"]:checked').checked = false; // Đặt lại radio button
        document.getElementById('thongtin_tacgia').value = '';
        loadTacgia(); // Tải lại danh sách Tác giả
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Đã xảy ra lỗi: ' + error.message);
    });
    });

// Hàm chỉnh sửa tác giả
function editTacgia(tacgia_id) {
    fetch(`http://localhost/KTPM/controller/qlytacgia_controller.php?id=${tacgia_id}`) 
        .then(response => {
            if (!response.ok) {
                throw new Error(`Lỗi HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(tacgia => {
            if (tacgia) {
                document.getElementById('edit_ten_tacgia').value = tacgia.ten_tacgia;
                const gioitinh=document.querySelectorAll('input[name="edit_gioitinh_tacgia"]');
                gioitinh.forEach(input => {
                    input.checked = (input.value === tacgia.gioitinh_tacgia);
                });
                document.getElementById('edit_thongtin_tacgia').value = tacgia.thongtin_tacgia;
                document.getElementById('tacgia_id').value = tacgia.tacgia_id;
                $('#editAuthorModal').modal('show');
            } else {
                alert("Không tìm thấy thông tin tác giả!");
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert("Lỗi khi tải thông tin tác giả!");
        });
}
document.getElementById('editTacgiaForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Ngăn reload trang
    // Tạo đối tượng dữ liệu
    const data = {
        tacgia_id:document.getElementById('tacgia_id').value,
        ten_tacgia: document.getElementById('edit_ten_tacgia').value,
        gioitinh_tacgia: document.querySelector('input[name="edit_gioitinh_tacgia"]:checked')?.value,
        thongtin_tacgia: document.getElementById('edit_thongtin_tacgia').value
    };
    // Gửi dữ liệu đến server qua fetch API
    fetch('http://localhost/KTPM/controller/qlytacgia_controller.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json' // Đặt tiêu đề Content-Type là application/json
        },
        body: JSON.stringify(data) // Chuyển đổi đối tượng thành chuỗi JSON
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Hiển thị thông báo từ server
        $('#addModal').modal('hide'); // Đóng modal
        // Reset các trường nhập liệu
        document.getElementById('tacgia_id').value-'';
        document.getElementById('edit_ten_tacgia').value = '';
        document.querySelector('input[name="edit_gioitinh_tacgia"]:checked').checked = false; // Đặt lại radio button
        document.getElementById('edit_thongtin_tacgia').value = '';
        loadTacgia(); // Tải lại danh sách độc giả sau cập nhật
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Đã xảy ra lỗi: ' + error.message);
    });
    });
// Hàm xóa tác giả
function deleteTacgia(tacgia_id) {
    if (confirm("Bạn có chắc chắn muốn xóa tác giả này?")) {
        fetch(`http://localhost/KTPM/controller/qlytacgia_controller.php?tacgia_id=${tacgia_id}`, {
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
function searchTacgia() {
    const giatri_tim = document.querySelector('input[name="tim_tacgia"]').value; // Lấy giá trị từ ô tìm kiếm
    fetch(`http://localhost/KTPM/controller/qlytacgia_controller.php?timkiem=${encodeURIComponent(giatri_tim)}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json' // Đặt tiêu đề Content-Type là application/json
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json(); // Chuyển đổi phản hồi thành JSON
    })
    .then(data => {
        const tableBody = document.getElementById('tacgia_table');
        tableBody.innerHTML = ''; // Xóa dữ liệu cũ trong bảng
        // Duyệt qua từng mục trong dữ liệu và thêm vào bảng
        if (data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Không tìm thấy kết quả.</td></tr>';
        } else {
            data.forEach(tacgia => {
                const row = document.createElement('tr'); // Tạo một hàng mới cho bảng
                row.innerHTML = `
                    <td>${tacgia.tacgia_id}</td>
                    <td>${tacgia.ten_tacgia}</td>
                    <td>${tacgia.gioitinh_tacgia === "0" ? 'Nam' : 'Nữ'}</td>
                    <td>${tacgia.thongtin_tacgia}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editTacgia(${tacgia.tacgia_id})">Sửa</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteTacgia(${tacgia.tacgia_id})">Xóa</button>
                    </td>
                `;
                tableBody.appendChild(row); // Thêm hàng mới vào bảng
            });
        }
    })
    .catch(error => {
        console.error('Lỗi:', error); // Xử lý lỗi nếu có
    });
}

window.onload = loadTacgia;

</script>