<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<title>Thông báo mới</title>
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
    .notification {
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
        include 'head.php';
    ?>
    <div class="container mt-4">
        <div class="box clearfix">
            <h2>Thông Báo Mới</h2>
        </div>

            <div class="table-container">
        <div id="notification-list">
            <div class="notification">
                <h4>Thông báo 1</h4>
                <p>Thư viện sẽ tổ chức buổi giới thiệu sách mới vào ngày 15/01/2025.</p>
                <small>Ngày đăng: 10/01/2025</small>
            </div>

            <div class="notification">
                <h4>Thông báo 2</h4>
                <p>Giờ mở cửa thư viện được điều chỉnh: từ 8:00 AM đến 6:00 PM, áp dụng từ tuần sau.</p>
                <small>Ngày đăng: 09/01/2025</small>
            </div>

            <div class="notification">
                <h4>Thông báo 3</h4>
                <p>Thư viện sẽ tạm đóng cửa để bảo trì vào ngày 12/01/2025.</p>
                <small>Ngày đăng: 08/01/2025</small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
