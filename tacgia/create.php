<?php
    // Kết nối đến file cấu hình cơ sở dữ liệu
    require_once '../config/db.php';

    // Kiểm tra nếu đã nhấn nút submit có tên là 'them_tacgia' từ form gửi đi
    if(isset($_POST['them_tacgia'])){
        // Lấy các giá trị từ form gửi đi và gán vào các biến
        $id = $_POST['tacgia_id'];
        $ten = $_POST['ten_tacgia'];
        $gioitinh = $_POST['gioitinh_tacgia'];
        $thongtin = $_POST['thongtin_tacgia'];

        // Kiểm tra xem có file ảnh được gửi đi không
        if(isset($_FILES['tacgia_img'])){
            $file = $_FILES['tacgia_img'];
            $file_name = $file['name'];

            // Di chuyển file ảnh tải lên vào thư mục '../img/tacgia'
            move_uploaded_file($file['tmp_name'], '../img/tacgia/' . $file_name); 
        }

        // Kiểm tra nếu id tác giả là rỗng hoặc không tồn tại
        if($id == "" || empty($id)){
            // Nếu không có id, chuyển hướng về trang index.php và kết thúc
            header('Location: index.php');
            exit();
        }
        else{
            // Nếu có id, tạo câu truy vấn SQL để chèn thông tin tác giả vào cơ sở dữ liệu
            $query = "INSERT INTO tacgia (tacgia_id, ten_tacgia, gioitinh_tacgia, thongtin_tacgia, hinhanh_tacgia) 
                      VALUES ('$id', '$ten', '$gioitinh', '$thongtin', '$file_name')";
            
            // Thực thi truy vấn và lưu kết quả vào biến $result
            $result = mysqli_query($conn, $query);

            // Kiểm tra nếu không thành công, thông báo lỗi
            if(!$result){
                echo 'Dữ liệu không hợp lệ!';
            }
            else{
                // Nếu thành công, chuyển hướng về trang index.php
                header('Location: index.php');           
            }
        }
    }
?>
