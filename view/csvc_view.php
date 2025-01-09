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
        include '../model/qlycsvc_model.php';
    ?>
    <div class="container">
        <div class="box">
            <h2>DANH SÁCH CƠ SỞ VẬT CHẤT</h2>
            <form action="search_csvc.php" method="POST">
                <div class="row">
                    <div class="col">
                        <input type="text" placeholder="Search" name="tim_csvc" class="form-control">
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" name="timkiem">Tìm kiếm</button>
                    </div>
                </div>
            </form>
            <button class="btn btn-success mt-3" data-toggle="modal" data-target="#addModal">Thêm mới</button>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Số Lượng</th>
                    <th>Tình Trạng</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody id="csvc_table">
                <!-- Dữ liệu được load từ API -->
            </tbody>
        </table>
    </div>

    <!-- Modal Thêm Cơ Sở Vật Chất -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Thêm Cơ Sở Vật Chất</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ten_csvc" class="form-label">Tên Cơ Sở Vật Chất</label>
                            <input type="text" class="form-control" id="ten_csvc" required>
                        </div>
                        <div class="mb-3">
                            <label for="soluong_csvc" class="form-label">Số Lượng</label>
                            <input type="number" class="form-control" id="soluong_csvc" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tình Trạng</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tinhtrang_csvc" id="tinhtrang_moi" value="1" required>
                                <label class="form-check-label" for="tinhtrang_moi">Mới</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tinhtrang_csvc" id="tinhtrang_cu" value="0">
                                <label class="form-check-label" for="tinhtrang_cu">Cũ</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Đóng</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Sửa Cơ Sở Vật Chất -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Sửa Cơ Sở Vật Chất</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_csvc_id">
                        <div class="mb-3">
                            <label for="edit_ten_csvc" class="form-label">Tên Cơ Sở Vật Chất</label>
                            <input type="text" class="form-control" id="edit_ten_csvc" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_soluong_csvc" class="form-label">Số Lượng</label>
                            <input type="number" class="form-control" id="edit_soluong_csvc" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tình Trạng</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_tinhtrang_csvc" value="1" id="edit_tinhtrang_moi" required>
                                <label class="form-check-label" for="edit_tinhtrang_moi">Mới</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_tinhtrang_csvc" value="0" id="edit_tinhtrang_cu">
                                <label class="form-check-label" for="edit_tinhtrang_cu">Cũ</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Đóng</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
// Hàm load dữ liệu cơ sở vật chất
function load_csvc() {
    fetch('http://localhost/KTPM/controller/qlycsvc_controller.php', {
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
            const tableBody = document.getElementById('csvc_table');
            tableBody.innerHTML = ''; // Xóa dữ liệu cũ

            if (!data || !Array.isArray(data)) {
                console.error('Dữ liệu trả về không phải là mảng');
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Lỗi dữ liệu</td></tr>';
                return;
            }

            if (data.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>';
            } else {
                data.forEach(csvc => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${csvc.csvc_id}</td>
                        <td>${csvc.ten_csvc}</td>
                        <td>${csvc.soluong_csvc}</td>
                        <td>${csvc.tinhtrang_csvc === '1' ? 'Mới' : 'Cũ'}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="edit_csvc(${csvc.csvc_id})">Sửa</button>
                            <button class="btn btn-danger btn-sm" onclick="delete_csvc(${csvc.csvc_id})">Xóa</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
        });
}

// Hàm xử lý khi submit form thêm cơ sở vật chất
    document.getElementById('addForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Ngừng hành động mặc định (reload trang)

    const formData = {
        ten_csvc: document.getElementById('ten_csvc').value,
        soluong_csvc: document.getElementById('soluong_csvc').value,
        tinhtrang_csvc: document.querySelector('input[name="tinhtrang_csvc"]:checked')?.value
    };

    fetch('http://localhost/KTPM/controller/qlycsvc_controller.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 201) {
            $('#addModal').modal('hide');
            load_csvc(); // Reload dữ liệu sau khi thêm thành công
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Lỗi:', error);
    });
});

// Hàm chỉnh sửa cơ sở vật chất
function edit_csvc(csvc_id) {
    fetch(`http://localhost/KTPM/controller/qlycsvc_controller.php?id=${csvc_id}`) // Sửa URL
        .then(response => {
            if (!response.ok) {
                throw new Error(`Lỗi HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(csvc => {
            if (csvc) {
                document.getElementById('edit_ten_csvc').value = csvc.ten_csvc;
                document.getElementById('edit_soluong_csvc').value = csvc.soluong_csvc;
                document.querySelector(`input[name="edit_tinhtrang_csvc"][value="${csvc.tinhtrang_csvc}"]`).checked = true;
                document.getElementById('edit_csvc_id').value = csvc.csvc_id;
                $('#editModal').modal('show');
            } else {
                alert("Không tìm thấy thông tin cơ sở vật chất!");
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert("Lỗi khi tải thông tin cơ sở vật chất!");
        });
}
    // Hàm xử lý khi submit form sửa cơ sở vật chất
    document.getElementById('editForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Ngăn reload trang

    const formData = {
        csvc_id: document.getElementById('edit_csvc_id').value,
        ten_csvc: document.getElementById('edit_ten_csvc').value,
        soluong_csvc: document.getElementById('edit_soluong_csvc').value,
        tinhtrang_csvc: document.querySelector('input[name="edit_tinhtrang_csvc"]:checked').value
    };

    fetch('http://localhost/KTPM/controller/qlycsvc_controller.php', { // Thêm action=update
        method: 'PUT', // Dùng POST nếu PUT không được hỗ trợ
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Lỗi HTTP: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 200) {
            $('#editModal').modal('hide');
            load_csvc(); // Cập nhật lại bảng
        } else {
            alert(data.message || "Có lỗi xảy ra!");
        }
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert("Lỗi khi cập nhật thông tin cơ sở vật chất!");
    });
});


function delete_csvc(csvc_id) {
    if (confirm("Bạn có chắc chắn muốn xóa cơ sở vật chất này?")) {
        fetch('http://localhost/KTPM/controller/qlycsvc_controller.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',  // Đảm bảo rằng headers là json
            },
            body: JSON.stringify({ csvc_id: csvc_id })  // Truyền csvc_id trong body
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 200) {
                alert("Xóa thành công!");
                load_csvc();  // Gọi lại hàm để tải lại dữ liệu sau khi xóa
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
        });
    }
}


// Gọi hàm load_csvc khi trang được tải
window.onload = load_csvc;
</script>

</body>
</html>