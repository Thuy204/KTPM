<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Quản lý phiếu mượn trả</title>
</head>
<body>
include '../view/head.php'

<div class="container">
    <div class="box">
        <h2>DANH SÁCH PHIẾU MƯỢN TRẢ</h2>
            <div class="row align-items-end">
                <div class="col">
                    <input type="text" placeholder="Search" name="tim_muontra" class="form-control">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary" onclick="searchMuontra()">Tìm kiếm</button>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">Thêm mới</button>
                </div>
            </div>
    </div>

    <div class="table-container" >
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Mã mượn trả</th>
            <th>Tên độc giả</th>
            <th>Sách mượn</th>
            <th>Số lượng</th>
            <th>Ngày mượn</th>
            <th>Hạn trả</th>
            <th>Ngày trả</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody id="muontra_table"></tbody>
    </table>

    </div>
    
</div>

<!-- Modal Add -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Thêm mới phiếu mượn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addFormMT">
                    <div class="form-group">
                        <label for="id_docgia" class="form-label">Mã độc giả</label>
                        <input type="number" class="form-control" id="docgia_id" name="id_docgia" placeholder="Nhập mã độc giả" required />
                    </div>
                    <div class="form-group">
                        <label for="ngaymuon" class="form-label">Ngày Mượn</label>
                        <input type="date" class="form-control" id="ngaymuon" name="ngaymuon" required />
                    </div>
                    <div class="form-group">
                        <label for="hantra" class="form-label">Hạn trả</label>
                        <input type="date" class="form-control" id="hantra" name="hantra" required />
                    </div>
                    <div class="form-group">
                        <label for="sach" class="form-label">Mã sách</label>
                        <input type="number" class="form-control" id="sach_id" name="sach" required />
                    </div>
                    <div class="form-group">
                        <label for="soluong" class="form-label">Số lượng</label>
                        <input type="number" class="form-control" id="soluong" name="soluong" required />
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm phiếu mượn</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- Modal edit -->
    <div class="modal fade" id="editModalMT" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editFormMT">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Cập nhật phiếu mượn trả</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="muontra_id" class="form-label">Mã mượn</label>
                            <input type="text" class="form-control" id="muontra_id" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="ten_docgia" class="form-label">Tên độc giả</label>
                            <input type="text" class="form-control" id="edit_tendocgia" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="ten_sach" class="form-label">Sách mượn</label>
                            <input type="text" class="form-control" id="edit_tensach" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="soluong" class="form-label">Số lượng</label>
                            <input type="number" class="form-control" id="edit_soluong" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Ngày mượn</label>
                            <input type="dtae" class="form-control" id="edit_ngaymuon" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Hạn trả</label>
                            <input type="date" class="form-control" id="edit_hantra" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Ngày trả</label>
                            <input type="date" class="form-control" id="edit_ngaytra" required>
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
    </form>
    </div>

<script>
    function setTodayDate() {
        const today = new Date();
        const dd = String(today.getDate()).padStart(2, '0');
        const mm = String(today.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0
        const yyyy = today.getFullYear();

        // Định dạng thành YYYY-MM-DD
        const formattedDate = `${yyyy}-${mm}-${dd}`;
        document.getElementById('ngaymuon').value = formattedDate;
        document.getElementById('edit_ngaytra').value = formattedDate;
    }

    // Sự kiện khi modal được mở
    $('#addModal').on('show.bs.modal', function () {
        setTodayDate(); // Đặt ngày mượn là ngày hôm nay
    });
    $('#editModalMT').on('show.bs.modal', function () {
        setTodayDate(); // Đặt ngày trả là ngày hôm nay
    });
    function loadMuontra() {
        fetch('http://localhost/KTPM/controller/qlmuontra_controller.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json' // Đặt tiêu đề Content-Type là application/json
            }
        })
        .then(response => {
            // Kiểm tra xem phản hồi có hợp lệ không
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json(); // Chuyển đổi phản hồi thành JSON
        })
        .then(data => {
            const tableBody = document.getElementById('muontra_table');
            tableBody.innerHTML = ''; // Xóa dữ liệu cũ trong bảng

            // Duyệt qua từng mục trong dữ liệu và thêm vào bảng
            data.forEach(muontra => {
                const row = document.createElement('tr'); // Tạo một hàng mới cho bảng
                row.innerHTML = `
                    <td>${muontra.muontra_id}</td>
                    <td>${muontra.ten_docgia}</td>
                    <td>${muontra.ten_sach}</td>
                    <td>${muontra.soluong}</td>
                    <td>${muontra.ngaymuon}</td>
                    <td>${muontra.hantra}</td>
                    <td>${muontra.ngaytra || 'Chưa trả'}</td>
                    <td>${muontra.trang_thai}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editMuontra(${muontra.muontra_id})">Trả sách</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteMuontra(${muontra.muontra_id})">Xoá phiếu</button>
                    </td>
                `;
                tableBody.appendChild(row); // Thêm hàng mới vào bảng
            });
        })
        .catch(error => {
            console.error('Lỗi:', error); // Xử lý lỗi nếu có
        });
    }

document.getElementById('addFormMT').addEventListener('submit', function(event) {
    event.preventDefault(); // Ngừng hành động mặc định (reload trang)
    // Tạo đối tượng dữ liệu
    const data = {
        docgia_id: document.getElementById('docgia_id').value,
        ngaymuon: document.getElementById('ngaymuon').value,
        hantra: document.getElementById('hantra').value,
        sach_id: document.getElementById('sach_id').value,
        soluong: document.getElementById('soluong').value,
    };

    fetch('http://localhost/KTPM/controller/qlmuontra_controller.php', {
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
        document.getElementById('docgia_id').value = '';
        document.getElementById('ngaymuon').value = '';
        document.getElementById('hantra').value = '';
        document.getElementById('sach_id').value = '';
        document.getElementById('soluong').value = '';
        loadMuontra(); // Tải lại danh sách độc giả
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Đã xảy ra lỗi: ' + error.message);
    });
    });
    function editMuontra(muontra_id) {
    fetch(`http://localhost/KTPM/controller/qlmuontra_controller.php?id=${muontra_id}`,{
            method: 'GET',
            headers: {
                'Content-Type': 'application/json' // Đặt tiêu đề Content-Type là application/json
            }
        }
        
    ) 
        .then(response => {
            if (!response.ok) {
                throw new Error(`Lỗi HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(muontra => {
            if (muontra) {
                document.getElementById('muontra_id').value = muontra.muontra_id;
                document.getElementById('edit_tendocgia').value = muontra.ten_docgia;
                document.getElementById('edit_tensach').value = muontra.ten_sach;
                document.getElementById('edit_soluong').value = muontra.soluong;
                document.getElementById('edit_ngaymuon').value = muontra.ngaymuon;
                document.getElementById('edit_hantra').value = muontra.hantra;
                document.getElementById('edit_ngaytra').value = muontra.ngaytra;
                $('#editModalMT').modal('show');
            } else {
                alert("Không tìm thấy thông tin phiếu mượn trả!");
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert("Lỗi khi tải thông tin phiếu!");
        });
}
document.getElementById('editFormMT').addEventListener('submit', function (event) {
    event.preventDefault(); // Ngăn reload trang
    const muontra_id = document.getElementById('muontra_id').value;
    // Tạo đối tượng dữ liệu
    const data = {
        muontra_id: muontra_id,
        ngaytra: document.getElementById('edit_ngaytra').value

    };
    // Gửi dữ liệu đến server qua fetch API
    fetch('http://localhost/KTPM/controller/qlmuontra_controller.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json' // Đặt tiêu đề Content-Type là application/json
        },
        body: JSON.stringify(data) // Chuyển đổi đối tượng thành chuỗi JSON
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Hiển thị thông báo từ server
        $('#addModalMT').modal('hide'); // Đóng modal
        // Reset các trường nhập liệu
                document.getElementById('muontra_id').value = '';
                document.getElementById('edit_tendocgia').value = '';
                document.getElementById('edit_tensach').value = '';
                document.getElementById('edit_soluong').value = '';
                document.getElementById('edit_ngaymuon').value = '';
                document.getElementById('edit_hantra').value = '';
                document.getElementById('edit_ngaytra').value = '';
        loadMuontra(); // Tải lại danh sách độc giả sau cập nhật
    })
    .catch(error => {
        console.error('Lỗi:', error);
        alert('Đã xảy ra lỗi: ' + error.message);
    });
    });
    function deleteMuontra(muontra_id) {
    if (confirm("Bạn có chắc chắn muốn xóa phiếu mượn trả này?")) {
        fetch(`http://localhost/KTPM/controller/qlmuontra_controller.php?muontra_id=${muontra_id}`, {
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
                alert("Xóa phiếu thành công!");
                loadMuontra();  // Gọi lại hàm để tải lại dữ liệu sau khi xóa
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
function searchMuontra() {
    const giatri_tim = document.querySelector('input[name="tim_muontra"]').value; // Lấy giá trị từ ô tìm kiếm

    fetch(`http://localhost/KTPM/controller/qlmuontra_controller.php?timkiem=${encodeURIComponent(giatri_tim)}`, {
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
        const tableBody = document.getElementById('muontra_table');
        tableBody.innerHTML = ''; // Xóa dữ liệu cũ trong bảng

        // Duyệt qua từng mục trong dữ liệu và thêm vào bảng
        if (data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="9" class="text-center">Không tìm thấy kết quả.</td></tr>';
        } else {
            data.forEach(muontra => {
                const row = document.createElement('tr'); // Tạo một hàng mới cho bảng
                row.innerHTML = `
                    <td>${muontra.muontra_id}</td>
                    <td>${muontra.ten_docgia}</td>
                    <td>${muontra.ten_sach}</td>
                    <td>${muontra.soluong}</td>
                    <td>${muontra.ngaymuon}</td>
                    <td>${muontra.hantra}</td>
                    <td>${muontra.ngaytra || 'Chưa trả'}</td>
                    <td>${muontra.trang_thai}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editMuontra(${muontra.muontra_id})">Trả sách</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteMuontra(${muontra.muontra_id})">Xoá phiếu</button>
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

window.onload = loadMuontra;
</script>

</body>
</html>