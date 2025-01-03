<?php
include '../model/qlynxb_model.php'; // Include model
header('Content-Type: application/json'); // Đảm bảo API trả về JSON

// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'qly_thuvien');
$nxb = new NXBModel($conn); // Khởi tạo model

$request_method = $_SERVER['REQUEST_METHOD']; // Lấy phương thức yêu cầu HTTP

switch ($request_method) {

    case 'GET':
        if (isset($_GET['id'])) {
            get_nxb_by_id($nxb); // Lấy nxb theo ID
        } else {
            get_all_nxb($nxb); // Lấy tất cả nxb
        }
        break;

    case 'POST':
        // Lấy dữ liệu JSON từ Postman
        $data = json_decode(file_get_contents("php://input"), true);
    
        // Kiểm tra xem có đủ dữ liệu đầu vào không
        if (!isset($data['ten_nxb']) || !isset($data['thongtin_nxb']) || !isset($data['hinhanh_nxb'])) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Thiếu dữ liệu đầu vào',
            ];
            echo json_encode($data);
            break;
        }
    
        $ten_nxb = $data['ten_nxb'];
        $thongtin_nxb = $data['thongtin_nxb'];
        $hinhanh_nxb = $data['hinhanh_nxb'];
    
        // Kiểm tra tính hợp lệ của tên nhà xuất bản
        if (empty($ten_nxb) || !is_string($ten_nxb) || strlen($ten_nxb) > 255) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Tên nhà xuất bản không hợp lệ',
            ];
            echo json_encode($data);
            break;
        }

        // Kiểm tra tính hợp lệ của thông tin nhà xuất bản
        if (empty($thongtin_nxb) || !is_string($thongtin_nxb) || strlen($thongtin_nxb) > 500) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Thông tin nhà xuất bản không hợp lệ',
            ];
            echo json_encode($data);
            break;
        }

        // Kiểm tra tính hợp lệ của hình ảnh nhà xuất bản
        // Kiểm tra loại file hình ảnh (jpg, jpeg, png)
        $allowed_image_types = ['image/jpeg', 'image/png'];
        if (empty($hinhanh_nxb) || !in_array(mime_content_type($hinhanh_nxb), $allowed_image_types)) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Hình ảnh nhà xuất bản không hợp lệ',
            ];
            echo json_encode($data);
            break;
        }
    
        // Nếu tất cả dữ liệu hợp lệ, thêm nxb vào cơ sở dữ liệu
        if ($csvModel->add_nxb($ten_nxb, $thongtin_nxb, $hinhanh_nxb)) {
            http_response_code(200);
            $data = [
                'status' => 200,
                'message' => 'nxb đã được thêm thành công',
            ];
            echo json_encode($data);
        } else {
            http_response_code(500);
            $data = [
                'status' => 500,
                'message' => 'Thêm nxb thất bại',
            ];
            echo json_encode($data);
        }
        break;
    
    case 'PUT':
        // Lấy dữ liệu JSON từ Postman
        $data = json_decode(file_get_contents("php://input"), true);
        
        // Kiểm tra xem có đủ dữ liệu đầu vào không
        if (!isset($data['nxb_id']) || !isset($data['ten_nxb']) || !isset($data['thongtin_nxb']) || !isset($data['hinhanh_nxb'])) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Thiếu hoặc sai dữ liệu đầu vào',
            ];
            echo json_encode($data);
            break;
        }
        
        $nxb_id = $data['nxb_id'];
        $ten_nxb = $data['ten_nxb'];
        $thongtin_nxb = $data['thongtin_nxb'];
        $hinhanh_nxb = $data['hinhanh_nxb'];
        
        // Kiểm tra tính hợp lệ của tên nhà xuất bản
        if (empty($ten_nxb) || !is_string($ten_nxb) || strlen($ten_nxb) > 255) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Tên nhà xuất bản không hợp lệ',
            ];
            echo json_encode($data);
            break;
        }

        // Kiểm tra tính hợp lệ của thông tin nhà xuất bản
        if (empty($thongtin_nxb) || !is_string($thongtin_nxb) || strlen($thongtin_nxb) > 500) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Thông tin nhà xuất bản không hợp lệ',
            ];
            echo json_encode($data);
            break;
        }

        // Kiểm tra tính hợp lệ của hình ảnh nhà xuất bản
        // Kiểm tra loại file hình ảnh (jpg, jpeg, png)
        $allowed_image_types = ['image/jpeg', 'image/png'];
        if (empty($hinhanh_nxb) || !in_array(mime_content_type($hinhanh_nxb), $allowed_image_types)) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Hình ảnh nhà xuất bản không hợp lệ',
            ];
            echo json_encode($data);
            break;
        }
        
        // Nếu tất cả dữ liệu hợp lệ, cập nhật nxb vào cơ sở dữ liệu
        if ($csvModel->update_nxb($nxb_id, $ten_nxb, $thongtin_nxb, $hinhanh_nxb)) {
            http_response_code(200);
            $data = [
                'status' => 200,
                'message' => 'nxb đã được cập nhật thành công',
            ];
            echo json_encode($data);
        } else {
            http_response_code(500);
            $data = [
                'status' => 500,
                'message' => 'Cập nhật nxb thất bại',
            ];
            echo json_encode($data);
        }
        break;
        
    case 'DELETE':
        // Lấy nxb_id từ URL
        if (isset($_GET['nxb_id'])) {
            $id = $_GET['nxb_id'];
            
            // Kiểm tra ID hợp lệ
            if (!is_numeric($id) || $id <= 0) {
                http_response_code(400);
                $data = [
                    'status' => 400,
                    'message' => 'ID nxb không hợp lệ',
                ];
                echo json_encode($data);
                exit;
            }
         
            $deleted_nxb = $csvModel->delete_nxb($id); // Xóa nxb
            if ($deleted_nxb) {
                http_response_code(200);
                $data = [
                    'status' => 200,
                    'message' => 'Xoá thành công',
                ];
                echo json_encode($data);
                exit;
            }  
        } else {
            // Nếu thiếu 'nxb_id', trả về lỗi
            http_response_code(400);
            $data = [
                'status' => 400,
                'message' => 'Thiếu ID nxb',
            ];
            echo json_encode($data);
        }
        break;
    
    default:
        echo json_encode(["message" => "Method not allowed"]);
        break;
}
?>
