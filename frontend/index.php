<?php
session_start();
    if(!isset($_SESSION['login'])){
      header('Location: login.php');
    }
?>
<?php
      include '../frontend/head.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <style>
        .td-gioithieu{
          border: 10px double #ffffff;
          width: 80%; 
          color: white;
          padding: 50px;
          text-align: justify;
          background-color: #8FBC8F;
        }
    </style>
</head>
<body>
    <section class="content my-3">
            <div class="slider">
                <div id="carouselExampleCaptions" class="carousel slide">
                    <div class="carousel-indicators">
                      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    </div>
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="../img/background/sl1.jpg" class="d-block w-100" alt="Thư viện UTT" style="height: 600px;">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                      </div>
                      <div class="carousel-item">
                        <img src="../img/background/sl2.jpg" class="d-block w-100" alt="Thư viện UTT" style="height: 600px;">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                      </div>
                      <div class="carousel-item">
                        <img src="../img/background/sl3.jpg" class="d-block w-100" alt="Thư viện UTT" style="height: 600px;">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                      </div>
                      <div class="carousel-item">
                        <img src="../img/background/sl4.jpg" class="d-block w-100" alt="Thư viện UTT" style="height: 600px;">
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                      </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                  </div>
            </div>
                <table>
                  <tr>
                    <td class="td-gioithieu">
                    Thư viện UTT thay áo mới...!
                    Với phương châm không ngừng đổi mới để hoàn thiện, đến nay trung tâm Thư viện của trường ĐH Công nghệ GTVT (UTT) đã khoác lên mình một chiếc áo mới vô cùng “sang-xịn-mịn” góp phần không nhỏ trong việc nâng cao chất lượng đào tạo và nghiên cứu khoa học trong nhà trường, cung cấp thông tin cơ bản cho bạn đọc. 
                    Gây ấn tượng ban đầu là thư viện được đặt ở một nơi rất thông thoáng, xung quanh có hàng cây xanh che phủ, hàng ngày mở cửa để đón nhận luồng ánh sánh tự nhiên cùng hệ thống đèn chiếu, điều hoà cao cấp luôn hoạt động hết công suất. Bên trong những dãy bàn ghế xinh xắn, màu sắc thanh thoát tạo một cảm giác vô cùng ấm áp và mang chất riêng của UTT. 
                    Đặc biệt, với hệ thống tài liệu phong phú trên các lĩnh vực được sắp xếp một cách ngăn nắp, khoa học người đọc rất dễ dàng để tìm kiếm đầu sách mong muốn thuận tiện cho công tác nghiên cứu, học tập và giải trí. Bước vào thư viện, chúng ta không còn cảm giác “choáng váng” trước những con số, công thức toán học nữa mà thay vào đó là một tinh thần thư thái, đầy hứng khởi đầy chất “phiêu” đặc biệt trong những kì ôn thi dài ngày.
                    Hôm nay bạn đã đến thư viện chưa?
                    </td>
                    <td style="text-align: center;">
                    <img src="../img/background/sachtc.jpg" alt="notthing" style="transform: scaleX(-1);">
                    </td>
                  </tr>
                </table>
              </div>
              <div class="quanly">
                <div class="section-title  bg-secondary text-center">
                    <h1 class="quanly_dau text-warning "style="font-size: 48px;">Quy Trình Quản Lý</h1>
                    <p style="font-size: 18px;">Các Quy trình Quản Lý Thư Viện</p>
            <br>
                    <div class="row">
                      <div class="col-lg-4 col-sm-6 service-item">
                        <div class="service-content">
                            <strong>Phân Loại Hợp Lý</strong>
                            <p _msttexthash="66565239" _msthash="51" class="quanly_than"> &nbsp; Phân loại tài liệu theo một hệ thống có tổ chức, chẳng hạn như theo chủ đề, chủ đề con, hay theo thể loại. Sử dụng các thư mục và hồ sơ để giữ cho mọi thứ gọn gàng và dễ tìm kiếm.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 service-item">
                        <div class="service-content">
                            <strong>Gán nhãn và Từ Khoá</strong>
                            <p _msttexthash="53587313" _msthash="54" class="quanly_than">&nbsp; Sử dụng nhãn và từ khóa để mô tả nội dung của mỗi tài liệu. Điều này giúp tăng cường khả năng tìm kiếm và liên kết giữa các tài liệu liên quan.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 service-item">
                        <div class="service-content">
                            <strong>Cơ sở dữ liệu thư viện</strong>
                            <p _msttexthash="59724418" _msthash="57" class="quanly_than">&nbsp; Xây dựng và duy trì cơ sở dữ liệu thư viện để ghi chép chi tiết về mỗi tài liệu, bao gồm thông tin như tác giả, năm xuất bản, số trang, v.v.</p>
                        </div>
                    </div>
                    </div>
                    <div class=" row">
                      <div class="col-lg-4 col-sm-6 service-item">
                        <div class="service-content">
                            <strong>Hệ thống kiểm kê định kỳ</strong>
                            <p _msttexthash="69772482" _msthash="60" class="quanly_than">&nbsp; Thực hiện các đợt kiểm kê định kỳ để đảm bảo rằng tất cả các tài liệu đều có mặt và được đặt đúng vị trí. </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 service-item">
                        <div class="service-content">
                            <strong>Tư vấn và Hướng dẫn</strong>
                            <p _msttexthash="184304432" _msthash="63" class="quanly_than">&nbsp; Cung cấp dịch vụ tư vấn và hướng dẫn cho người sử dụng thư viện để họ có thể tận dụng tối đa nguồn tài nguyên.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 service-item">
                        <div class="service-content">
                            <strong>Mượn trả tự động</strong>
                            <p _msttexthash="50549356" _msthash="66" class="quanly_than">&nbsp; Đầu tư vào hệ thống tự động cho quy trình mượn và trả sách để tăng cường tính hiệu quả và giảm thời gian giao tiếp tại quầy mượn sách.</p>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
    </section>
    <section class="footer bg-dark text-white py-4">
        <div class="container">
        <div class="text-center">
            <h4>Nhóm 5: Quanlythuvien2024</h4>
            <p>Liên hệ:</p>
            <p>Email: <a href="#">Nhom5@gmail.com</a></p>
            <hr>
            <p>Xin chân thành cảm ơn</p>

        </div>
            
        </div>

    </section>
    
</body>
</html>