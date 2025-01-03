<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Quản lý cơ sở vật chất</title>
    <style>
        .box h2{
            float:left; 
            margin: 10px; 
        }
        .box form{
            float: right;
            margin: 10px;
        }
        
    </style>
</head>
<body>
    <?php
        include '../view/head.php';
        include '../config/db.php';
    ?>
    <div class="container" >
        <div class="box">
            <h2>DANH SÁCH CƠ SỞ VẬT CHẤT</h2>
            <form action="search_csvc.php" method="POST">
            <div class="row"><script type="module"></script>
                <div class="col">
                    <input type="text" placeholder="Search" name="tim_csvc">
                </div>
                <div class="col">
                    <button class="btn btn-primary" name="timkiem">Tìm kiếm</button>
                </div>
            </div>
            </form>
        </div>
    <table class="table table-striped table-hover">
        <thead>
            <th>STT</th>
            <th>Mã</th>
            <th>Tên</th>
            <th>Số lượng</th>
            <th>Tình trạng</th>
            <th>Sửa</th>
            <th>Xóa</th>
        </thead>
        <tbody>
            <?php
                $query="SELECT* FROM cosovatchat";
                $result= mysqli_query($conn, $query);
                $num=1;
                if(!$result){
                    echo "Không có dữ liệu ";
                }else{
                    while($row= mysqli_fetch_assoc($result)){
                        echo"
                        <tr>
                        <td>".($num++)."</td>
                        <td>".$row["csvc_id"]."</td>
                        <td>".$row["ten_csvc"]."</td>
                        <td>".$row["soluong_csvc"]."</td>
                        <td>".($row["tinhtrang_csvc"] == 1 ? 'Mới' : 'Cũ')."</td>
                        <td><a href='edit_csvc.php?id=".$row["csvc_id"]."' class='btn btn-success'>Sửa</a></td>
                        <td><a onclick ='return confirm(\"Bạn có chắc chắn muốn xóa không?\");' 
                        href='delete_csvc.php?id=".$row['csvc_id']."' class='btn btn-danger'>Xóa</a></td>
                        </tr>";


                    }
                    echo "</tbody>
                            </table>";
                }
            ?>
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Thêm mới</button>
            <form action="create_csvc.php" method="POST">
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Thêm mới cơ sở vật chất</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                            <div class="form-group">
                                <label>ID</label>
                                <input type="number" name="id_csvc" placeholder="Enter ID" class="form-control" required>
                                <label>Tên CSVC</label>
                                <input type="text" name="ten_csvc" placeholder="Enter Name" class="form-control" required>
                                <label>Số Lượng</label>
                                <input type="number" name="sl_csvc" placeholder="Enter number" class="form-control" required>
                                <label>Tình Trạng</label>
                                <div class="radio">
                                        <label><input type="radio" name="tt_csvc" checked="checked" value="1">Mới</label>
                                        <label><input type="radio" name="tt_csvc" value="0">Cũ</label>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <input type="submit" class="btn btn-success" name="them_csvc" value="Thêm mới">
                    </div>
                    </div>
                </div>
                </div>
                </form>
            
    </div>  

    <script>
// Hàm load dữ liệu cơ sở vật chất
function load_csvc() {
    fetch('http://localhost/QLTV/controller/qlycsvc_controller.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const tableBody = document.getElementById('csvc_table');
            tableBody.innerHTML = ''; // Xóa dữ liệu cũ

            if (!data.data || !Array.isArray(data.data)) {
                console.error('Dữ liệu trả về không phải là mảng');
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Lỗi dữ liệu</td></tr>';
                return;
            }

            if (data.data.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>';
            } else {
                console.log(data);
                data.data.forEach(csvc => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${csvc.csvc_id}</td>
                        <td>${csvc.ten_csvc}</td>
                        <td>${csvc.soluong_csvc}</td>
                        <td>${csvc.tinhtrang_csvc === '1' ? 'Sẵn sàng' : 'Hỏng'}</td>
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

    // Tạo đối tượng FormData để gửi dữ liệu
    const formData = new FormData();
    formData.append('ten_csvc', document.getElementById('ten_csvc').value);
    formData.append('soluong_csvc', document.getElementById('soluong_csvc').value);
    formData.append('tinhtrang_csvc', document.querySelector('input[name="tinhtrang_csvc"]:checked')?.value);

    // Gửi dữ liệu đến server qua fetch API
    fetch('http://localhost/QLTV/controller/qlycsvc_controller.php', {
        method: 'POST',
        body: formData, // Dữ liệu form
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 201) {
            $('#addModal').modal('hide');  // Đóng modal sau khi thêm thành công
            window.location.reload(); // Reload lại trang
        } else {
            alert(data.message); // Thông báo lỗi
        }
    })
    .catch(error => {
        console.error('Lỗi:', error);
    });
});

// Gọi hàm load_csvc khi trang được tải
window.onload = load_csvc;
</script>
</body>
</html>