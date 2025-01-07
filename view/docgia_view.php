<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Quản lý độc giả</title>
    <style>
        .box h2 {
            float: left; 
            margin: center; 
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
    <div class="container">
        <div class="box">
        <h2>DANH SÁCH ĐỘC GIẢ</h2>
        <form action="search_docgia.php" method="POST">
            <div class="row align-items-end"> <!-- Optional alignment -->
                <div class="col">
                    <input type="text" placeholder="Search" name="tim_docgia" class="form-control">
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
        <table class="table table-striped table-hover ">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ và tên</th>
                    <th>Tuổi</th>
                    <th>Giới tính</th>
                    <th>SĐT</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="docgia_table">
            </tbody>
        </table>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm mới độc giả</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="form-group">
                            <label for="ten_docgia">Tên độc giả</label>
                            <input type="text" class="form-control" id="ten_docgia" required>
                        </div>
                        <div class="form-group">
                            <label for="tuoi_docgia">Tuổi</label>
                            <input type="number" class="form-control" id="tuoi_docgia" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_gioitinh_docgia">Giới tính</label>
                            <div>
                                <label>
                                <input type="radio" name="gioitinh_docgia" value="0" id="gioitinh_docgia_nam">
                                    Nam
                                
                                </label>
                                <label>
                                <input type="radio" name="gioitinh_docgia" value="1" id="gioitinh_docgia_nu">
                                    Nữ
                                   
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sdt_docgia">SĐT</label>
                            <input type="phone" class="form-control" id="sdt_docgia" required>
                        </div>
                        <div class="form-group">
                            <label for="email_docgia">Email</label>
                            <input type="email" class="form-control" id="email_docgia" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm độc giả</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Sửa Thông Tin Độc Giả</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- <input type="hidden" id="docgia_id"> -->
                        <div class="mb-3">
                            <label for="docgia_id" class="form-label">ID</label>
                            <input type="text" class="form-control" id="docgia_id" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="edit_ten_docgia" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="edit_ten" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tuoi_docgia" class="form-label">Tuổi</label>
                            <input type="number" class="form-control" id="edit_tuoi" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giới tính</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_gioitinh" value="0" id="edit_tinhtrang_moi" required>
                                <label class="form-check-label" for="edit_gtinh_nam">Nam</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_gioitinh" value="1" id="edit_tinhtrang_cu">
                                <label class="form-check-label" for="edit_gioitinh_nu">Nữ</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_sdt_docgia" class="form-label">Số điện thoại</label>
                            <input type="phone" class="form-control" id="edit_sdt" required>
                        </div>
                        <div class="mb-3">
                            <label for="email_docgia">Email</label>
                            <input type="email" class="form-control" id="edit_email" required>
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

</body>
</html>
<script>
// Hàm load dữ liệu độc giả
function loadDocgia() {
    fetch('http://localhost/KTPM/controller/qlydocgia_controller.php', {
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
                const tableBody = document.getElementById('docgia_table');
                tableBody.innerHTML = ''; // Xóa dữ liệu cũ
                data.forEach(docgia => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${docgia.docgia_id}</td>
                        <td>${docgia.ten_docgia}</td>
                        <td>${docgia.tuoi_docgia}</td>
                        <td>${docgia.gioitinh_docgia === "0" ? 'Nam' : 'Nữ'}</td>
                        <td>${docgia.sdt_docgia}</td>
                        <td>${docgia.email}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editDocgia(${docgia.docgia_id})">Update</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteDocgia(${docgia.docgia_id})">Delete</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Lỗi:', error));
    }
// Hàm xử lý khi submit form thêm độc giả
document.getElementById('addForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Ngừng hành động mặc định (reload trang)

    // Tạo đối tượng dữ liệu
    const data = {
        ten_docgia: document.getElementById('ten_docgia').value,
        tuoi_docgia: document.getElementById('tuoi_docgia').value,
        gioitinh_docgia: document.querySelector('input[name="gioitinh_docgia"]:checked')?.value,
        sdt_docgia: document.getElementById('sdt_docgia').value,
        email: document.getElementById('email_docgia').value
    };

    // Kiểm tra xem tất cả các trường có dữ liệu
    if (!data.ten_docgia || !data.tuoi_docgia || !data.gioitinh_docgia || !data.sdt_docgia || !data.email) {
        alert('Vui lòng điền đầy đủ thông tin!');
        return;
    }

    // Gửi dữ liệu đến server qua fetch API
    fetch('http://localhost/KTPM/controller/qlydocgia_controller.php', {
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
        document.getElementById('ten_docgia').value = '';
        document.getElementById('tuoi_docgia').value = '';
        document.querySelector('input[name="gioitinh_docgia"]:checked').checked = false; // Đặt lại radio button
        document.getElementById('sdt_docgia').value = '';
        document.getElementById('email_docgia').value = '';
        loadDocgia(); // Tải lại danh sách độc giả
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Đã xảy ra lỗi: ' + error.message);
    });
    });
    // Hàm chỉnh sửa độc giả
function editDocgia(docgia_id) {
    fetch(`http://localhost/KTPM/controller/qlydocgia_controller.php?id=${docgia_id}`) 
        .then(response => {
            if (!response.ok) {
                throw new Error(`Lỗi HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(docgia => {
            if (docgia) {
                document.getElementById('edit_ten').value = docgia.ten_docgia;
                document.getElementById('edit_tuoi').value = docgia.tuoi_docgia;
                const gioitinh=document.querySelectorAll('input[name="edit_gioitinh"]');
                gioitinh.forEach(input => {
                    input.checked = (input.value === docgia.gioitinh_docgia);
                });
                document.getElementById('edit_sdt').value = docgia.sdt_docgia;
                document.getElementById('docgia_id').value = docgia.docgia_id;
                document.getElementById('edit_email').value = docgia.email;
                $('#editModal').modal('show');
            } else {
                alert("Không tìm thấy thông tin độc giả!");
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert("Lỗi khi tải thông tin độc giả!");
        });
}
document.getElementById('editForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Ngăn reload trang
    // Tạo đối tượng dữ liệu
    const data = {
        docgia_id:document.getElementById('docgia_id').value,
        ten_docgia: document.getElementById('edit_ten').value,
        tuoi_docgia: document.getElementById('edit_tuoi').value,
        gioitinh_docgia: document.querySelector('input[name="edit_gioitinh"]:checked')?.value,
        sdt_docgia: document.getElementById('edit_sdt').value,
        email: document.getElementById('edit_email').value
    };
    // Gửi dữ liệu đến server qua fetch API
    fetch('http://localhost/KTPM/controller/qlydocgia_controller.php', {
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
        document.getElementById('docgia_id').value-'';
        document.getElementById('edit_ten').value = '';
        document.getElementById('edit_tuoi').value = '';
        document.querySelector('input[name="edit_gioitinh"]:checked').checked = false; // Đặt lại radio button
        document.getElementById('edit_sdt').value = '';
        document.getElementById('edit_email').value = '';
        loadDocgia(); // Tải lại danh sách độc giả sau cập nhật
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Đã xảy ra lỗi: ' + error.message);
    });
    });
    function deleteDocgia(docgia_id) {
    if (confirm("Bạn có chắc chắn muốn xóa độc giả này?")) {
        fetch(`http://localhost/KTPM/controller/qlydocgia_controller.php?docgia_id=${docgia_id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',  // Đảm bảo rằng headers là json
            }
            // Không cần body vì ID đã được truyền qua URL
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
                loadDocgia();  // Gọi lại hàm để tải lại dữ liệu sau khi xóa
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


// Gọi hàm load_docgia khi trang được tải

window.onload = loadDocgia;
</script>