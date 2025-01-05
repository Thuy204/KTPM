<?php
// include('../config/db.php');
include('../model/qlynguoidung_model.php');

header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST, PUT, DELETE, GET");
header("Access-Control-Allow-Origin: *");

$conn = new mysqli('localhost', 'root', '', 'qly_thuvien');
$nguoidungModel = new Nguoidung($conn);

$request_method = $_SERVER['REQUEST_METHOD'];
switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            readNguoidungById($nguoidungModel); // Lấy người dùng theo ID
        } else {
            readAllNguoidung($nguoidungModel); // Lấy tất cả người dùng
        }
        break;
    
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['ten_nguoidung']) || !isset($data['email_nguoidung']) || !isset($data['matkhau_nguoidung']) || !isset($data['vaitro_nguoidung'])) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Thiếu dữ liệu đầu vào',
            ];
            echo json_encode($data);
            break;
        }
        
        $name = $data['ten_nguoidung'];
        $email = $data['email_nguoidung'];
        $password = $data['matkhau_nguoidung'];
        $role = $data['vaitro_nguoidung'];
        
        if ($role !== "0" && $role !== "1") {
            $data = [
                'status' => 422,
                'message' => 'Dữ liệu vai trò không hợp lệ',
            ];
            echo json_encode($data);
            exit;
        }

        if ($nguoidungModel->addNguoidung($name, $email, $password, $role)) {
            http_response_code(200);
            $data = [
                'status' => 200,
                'message' => 'Thêm người dùng thành công!',
            ];
            echo json_encode($data);
        } else {
            http_response_code(500);
            $data = [
                'status' => 500,
                'message' => 'Thêm người dùng thất bại!',
            ];
            echo json_encode($data);
        }
        break;
    
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id_nguoidung']) || !isset($data['ten_nguoidung']) || !isset($data['email_nguoidung']) || !isset($data['matkhau_nguoidung']) || !isset($data['vaitro_nguoidung'])) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Thiếu hoặc sai dữ liệu đầu vào',
            ];
            echo json_encode($data);
            break;
        }
        
        $id = $data['id_nguoidung'];
        $name = $data['ten_nguoidung'];
        $email = $data['email_nguoidung'];
        $password = $data['matkhau_nguoidung'];
        $role = $data['vaitro_nguoidung'];

        if ($role !== "0" && $role !== "1") {
            $data = [
                'status' => 422,
                'message' => 'Dữ liệu vai trò không hợp lệ',
            ];
            echo json_encode($data);
            exit;
        }

        if ($nguoidungModel->updateNguoidung($id, $name, $email, $password, $role)) {
            http_response_code(200);
            $data = [
                'status' => 200,
                'message' => 'Cập nhật thông tin người dùng thành công!',
            ];
            echo json_encode($data);
        } else {
            http_response_code(500);
            $data = [
                'status' => 500,
                'message' => 'Cập nhật thông tin người dùng thất bại!',
            ];
            echo json_encode($data);
        }
        break;
    
    case 'DELETE':
        if (isset($_GET['id_nguoidung'])) {
            $id = $_GET['id_nguoidung'];
            
            if (!is_numeric($id) || $id <= 0) {
                http_response_code(400);
                $data = [
                    'status' => 400,
                    'message' => 'ID người dùng không hợp lệ',
                ];
                echo json_encode($data);
                exit;
            }

            if ($nguoidungModel->deleteNguoidung($id)) {
                http_response_code(200);
                $data = [
                    'status' => 200,
                    'message' => 'Xoá thành công!',
                ];
                echo json_encode($data);
            } else {
                http_response_code(500);
                $data = [
                    'status' => 500,
                    'message' => 'Xoá thất bại!',
                ];
                echo json_encode($data);
            }
        } else {
            http_response_code(400);
            $data = [
                'status' => 400,
                'message' => 'Thiếu ID người dùng!',
            ];
            echo json_encode($data);
        }
        break;
}
?>
