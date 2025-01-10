<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Quản lý người dùng</title>
    <style>
        .box h2 {
            float: left; 
            margin: center; 
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
        include '../model/nguoidung_model.php';
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
                        <button type="submit" class="btn btn-primary" name="timkiem">Tìm kiếm</button>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">Thêm mới</button>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-striped table-hover ">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên người dùng</th>
                    <th>Email</th>
                    <th>Mật khẩu</th>
                    <th>Vai trò</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="nguoidung_table">
            </tbody>
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
                            <div>
                                <label>
                                    <input type="radio" name="vaitro_nguoidung" value="0" id="vaitro_nguoidung_admin">
                                    Admin
                                </label>
                                <label>
                                    <input type="radio" name="vaitro_nguoidung" value="1" id="vaitro_nguoidung_user">
                                    User
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm người dùng</button>
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
                        <h5 class="modal-title" id="editModalLabel">Sửa Thông Tin Người Dùng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nguoidung_id" class="form-label">Mã người dùng</label>
                            <input type="text" class="form-control" id="nguoidung_id" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="edit_ten_nguoidung" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="edit_ten" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email_nguoidung" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_matkhau_nguoidung" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="edit_matkhau" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Vai trò</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_vaitro" value="0" id="edit_vaitro_admin" required>
                                <label class="form-check-label" for="edit_vaitro_admin">Admin</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_vaitro" value="1" id="edit_vaitro_user">
                                <label class="form-check-label" for="edit_vaitro_user">User</label>
                            </div>
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
</body>
</html>
<script>
// Hàm load dữ liệu người dùng
function loadNguoidung() {
    fetch('http://localhost/KTPM/controller/qlynguoidung_controller.php', {
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
        const tableBody = document.getElementById('nguoidung_table');
        tableBody.innerHTML = ''; // Xóa dữ liệu cũ
        data.forEach(nguoidung => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${nguoidung.id_nguoidung}</td>
                <td>${nguoidung.ten_nguoidung}</td>
                <td>${nguoidung.email_nguoidung}</td>
                <td>${nguoidung.vaitro_nguoidung === "0" ? 'Nam' : 'Nữ'}</td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editNguoidung(${nguoidung.id_nguoidung})">Cập nhật</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteNguoidung(${nguoidung.id_nguoidung})">Xoá</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    })
    .catch(error => console.error('Lỗi:', error));
}

// Hàm xử lý khi submit form thêm người dùng
document.getElementById('addForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Ngừng hành động mặc định (reload trang)

    // Tạo đối tượng dữ liệu
    const data = {
        ten_nguoidung: document.getElementById('ten_nguoidung').value,
        email_nguoidung: document.getElementById('email_nguoidung').value,
        matkhau_nguoidung: document.getElementById('matkhau_nguoidung').value,
        vaitro_nguoidung: document.querySelector('input[name="vaitro_nguoidung"]:checked')?.value
    };

    // Kiểm tra xem tất cả các trường có dữ liệu
    if (!data.ten_nguoidung || !data.email_nguoidung || !data.matkhau_nguoidung || !data.vaitro_nguoidung) {
        alert('Vui lòng điền đầy đủ thông tin!');
        return;
    }

    // Gửi dữ liệu đến server qua fetch API
    fetch('http://localhost/KTPM/controller/qlynguoidung_controller.php', {
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
        document.getElementById('ten_nguoidung').value = '';
        document.getElementById('email_nguoidung').value = '';
        document.getElementById('matkhau_nguoidung').value = '';
        document.querySelector('input[name="vaitro_nguoidung"]:checked').checked = false; // Đặt lại radio button
        loadNguoidung(); // Tải lại danh sách người dùng
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Đã xảy ra lỗi: ' + error.message);
    });
});

// Hàm chỉnh sửa người dùng
function editNguoidung(id_nguoidung) {
    fetch(`http://localhost/KTPM/controller/qlynguoidung_controller.php?id=${id_nguoidung}`) 
        .then(response => {
            if (!response.ok) {
                throw new Error(`Lỗi HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(nguoidung => {
            if (nguoidung) {
                document.getElementById('edit_ten').value = nguoidung.ten_nguoidung;
                document.getElementById('edit_email').value = nguoidung.email_nguoidung;
                document.getElementById('edit_matkhau').value = nguoidung.matkhau_nguoidung;
                const vaitro = document.querySelectorAll('input[name="edit_vaitro"]');
                vaitro.forEach(input => {
                    input.checked = (input.value === nguoidung.vaitro_nguoidung);
                });
                document.getElementById('id_nguoidung').value = nguoidung.id_nguoidung;
                $('#editModal').modal('show');
            } else {
                alert("Không tìm thấy thông tin người dùng!");
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert("Lỗi khi tải thông tin người dùng!");
        });
}

// Cập nhật thông tin người dùng
document.getElementById('editForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Ngăn reload trang
    // Tạo đối tượng dữ liệu
    const data = {
        id_nguoidung: document.getElementById('id_nguoidung').value,
        ten_nguoidung: document.getElementById('edit_ten').value,
        email_nguoidung: document.getElementById('edit_email').value,
        matkhau_nguoidung: document.getElementById('edit_matkhau').value,
        vaitro_nguoidung: document.querySelector('input[name="edit_vaitro"]:checked')?.value
    };

    // Gửi dữ liệu đến server qua fetch API
    fetch('http://localhost/KTPM/controller/qlynguoidung_controller.php', {
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
        document.getElementById('id_nguoidung').value = '';
        document.getElementById('edit_ten').value = '';
        document.getElementById('edit_email').value = '';
        document.getElementById('edit_matkhau').value = '';
        document.querySelector('input[name="edit_vaitro"]:checked').checked = false; // Đặt lại radio button
        loadNguoidung(); // Tải lại danh sách người dùng sau cập nhật
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Đã xảy ra lỗi: ' + error.message);
    });
});

// Hàm xóa người dùng
function deleteNguoidung(id_nguoidung) {
    if (confirm("Bạn có chắc chắn muốn xóa người dùng này?")) {
        fetch(`http://localhost/KTPM/controller/qlynguoidung_controller.php?id_nguoidung=${id_nguoidung}`, {
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
                loadNguoidung();  // Gọi lại hàm để tải lại dữ liệu sau khi xóa
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

// Gọi hàm load_nguoidung khi trang được tải
window.onload = loadNguoidung;
</script>




<?php
class Nguoidung {
    private $conn;
    private $table = "nguoidung"; // Changed to nguoidung

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAllNguoidung() {
        $query = "SELECT * FROM nguoidung"; // Changed to nguoidung
        $result = mysqli_query($this->conn, $query);

        // Kiểm tra kết quả và trả về dữ liệu dạng mảng
        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC); // Trả về kết quả dạng mảng liên kết
        } else {
            return [];
        }
    }

    public function readNguoidungById($id) {
        $query = "SELECT * FROM nguoidung WHERE id_nguoidung = $id"; // Changed to nguoidung
        $result = mysqli_query($this->conn, $query);

        // Kiểm tra kết quả và trả về dữ liệu dạng mảng
        if ($result) {
            return mysqli_fetch_assoc($result); // Trả về kết quả dạng mảng kết hợp
        } else {
            return null;
        }
    }

    public function addNguoidung($name, $email, $password, $role) {
        $query = "INSERT INTO nguoidung (ten_nguoidung, email_nguoidung, matkhau_nguoidung, vaitro_nguoidung) 
        VALUES ('$name', '$email', '$password', '$role')"; // Changed to nguoidung
        return mysqli_query($this->conn, $query);
    }

    public function updateNguoidung($id, $name, $email, $password, $role) {
        $query = "UPDATE nguoidung SET ten_nguoidung='$name', email_nguoidung='$email', 
        matkhau_nguoidung='$password', vaitro_nguoidung='$role' WHERE id_nguoidung=$id"; // Changed to nguoidung
        return mysqli_query($this->conn, $query);
    }

    public function deleteNguoidung($id) {
        $query = "DELETE FROM nguoidung WHERE id_nguoidung=$id"; // Changed to nguoidung
        return mysqli_query($this->conn, $query);
    }
}

function readAllNguoidung($nguoidungModel) {
    $nguoidung = $nguoidungModel->readAllNguoidung(); // Changed to nguoidung
    if (count($nguoidung) > 0) {
        echo json_encode($nguoidung); // Trả về danh sách người dùng
    } else {
        echo json_encode(["message" => "Không tồn tại người dùng nào!"]); // Changed to người dùng
    }
}

function readNguoidungById($nguoidungModel) {
    $nguoidung_id = $_GET['id']; // Lấy ID từ URL
    $nguoidung = $nguoidungModel->readNguoidungById($nguoidung_id); // Changed to nguoidung
    if ($nguoidung) {
        echo json_encode($nguoidung); // Trả về dữ liệu người dùng theo ID
    } else {
        echo json_encode(["message" => "Không tìm thấy người dùng nào với ID: $nguoidung_id"]); // Changed to người dùng
    }
}

function addNguoidung($nguoidungModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    if (!isset($data['ten_nguoidung']) || !isset($data['email_nguoidung']) || !isset($data['matkhau_nguoidung']) || !isset($data['vaitro_nguoidung'])) { // Changed to nguoidung
        echo json_encode(["message" => "Thiếu dữ liệu!"]);
        return;
    }
    $name = $data["ten_nguoidung"]; // Changed to nguoidung
    $email = $data["email_nguoidung"]; // Changed to nguoidung
    $password = $data["matkhau_nguoidung"]; // Changed to nguoidung
    $role = $data["vaitro_nguoidung"]; // Changed to nguoidung

    if ($nguoidungModel->addNguoidung($name, $email, $password, $role)) { // Changed to nguoidung
        echo json_encode(["message" => "Thêm người dùng thành công!"]); // Changed to người dùng
    } else {
        echo json_encode(["message" => "Thêm người dùng thất bại!"]); // Changed to người dùng
    }
}

function updateNguoidung($nguoidungModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    if (!isset($data['ten_nguoidung']) || !isset($data['email_nguoidung']) || !isset($data['matkhau_nguoidung']) || !isset($data['vaitro_nguoidung'])) { // Changed to nguoidung
        echo json_encode(["message" => "Thiếu dữ liệu"]);
        return;
    }
    $id = $data["id_nguoidung"]; // Changed to nguoidung
    $name = $data["ten_nguoidung"]; // Changed to nguoidung
    $email = $data["email_nguoidung"]; // Changed to nguoidung
    $password = $data["matkhau_nguoidung"]; // Changed to nguoidung
    $role = $data["vaitro_nguoidung"]; // Changed to nguoidung

    if ($nguoidungModel->updateNguoidung($id, $name, $email, $password, $role)) { // Changed to nguoidung
        echo json_encode(["message" => "Cập nhập thông tin người dùng thành công!"]); // Changed to người dùng
    } else {
        echo json_encode(["message" => "Cập nhật thông tin người dùng thất bại!"]); // Changed to người dùng
    }
}

function deleteNguoidung($nguoidungModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    $id = $data["id_nguoidung"]; // Changed to nguoidung

    if ($nguoidungModel->deleteNguoidung($id)) { // Changed to nguoidung
        echo json_encode(["message" => "Xoá người dùng thành công!"]); // Changed to người dùng
    } else {
        echo json_encode(["message" => "Xóa người dùng thất bại!"]); // Changed to người dùng
    }
}
?>



