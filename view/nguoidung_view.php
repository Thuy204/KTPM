<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Quản lý người dùng</title>
    <style>
        .box h2 {
            float: left;
            margin: 0;
        }
        .box form {
            float: right;
            margin: 10px;
        }
    </style>
</head>
<body>
<?php
        include '../frontend/head.php';
        include '../config/db.php';
        include '../model/qlynguoidung_model.php';
    ?>
    <div class="container">
        <div class="box">
            <h2>DANH SÁCH NGƯỜI DÙNG</h2>
            <form action="search_nguoidung.php" method="POST">
                <div class="row align-items-end">
                    <div class="col">
                        <input type="text" placeholder="Search" name="tim_nguoidung" class="form-control">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" name="timkiem">Search</button>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">Add</button>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên người dùng</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="nguoidung_table"></tbody>
        </table>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm mới người dùng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="form-group">
                            <label for="ten_nguoidung">Tên người dùng</label>
                            <input type="text" class="form-control" id="ten_nguoidung" required>
                        </div>
                        <div class="form-group">
                            <label for="email_nguoidung">Email</label>
                            <input type="email" class="form-control" id="email_nguoidung" required>
                        </div>
                        <div class="form-group">
                            <label for="matkhau_nguoidung">Mật khẩu</label>
                            <input type="password" class="form-control" id="matkhau_nguoidung" required>
                        </div>
                        <div class="form-group">
                            <label for="vaitro_nguoidung">Vai trò</label>
                            <select id="vaitro_nguoidung" class="form-control" required>
                                <option value="Nhân viên">Nhân viên</option>
                                <option value="Sinh viên">Sinh viên</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Thêm người dùng</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Sửa thông tin người dùng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="nguoidung_id">
                        <div class="form-group">
                            <label for="edit_ten_nguoidung">Tên người dùng</label>
                            <input type="text" class="form-control" id="edit_ten_nguoidung" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_email_nguoidung">Email</label>
                            <input type="email" class="form-control" id="edit_email_nguoidung" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_vaitro_nguoidung">Vai trò</label>
                            <select id="edit_vaitro_nguoidung" class="form-control" required>
                                <option value="Nhân viên">Nhân viên</option>
                                <option value="Sinh viên">Sinh viên</option>
                            </select>
                        </div>
                        
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Load danh sách người dùng
        function loadNguoidung() {
            fetch('http://localhost/QLTV/controller/nguoidung_controller.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('nguoidung_table');
                    tableBody.innerHTML = '';
                    data.forEach(nguoidung => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${nguoidung.id_nguoidung}</td>
                            <td>${nguoidung.ten_nguoidung}</td>
                            <td>${nguoidung.email_nguoidung}</td>
                            <td>${nguoidung.vaitro_nguoidung}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editNguoidung(${nguoidung.id_nguoidung})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteNguoidung(${nguoidung.id_nguoidung})">Delete</button>
                            </td>
                        `;
                        tableBody.appendChild(row);
                    });
                });
        }

        // Thêm người dùng
        document.getElementById('addForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const data = {
                ten_nguoidung: document.getElementById('ten_nguoidung').value,
                email_nguoidung: document.getElementById('email_nguoidung').value,
                matkhau_nguoidung: document.getElementById('matkhau_nguoidung').value,
                vaitro_nguoidung: document.getElementById('vaitro_nguoidung').value
            };
            fetch('http://localhost/QLTV/controller/nguoidung_controller.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            }).then(() => {
                $('#addModal').modal('hide');
                loadNguoidung();
            });
        });

        // Sửa người dùng
        function editNguoidung(id) {
            fetch(`http://localhost/QLTV/controller/nguoidung_controller.php?id=${id}`)
                .then(response => response.json())
                .then(nguoidung => {
                    document.getElementById('nguoidung_id').value = nguoidung.id_nguoidung;
                    document.getElementById('edit_ten_nguoidung').value = nguoidung.ten_nguoidung;
                    document.getElementById('edit_email_nguoidung').value = nguoidung.email_nguoidung;
                    document.getElementById('edit_matkhau_nguoidung').value = nguoidung.matkhau_nguoidung;
                    document.getElementById('edit_vaitro_nguoidung').value = nguoidung.vaitro_nguoidung;
                    $('#editModal').modal('show');
                });
        }

        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const id = document.getElementById('nguoidung_id').value;
            const data = {
                ten_nguoidung: document.getElementById('edit_ten_nguoidung').value,
                email_nguoidung: document.getElementById('edit_email_nguoidung').value,
                matkhau_nguoidung: document.getElementById('matkhau_nguoidung').value,
                vaitro_nguoidung: document.getElementById('edit_vaitro_nguoidung').value
            };
            fetch(`http://localhost/QLTV/controller/nguoidung_controller.php?id=${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            }).then(() => {
                $('#editModal').modal('hide');
                loadNguoidung();
            });
        });

        // Xóa người dùng
        function deleteNguoidung(id) {
            if (confirm('Bạn có chắc muốn xóa người dùng này?')) {
                fetch(`http://localhost/QLTV/controller/nguoidung_controller.php?id=${id}`, {
                    method: 'DELETE'
                }).then(loadNguoidung);
            }
        }

        window.onload = loadNguoidung;
    </script>
</body>
</html>
