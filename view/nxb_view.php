<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Quản lý Nhà Xuất Bản</title>

</head>
<body>
    <?php
        include '../view/head.php'
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
                    <th>Tên</th>
                    <th>Thông tin</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="nhaxuatban_table"></tbody>
        </table>
        </div>
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
                <form id="addFormMT">
                    <div class="form-group">
                        <label for="id_nxb" class="form-label">ID</label>
                        <input
                            type="number"
                            class="form-control"
                            id="nxb_id"
                            name="id_nxb"
                            placeholder="ID sẽ được tự động tạo"
                            readonly
                            required
                        />
                    </div>
                    <div class="form-group">
                        <label for="ten_nxb" class="form-label">Tên</label>
                        <input
                            type="text"
                            class="form-control"
                            id="ten_nxb"
                            name="ten_nxb"
                            placeholder="Nhập tên nhà xuất bản"
                            required
                        />
                    </div>
                    <div class="form-group">
                        <label for="thongtin_nxb" class="form-label">Thông tin</label>
                        <input
                            type="text"
                            class="form-control"
                            id="thongtin_nxb"
                            name="thongtin_nxb"
                            placeholder="Nhập thông tin nhà xuất bản"
                            required
                        />
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm nhà xuất bản</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Gọi hàm tạo ID tự động khi modal được mở
    document.addEventListener("DOMContentLoaded", function () {
        const addModal = document.getElementById("addModal");
    //DOMContentLoaded: Sự kiện kích hoạt khi trình duyệt hoàn tất việc tải DOM của trang 
        addModal.addEventListener("shown.bs.modal", function () {
            //shown.bs.modal là t sự kiện được cc bởi  Bootstrap  để lắng nghe khi một modal đã hiển thị hoàn toàn trên giao diện.
            const idField = document.getElementById("nxb_id");
            idField.value = generateUniqueID(); // Gọi hàm để tạo ID tự động
        });
    });

    function generateUniqueID() {
        return Math.floor(Math.random() * 1000000); // Tạo ID ngẫu nhiên trong khoảng từ 0 đến 999999
    }
</script>


<!-- Modal Edit -->
<div class="modal fade" id="editModalMT" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editFormMT">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Cập nhật nhà xuất bản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_nxb" class="form-label">ID</label>
                        <input type="number" class="form-control" id="edit_idnxb" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="ten_nxb" class="form-label">Tên</label>
                        <input type="text" class="form-control" id="edit_tennxb" required>
                    </div>
                    <div class="mb-3">
                        <label for="thongtin_nxb" class="form-label">Thông tin</label>
                        <input type="text" class="form-control" id="edit_thongtinnxb" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Xác nhận</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function loadnxb() {
        fetch('http://localhost/KTPM/controller/qlynxb_controller.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const tableBody = document.getElementById('nhaxuatban_table');
            tableBody.innerHTML = ''; 

            data.forEach(nxb => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${nxb.nxb_id}</td>
                    <td>${nxb.ten_nxb}</td>
                    <td>${nxb.thongtin_nxb}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editnxb(${nxb.nxb_id})">Sửa</button>
                        <button class="btn btn-danger btn-sm" onclick="deletenxb(${nxb.nxb_id})">Xóa</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Lỗi:', error);
        });
    }

    document.getElementById('addFormMT').addEventListener('submit', function(event) {
        event.preventDefault();

        const data = {
            nxb_id: document.getElementById('nxb_id').value,
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
            $('#addModal').modal('hide');
            loadnxb();
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Đã xảy ra lỗi: ' + error.message);
        });
    });

    function editnxb(nxb_id) {
        fetch(`http://localhost/KTPM/controller/qlynxb_controller.php?id=${nxb_id}`,{
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Lỗi HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(nxb => {
            if (nxb) {
                document.getElementById('edit_idnxb').value = nxb.nxb_id;
                document.getElementById('edit_tennxb').value = nxb.ten_nxb;
                document.getElementById('edit_thongtinnxb').value = nxb.thongtin_nxb;
                $('#editModalMT').modal('show');
            } else {
                alert("Không tìm thấy nhà xuất bản!");
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert("Lỗi khi tải thông tin nhà xuất bản!");
        });
    }

    document.getElementById('editFormMT').addEventListener('submit', function(event) {
        event.preventDefault();

        const data = {
            nxb_id: document.getElementById('edit_idnxb').value,
            ten_nxb: document.getElementById('edit_tennxb').value,
            thongtin_nxb: document.getElementById('edit_thongtinnxb').value
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
            $('#editModalMT').modal('hide');
            loadnxb();
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Đã xảy ra lỗi: ' + error.message);
        });
    });

    function deletenxb(nxb_id) {
        if (confirm("Bạn có chắc chắn muốn xóa nhà xuất bản này?")) {
            fetch(`http://localhost/KTPM/controller/qlynxb_controller.php?nxb_id=${nxb_id}`, {
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
                    loadnxb();  // Gọi lại hàm để tải lại dữ liệu sau khi xóa
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

    function searchNhaxuatban() {
    const giatri_tim = document.querySelector('input[name="tim_nxb"]').value; // Lấy giá trị từ ô tìm kiếm
    fetch(`http://localhost/KTPM/controller/qlynxb_controller.php?timkiem=${encodeURIComponent(giatri_tim)}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        const tableBody = document.getElementById('nhaxuatban_table');
        tableBody.innerHTML = ''; // Xoá dữ liệu cũ trong bảng
        if (data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="4" class="text-center">Không tìm thấy kết quả.</td></tr>';
        } else {
            data.forEach(nxb => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${nxb.nxb_id}</td>
                    <td>${nxb.ten_nxb}</td>
                    <td>${nxb.thongtin_nxb}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editnxb(${nxb.nxb_id})">Sửa</button>
                        <button class="btn btn-danger btn-sm" onclick="deletenxb(${nxb.nxb_id})">Xóa</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Đã xảy ra lỗi khi tìm kiếm: ' + error.message);
    });
}

    // Load all publishers when the page loads
    window.onload = loadnxb;
</script>
</body>
</html>
