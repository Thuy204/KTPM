<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Quản lý Nhà Xuất Bản</title>

</head>
<body>
    <?php
        include 'head.php';
        include '../config/db.php';
        include '../model/qlynxb_model.php';
    ?>
    <div class="container">
        <div class="box">
            <h2>DANH SÁCH NHÀ XUẤT BẢN</h2>
                <div class="row align-items-end">
                    <div class="col">
                        <input type="text" placeholder="Search" name="tim_nxb" class="form-control">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary" name="timkiem">Search</button>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-success" id="button-add">Add</button>
                    </div>
                </div>
        </div>
        <div class="table-container">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Nhà Xuất Bản</th>
                    <th>Thông Tin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="nxb_table">
            </tbody>
        </table>
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm mới nhà xuất bản</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="form-group">
                            <label for="ten_nxb">Tên nhà xuất bản</label>
                            <input type="text" class="form-control" id="ten_nxb" required>
                        </div>
                        <div class="form-group">
                            <label for="thongtin_nxb">Thông tin</label>
                            <textarea class="form-control" id="thongtin_nxb" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm nhà xuất bản</button>
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
                        <h5 class="modal-title" id="editModalLabel">Sửa Thông Tin Nhà Xuất Bản</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nxb_id" class="form-label">ID</label>
                            <input type="text" class="form-control" id="nxb_id" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="edit_ten_nxb" class="form-label">Tên nhà xuất bản</label>
                            <input type="text" class="form-control" id="edit_ten_nxb" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_thongtin_nxb" class="form-label">Thông tin</label>
                            <textarea class="form-control" id="edit_thongtin_nxb" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('button-add').addEventListener('click', function() {
            $('#addModal').modal('show');
        });
        // Hàm load dữ liệu nhà xuất bản
        function loadNhaxuatban() {
            fetch('http://localhost/KTPM/controller/qlynxb_controller.php', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                const tableBody = document.getElementById('nxb_table');
                tableBody.innerHTML = ''; // Xóa dữ liệu cũ
                data.forEach(nxb => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${nxb.nxb_id}</td>
                        <td>${nxb.ten_nxb}</td>
                        <td>${nxb.thongtin_nxb}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editNhaxuatban(${nxb.nxb_id})">Update</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteNhaxuatban(${nxb.nxb_id})">Delete</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Lỗi:', error));
        }

        // Hàm xử lý khi submit form thêm nhà xuất bản
        document.getElementById('addForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Ngừng hành động mặc định (reload trang)

            const data = {
                ten_nxb: document.getElementById('ten_nxb').value,
                thongtin_nxb: document.getElementById('thongtin_nxb').value,
            };

            fetch('http://localhost/KTPM/controller/qlynxb_controller.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                document.getElementById('ten_nxb').value = '';
                document.getElementById('thongtin_nxb').value = '';
                $('#addModal').modal('hide');
                loadNhaxuatban(); // Tải lại danh sách nhà xuất bản
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alert('Đã xảy ra lỗi: ' + error.message);
            });
        });

        // Hàm chỉnh sửa nhà xuất bản
        function editNhaxuatban(nxb_id) {
            fetch(`http://localhost/KTPM/controller/qlynxb_controller.php?id=${nxb_id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Lỗi HTTP: ${response.status}`);
                    }
                    return response.json();
                })
                .then(nxb => {
                    document.getElementById('nxb_id').value = nxb.nxb_id;
                    document.getElementById('edit_ten_nxb').value = nxb.ten_nxb;
                    document.getElementById('edit_thongtin_nxb').value = nxb.thongtin_nxb;
                    $('#editModal').modal('show');
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    alert("Lỗi khi tải thông tin nhà xuất bản!");
                });
        }

        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Ngăn reload trang

            const data = {
                nxb_id: document.getElementById('nxb_id').value,
                ten_nxb: document.getElementById('edit_ten_nxb').value,
                thongtin_nxb: document.getElementById('edit_thongtin_nxb').value,
            };

            fetch('http://localhost/KTPM/controller/qlynxb_controller.php', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                $('#editModal').modal('hide');
                loadNhaxuatban(); // Tải lại danh sách nhà xuất bản sau cập nhật
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alert('Đã xảy ra lỗi: ' + error.message);
            });
        });

        function deleteNhaxuatban(nxb_id) {
            if (confirm("Bạn có chắc chắn muốn xóa nhà xuất bản này?")) {
                fetch(`http://localhost/KTPM/controller/qlynxb_controller.php?nxb_id=${nxb_id}`, {
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
                        loadNhaxuatban(); // Gọi lại hàm để tải lại dữ liệu sau khi xóa
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

        // Gọi hàm loadNhaxuatban khi trang được tải
        window.onload = loadNhaxuatban;
    </script>
</body>
</html>