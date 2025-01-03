<?php include'config/db.php';
  
      if(isset($_POST['dangky'])){
        $id="";
        $name=$_POST['ten'];
        $email= $_POST['email'];
        $pass= $_POST['matkhau'];
        $level= "nhân viên";
        
        // $password=password_hash($pass,PASSWORD_DEFAULT);
        $query="INSERT INTO nguoidung (id_nguoidung, ten_nguoidung, email_nguoidung, matkhau_nguoidung, vaitro_nguoidung) 
        VALUES ('$id', '$name','$email','$pass','$level') ";
        $result=mysqli_query($conn, $query);
        if($result){
          echo "<script type='text/javascript'>
                        alert('Chúc mừng bạn đã đăng ký thành công!');
                        window.location.href='login.php';
                      </script>";
        }
      }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
    <link rel="stylesheet" href="view/style.css">
    <style>
      body{
          margin: 0px;
          padding: 0px;
          background-image: url('img/background/bg.jpg'); 
          background-size: cover; 
          background-position: center; 
        }
        
    </style>
</head>
<body>
<div class="layout">
      <div class="container">
        <div class=" text-center">
          <img src="img/background/logo1.jpg"
                    style="width: 70px;" alt="logo">
          <h3 class="mb-3 mt-3">ĐĂNG KÝ TÀI KHOẢN</h3>
        </div>
        <form method="POST" class="was-validated">
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label">Tên người dùng</label>
                <input type="text" class="form-control" name="ten" placeholder="Enter username" required />
                <div class="valid-feedback"></div>
            </div>
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" >Email</label>
                <input type="email" class="form-control" name="email" placeholder="Enter email" required/>
                <div class="valid-feedback"></div>
            </div>
          
            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <label class="form-label" >Mật khẩu</label>
                <input type="password"  class="form-control" name="matkhau" placeholder="Enter password" required />
                <div class="valid-feedback"></div>
            </div>
            <!-- Submit button -->
            <button data-mdb-ripple-init type="submit" name="dangky" class="btn btn-primary btn-block mt-2 mb-4 col-lg-12">Đăng ký</button>
          
            <!-- Register buttons -->
            <div class="text-center">
              <p>Bạn đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
            </div>
          </form>
        </div>

    </div>
    
</body>
</html>