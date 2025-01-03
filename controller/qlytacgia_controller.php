<?php
include '../config/db.php';
include '../model/qlytacgia_model.php';

header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST, PUT, DELETE, GET");
header("Access-Control-Allow-Origin: *");

$request_method = $_SERVER['REQUEST_METHOD'];
$tacGiaModel = new TacGia($conn);

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            get_tacgia_by_id($tacGiaModel); // Lấy tác giả theo ID
        } else {
            get_all_tacgia($tacGiaModel); // Lấy tất cả tác giả
        }
        break;

    case 'POST':
        // Lấy dữ liệu JSON từ Postman
        $data = json_decode(file_get_contents("php://input"), true);
    
        // Kiểm tra xem có đủ dữ liệu đầu vào không
        if (!isset($data['ten_tacgia']) || !isset($data['gioitinh_tacgia']) || !isset($data['thongtin_tacgia']) || !isset($data['hinhanh_tacgia'])) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Thiếu dữ liệu đầu vào',
            ];
            echo json_encode($data);
            break;
        }
    
        $ten_tacgia = $data['ten_tacgia'];
        $gioitinh_tacgia = $data['gioitinh_tacgia'];
        $thongtin_tacgia = $data['thongtin_tacgia'];
        $hinhanh_tacgia = $data['hinhanh_tacgia'];
    
       

        if ($gioitinh_tacgia !== "0" && $gioitinh_tacgia !== "1") {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Giới tính không hợp lệ',
            ];
            echo json_encode($data);
            break;
        }
    
        // Nếu tất cả dữ liệu hợp lệ, thêm tác giả vào cơ sở dữ liệu
        if ($tacGiaModel->add_tacgia($ten_tacgia,  $gioitinh_tacgia, $thongtin_tacgia, $hinhanh_tacgia)) {
            http_response_code(200);
            $data = [
                'status' => 200,
                'message' => 'Tác giả đã được thêm thành công',
            ];
            echo json_encode($data);
        } else {
            http_response_code(500);
            $data = [
                'status' => 500,
                'message' => 'Thêm tác giả thất bại',
            ];
            echo json_encode($data);
        }
        break;
    
    case 'PUT':
        // Lấy dữ liệu JSON từ Postman
        $data = json_decode(file_get_contents("php://input"), true);
    
        // Kiểm tra xem có đủ dữ liệu đầu vào không
        if (!isset($data['tacgia_id']) || !isset($data['ten_tacgia'])  || !isset($data['gioitinh_tacgia']) || !isset($data['thongtin_tacgia']) || !isset($data['hinhanh_tacgia'])) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Thiếu hoặc sai dữ liệu đầu vào',
            ];
            echo json_encode($data);
            break;
        }
    
        $tacgia_id = $data['tacgia_id'];
        $ten_tacgia = $data['ten_tacgia'];
        $gioitinh_tacgia = $data['gioitinh_tacgia'];
        $thongtin_tacgia = $data['thongtin_tacgia'];
        $hinhanh_tacgia = $data['hinhanh_tacgia'];
    
      

        if ($gioitinh_tacgia !== "0" && $gioitinh_tacgia !== "1") {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Giới tính không hợp lệ',
            ];
            echo json_encode($data);
            break;
        }
    
        // Nếu tất cả dữ liệu hợp lệ, cập nhật thông tin tác giả trong cơ sở dữ liệu
        if ($tacGiaModel->update_tacgia($tacgia_id, $ten_tacgia, $gioitinh_tacgia, $thongtin_tacgia, $hinhanh_tacgia)) {
            http_response_code(200);
            $data = [
                'status' => 200,
                'message' => 'Tác giả đã được cập nhật thành công',
            ];
            echo json_encode($data);
        } else {
            http_response_code(500);
            $data = [
                'status' => 500,
                'message' => 'Cập nhật tác giả thất bại',
            ];
            echo json_encode($data);
        }
        break;
    
    case 'DELETE':
        if (isset($_GET['tacgia_id'])) {
            $id = $_GET['tacgia_id'];
            
            // Kiểm tra ID hợp lệ
            if (!is_numeric($id) || $id <= 0) {
                http_response_code(400);
                $data = [
                    'status' => 400,
                    'message' => 'ID tác giả không hợp lệ',
                ];
                echo json_encode($data);
                exit;
            }
        
            $deleted_tacgia = $tacGiaModel->delete_tacgia($id); // Xóa tác giả
            if ($deleted_tacgia) {
                http_response_code(200);
                $data = [
                    'status' => 200,
                    'message' => 'Xoá tác giả thành công',
                ];
                echo json_encode($data);
                exit;
            }  
        } else {
            // Nếu thiếu 'tacgia_id', trả về lỗi
            http_response_code(400);
            $data = [
                'status' => 400,
                'message' => 'Thiếu ID tác giả',
            ];
            echo json_encode($data);
        }
        break;
    
    default:
        echo json_encode(["message" => "Method not allowed"]);
        break;
}
?>
