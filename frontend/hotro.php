<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<title>Hỗ trợ sinh viên</title> 
<style>
    .box h2 {
        float: left; 
        margin: 10px; 
    }
    .box form {
        float: right;
        margin: 10px;
    }
    .support {
        padding: 20px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    .box {
        position: sticky;
        top: 0;
        background: white;
        z-index: 1000;
        padding: 10px 0;
    }
    .table-container {
        max-height: 400px; /* Chiều cao tối đa của bảng */
        overflow-y: auto;
        margin-top: 20px;
    }
</style>
</head>
<body>
    <?php
        include '../frontend/head.php';
    ?>

    <div class="container mt-4">
        <div class="box clearfix">
            <h2>Hỗ Trợ Sinh Viên</h2>
        </div>

        <div class="table-container">
        <div id="student-support">
            <div class="support">
                <h4>Hỗ trợ 1: Tư vấn tâm lý</h4>
                <p>Trung tâm hỗ trợ sinh viên cung cấp dịch vụ tư vấn tâm lý miễn phí vào các ngày thứ Hai và thứ Năm hàng tuần.</p>
                <small>Thông báo: 10/01/2025</small>
            </div>

            <div class="support">
                <h4>Hỗ trợ 2: Hỗ trợ tài chính</h4>
                <p>Chương trình hỗ trợ tài chính cho sinh viên khó khăn đang mở đơn đăng ký đến ngày 31/01/2025.</p>
                <small>Thông báo: 09/01/2025</small>
            </div>

            <div class="support">
                <h4>Hỗ trợ 3: Hướng dẫn học tập</h4>
                <p>Thư viện tổ chức các buổi hướng dẫn sử dụng tài liệu và kỹ năng học tập vào thứ Tư hàng tuần.</p>
                <small>Thông báo: 08/01/2025</small>
            </div>
        </div>
        </div>
    </div>
</body>
</html>
