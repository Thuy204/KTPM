<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<title>Hoạt động sinh viên</title> 
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
        include '../frontend/head.php';
    ?>

    <div class="container mt-4">
        <div class="box clearfix">
            <h2>Hoạt động Sinh Viên</h2>
        </div>

        <div class="table-container">
        <div id="student-activities">
            <div class="notification">
                <h4>Hoạt động 1: Chương trình thiện nguyện</h4>
                <p>Sinh viên tham gia chương trình thiện nguyện tại xã A, huyện B vào ngày 20/01/2025.</p>
                <small>Ngày đăng: 10/01/2025</small>
            </div>

            <div class="notification">
                <h4>Hoạt động 2: Hội thảo kỹ năng mềm</h4>
                <p>Hội thảo "Kỹ năng giao tiếp hiệu quả" sẽ diễn ra tại hội trường lớn vào ngày 25/01/2025.</p>
                <small>Ngày đăng: 09/01/2025</small>
            </div>

            <div class="notification">
                <h4>Hoạt động 3: Giải bóng đá sinh viên</h4>
                <p>Đăng ký tham gia giải bóng đá sinh viên tại văn phòng Đoàn trước ngày 15/01/2025.</p>
                <small>Ngày đăng: 08/01/2025</small>
            </div>
        </div>
        </div>
    </div>
</body>
</html>
