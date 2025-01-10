<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QLTV</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">  
</head>
<body>
    <section class="head">
        <div class="nav">
            <nav class="navbar navbar-expand-sm bg-dark w-100">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <img src="../img/background/logo.png" alt="Logo" style="width:200px; border-radius: 5px;">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="trangchu.php">Trang chủ</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Tin tức
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="thongbaomoi.php">Thông báo mới</a></li>
                                    <li><a class="dropdown-item" href="hoatdongsv.php">Hoạt động sinh viên</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Khác</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link text-white dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Quản lý
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="nguoidung_view.php">Tài Khoản</a></li>
                                    <li><a class="dropdown-item" href="sach_view.php">Sách</a></li>
                                    <li><a class="dropdown-item" href="docgia_view.php">Độc giả</a></li>
                                    <li><a class="dropdown-item" href="tacgia_view.php">Tác giả</a></li>
                                    <li><a class="dropdown-item" href="nxb_view.php">Nhà xuất bản</a></li>
                                    <li><a class="dropdown-item" href="theloai_view.php">Thể loại</a></li>
                                    <li><a class="dropdown-item" href="csvc_view.php">Cơ sở vật chất</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="muontra_view.php">Mượn trả</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="hotro.php">Hỗ Trợ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="../logout.php">Đăng xuất</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="d-flex justify-content-center my-3">
            <img src="../img/nguoidung/UttBanner.png" alt="Vibrant Cityscape at Night" class="img-fluid" />
        </div>
    </section>
</body>
</html>
