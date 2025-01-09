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
        include '../frontend/head.php'; // Thay đổi đường dẫn nếu cần
        include '../config/db.php'; // Thay đổi đường dẫn nếu cần
    ?>
    <div class="container">
        <div class="box">
            <h2>DANH SÁCH THỂ LOẠI</h2>
            <!-- Form tìm kiếm -->
            <form action="search_theloai.php" method="POST">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Search" name="tim_theloai">
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" name="timkiem">Tìm kiếm</button>
                        <button type="button" class="btn btn-success" id="button-add">Add</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- Bảng hiển thị danh sách thể loại -->
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Thể Loại</th>
                    <th>Thông tin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="theloai_table">
                
            </tbody>
        </table>
        <!-- Nút thêm mới và modal -->
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


        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Thêm mới thể loại</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm">
                            <div class="form-group">
                                <label for="ten_theloai">Tên thể loại</label>
                                <input type="text" class="form-control" id="ten_theloai" required>
                            </div>
                            <div class="form-group">
                                <label for="thongtin_theloai">Thông tin</label>
                                <textarea class="form-control" id="thongtin_theloai" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm thể loại</button>
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
                            <h5 class="modal-title" id="editModalLabel">Sửa Thông Tin Thể Loại</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- <input type="hidden" id="docgia_id"> -->
                            <div class="mb-3">
                                <label for="theloai_id" class="form-label">ID</label>
                                <input type="text" class="form-control" id="theloai_id" disabled>
                            </div>
                            <div class="form-group">
                                <label for="edit_ten_theloai">Tên thể loại</label>
                                <input type="text" class="form-control" id="edit_ten_theloai" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_thongtin_theloai">Thông tin</label>
                                <textarea class="form-control" id="edit_thongtin_theloai" required></textarea>
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

    </div>
</body>
<script>

    document.getElementById('button-add').addEventListener('click', function() {
        $('#addModal').modal('show');
    });

    function loadTheloai() {
        fetch('http://localhost/KTPM/controller/qlytheloai_controller.php', {
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
            const tableBody = document.getElementById('theloai_table');
            tableBody.innerHTML = ''; // Xóa dữ liệu cũ
            data.forEach(theloai => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${theloai.theloai_id}</td>
                    <td>${theloai.ten_theloai}</td>
                    <td>${theloai.thongtin_theloai}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editTheloai(${theloai.theloai_id})">Update</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteTheloai(${theloai.theloai_id})">Delete</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Lỗi:', error));
    }

    document.getElementById('addForm').addEventListener('submit', function(event) {
        event.preventDefault(); 

        const data = {
            ten_theloai: document.getElementById('ten_theloai').value,
            thongtin_theloai: document.getElementById('thongtin_theloai').value
        };

        if (!data.ten_theloai || !data.thongtin_theloai) {
            alert('Vui lòng điền đầy đủ thông tin!');
            return;
        }

        fetch('http://localhost/KTPM/controller/qlytheloai_controller.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json' // Đặt tiêu đề Content-Type là application/json
            },
            body: JSON.stringify(data) // Chuyển đổi đối tượng thành chuỗi JSON
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); // Hiển thị thông báo từ server
            // Reset các trường nhập liệu
            document.getElementById('ten_theloai').value = '';
            document.getElementById('thongtin_theloai').value = '';
            loadTheloai(); // Tải lại danh sách thể loại
            $('#addModal').modal('hide');
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Đã xảy ra lỗi: ' + error.message);
        });
    });


    function deleteTheloai(theloai_id) {
        if (confirm("Bạn có chắc chắn muốn xóa thể loại này?")) {
            fetch(`http://localhost/KTPM/controller/qlytheloai_controller.php?theloai_id=${theloai_id}`, {
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
                    loadTheloai();  // Gọi lại hàm để tải lại dữ liệu sau khi xóa
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


    function editTheloai(theloai_id) {
        fetch(`http://localhost/KTPM/controller/qlytheloai_controller.php?id=${theloai_id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Lỗi HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(theloai => {
                if (theloai) {
                    document.getElementById('edit_ten_theloai').value = theloai.ten_theloai;
                    document.getElementById('edit_thongtin_theloai').value = theloai.thongtin_theloai;
                    document.getElementById('theloai_id').value = theloai.theloai_id;
                    $('#editModal').modal('show');
                } else {
                    alert("Không tìm thấy thông tin thể loại!");
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alert("Lỗi khi tải thông tin thể loại!");
            });
    }


    document.getElementById('editForm').addEventListener('submit', function (event) {
        event.preventDefault(); 

        const data = {
            theloai_id: document.getElementById('theloai_id').value,
            ten_theloai: document.getElementById('edit_ten_theloai').value,
            thongtin_theloai: document.getElementById('edit_thongtin_theloai').value
        };

        fetch('http://localhost/KTPM/controller/qlytheloai_controller.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json' 
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message); 
            document.getElementById('theloai_id').value = '';
            document.getElementById('edit_ten_theloai').value = '';
            document.getElementById('edit_thongtin_theloai').value = '';
            loadTheloai();
            $('#editModal').modal('hide');

        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Đã xảy ra lỗi: ' + error.message);
        });
    });



    window.onload = loadTheloai;
</script>
</html>
