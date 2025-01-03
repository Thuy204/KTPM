<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Thông Tin Tài Khoản</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.9); /* Add some transparency */
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            text-align: left;
        }

        input[type="text"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            color: #333;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
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
    <div class="background-blur"></div>
    <div class="container">
        <h1>Thêm Thông Tin Tài Khoản</h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $conn = mysqli_connect("localhost", "root", "", "qly_thuvien");
            if (!$conn) {
                die("Kết nối không thành công: " . mysqli_connect_error());
            }
            $id_nguoidung = $_POST['id_nguoidung'];
            $ten_nguoidung = $_POST['ten_nguoidung'];
            $email_nguoidung = $_POST['email_nguoidung'];
            $matkhau_nguoidung = $_POST['matkhau_nguoidung'];
            $vaitro_nguoidung = $_POST['vaitro_nguoidung'];
            $query = "INSERT INTO nguoidung (id_nguoidung, ten_nguoidung, email_nguoidung, matkhau_nguoidung, vaitro_nguoidung) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssss", $id_nguoidung, $ten_nguoidung, $email_nguoidung, $matkhau_nguoidung, $vaitro_nguoidung);

            if ($stmt->execute()) {
                echo "<p class='message'>Thêm Tài Khoản Thành Công</p>";
            } else {
                echo "<p class='error'>Lỗi: " . $stmt->error . "</p>";
            }

            $stmt->close();
            mysqli_close($conn);
        }
        ?>
        <form method="POST">
            <label for="id_nguoidung">ID:</label>
            <input type="text" id="id_nguoidung" name="id_nguoidung" required><br>
            <label for="ten_nguoidung">Tên tài khoản :</label>
            <input type="text" id="ten_nguoidung" name="ten_nguoidung" required><br>
            <label for="email_nguoidung">Email :</label>
            <input type="text" id="email_nguoidung" name="email_nguoidung" required><br>
            <label for="matkhau_nguoidung">Mật khẩu :</label>
            <input type="text" id="matkhau_nguoidung" name="matkhau_nguoidung" required><br>
            <label for="vaitro_nguoidung">Vai  trò :</label>
            <input type="text" id="vaitro_nguoidung" name="vaitro_nguoidung" required><br>
            <button type="submit" name="btnSave">Lưu</button>
        </form>
        <a href="index.php" class="back-link">Quay lại</a>
    </div>
</body>

</html>