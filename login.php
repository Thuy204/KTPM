<?php include'config/db.php';
      session_start();
  
      if(isset($_POST['dangnhap'])){
        $email=$_POST['email'];
        $pass= $_POST['pass'];
        $query="SELECT *FROM nguoidung WHERE email_nguoidung= '$email'AND matkhau_nguoidung='$pass'";
        $result=mysqli_query($conn, $query);
        if(mysqli_num_rows($result)==1){
          $_SESSION['login']= $email;
          echo "<script type='text/javascript'>
                        alert('Đăng nhập thành công!');
                        window.location.href='frontend/trangchu.php';
                      </script>";
        }
        else{
          echo "<script type='text/javascript'>
                        alert('Email hoặc mật khẩu không đúng. Vui lòng nhập lại.');
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
    <title>Đăng nhập</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
    <link rel="stylesheet" href="frontend/style.css">
</head>
<body>
<div class="layout">
      <div class="container">
        <div class="text-center">
          <img src="img/background/logo1.jpg"
                    style="width: 70px;" alt="logo">
          <h3 class="mb-3 mt-3">ĐĂNG NHẬP</h3>
        </div>
        <form method="POST">
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <label class="form-label" for="form2Example1">Email</label>
              <input type="email" id="form2Example1" class="form-control" placeholder="Enter email" name="email" required/>
            </div>
          
            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <label class="form-label" for="form2Example2">Mật khẩu</label>
              <input type="password" id="form2Example2" class="form-control" placeholder="Enter password" name="pass" required/>
            </div>
          
            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">
              <div class="col">
          
                <a href="#!">Quên mật khẩu?</a>
              </div>
            </div>
          
            <!-- Submit button -->
            <button data-mdb-ripple-init type="submit" name="dangnhap" class="btn btn-primary btn-block mt-2 mb-4 col-lg-12">Đăng nhập</button>
          
            <!-- Register buttons -->
            <div class="text-center">
              <p>Bạn chưa có tài khoản? <a href="signup.php">Đăng ký</a></p>
            </div>
          </form>
        </div>

    </div>
    
</body>
</html>

