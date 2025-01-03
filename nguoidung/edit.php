<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Thông Tin Tài Khoản</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            position: relative;
            z-index: 1;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 30px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            color: #333;
        }

        input[type="text"],
        textarea,
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
            color: #333;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-bottom: 15px;
            color: green;
            text-align: center;
        }

        .error {
            margin-bottom: 15px;
            color: red;
            text-align: center;
        }

        .back-link {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
            text-align: center;
            width: 100%;
        }

        .back-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Sửa Thông Tin Tài Khoản</h1>
        <?php
        require_once '../config/db.php';
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST["id"];
            $ten_nguoidung = $_POST["ten_nguoidung"];
            $email_nguoidung = $_POST["email_nguoidung"];
            $matkhau_nguoidung = $_POST["matkhau_nguoidung"];
            $vaitro_nguoidung = $_POST["vaitro_nguoidung"];

            $sql = "UPDATE nguoidung SET ten_nguoidung='$ten_nguoidung', email_nguoidung='$email_nguoidung',matkhau_nguoidung='$matkhau_nguoidung',vaitro_nguoidung='$vaitro_nguoidung' WHERE id_nguoidung=$id";

            if ($conn->query($sql) === TRUE) {
                header("Location: index.php"); // Chuyển hướng về trang quản lý nhà xuất bản sau khi cập nhật thành công
                exit();
            } else {
                echo "Lỗi: " . $conn->error;
            }
        }

        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $sql = "SELECT * FROM nguoidung WHERE id_nguoidung=$id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <!-- form HTML để cập nhật thông tin -->
                <form method="post" action="edit.php">
                    <input type="hidden" name="id" value="<?php echo $row['id_nguoidung']; ?>">
                    <div class="mb-3">
                        <label for="ten_nguoidung" class="form-label">Tên Tài Khoản</label>
                        <input type="text" class="form-control" id="ten_nguoidung" name="ten_nguoidung" value="<?php echo $row['ten_nguoidung']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email_nguoidung" class="form-label">Email </label>
                        <textarea class="form-control" id="email_nguoidung" name="email_nguoidung" rows="2" required><?php echo $row['email_nguoidung']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="matkhau_nguoidung" class="form-label">Mật Khẩu </label>
                        <textarea class="form-control" id="matkhau_nguoidung" name="matkhau_nguoidung" rows="2" required><?php echo $row['matkhau_nguoidung']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="vaitro_nguoidung" class="form-label">Vai Trò </label>
                        <textarea class="form-control" id="vaitro_nguoidung" name="vaitro_nguoidung" rows="2" required><?php echo $row['vaitro_nguoidung']; ?></textarea>
                    </div>
                    <button type="submit"  class="btn btn-primary">Cập Nhật</button>
                </form>
                <?php
            } else {
                echo "Không tìm thấy người dùng.";
            }
        }

        $conn->close();
        ?>
        <a href="index.php" class="back-link">Quay lại</a>
    </div>
</body>

</html>
