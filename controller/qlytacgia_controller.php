<?php
// include('../config/db.php');
include('../model/qlytacgia_model.php');

header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST, PUT, DELETE, GET");
header("Access-Control-Allow-Origin: *");

$conn = new mysqli('localhost', 'root', '', 'qly_thuvien');
$tacgiaModel = new Tacgia($conn);

$request_method = $_SERVER['REQUEST_METHOD'];
switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            readTacgiaById($tacgiaModel); // Lấy tác giả theo ID
        } else {
            readAllTacgia($tacgiaModel); // Lấy tất cả tác giả 
        }
        break;
    
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['ten_tacgia']) || !isset($data['gioitinh_tacgia']) || !isset($data['thongtin_tacgia']) || !isset($data['hinhanh_tacgia'])) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Thiếu dữ liệu đầu vào',
            ];
            echo json_encode($data);
            break;
        }
        $name = $data['ten_tacgia'];
        $gender = $data['gioitinh_tacgia'];
        $info = $data['thongtin_tacgia'];
        $image = $data['hinhanh_tacgia'];

        // Kiểm tra giá trị của gioitinh_tacgia
        if ($gender !== "0" && $gender !== "1") {
            $data = [
                'status' => 422,
                'message' => 'Dữ liệu giới tính không hợp lệ',
            ];
            echo json_encode($data);
            exit;
        }

        if ($tacgiaModel->addTacgia($name, $gender, $info, $image)) {
            http_response_code(200);
            $data = [
                'status' => 200,
                'message' => 'Thêm tác giả thành công!',
            ];
            echo json_encode($data);
        } else {
            http_response_code(500);
            $data = [
                'status' => 500,
                'message' => 'Thêm tác giả thất bại!',
            ];
            echo json_encode($data);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['tacgia_id']) || !isset($data['ten_tacgia']) || !isset($data['gioitinh_tacgia']) || !isset($data['thongtin_tacgia']) || !isset($data['hinhanh_tacgia'])) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Thiếu hoặc sai dữ liệu đầu vào',
            ];
            echo json_encode($data);
            break;
        }
        $id = $data['tacgia_id'];
        $name = $data['ten_tacgia'];
        $gender = $data['gioitinh_tacgia'];
        $info = $data['thongtin_tacgia'];
        $image = $data['hinhanh_tacgia'];

        // Kiểm tra giá trị của gioitinh_tacgia
        if ($gender !== "0" && $gender !== "1") {
            $data = [
                'status' => 422,
                'message' => 'Dữ liệu giới tính không hợp lệ',
            ];
            echo json_encode($data);
            exit;
        }

        if ($tacgiaModel->updateTacgia($id, $name, $gender, $info, $image)) {
            http_response_code(200);
            $data = [
                'status' => 200,
                'message' => 'Cập nhật tác giả thành công!',
            ];
            echo json_encode($data);
        } else {
            http_response_code(500);
            $data = [
                'status' => 500,
                'message' => 'Cập nhật tác giả thất bại!',
            ];
            echo json_encode($data);
        }
        break;

    case 'DELETE':
        if (isset($_GET['tacgia_id'])) {
            $id = $_GET['tacgia_id'];

            if (!is_numeric($id) || $id <= 0) {
                http_response_code(400);
                $data = [
                    'status' => 400,
                    'message' => 'ID tác giả không hợp lệ',
                ];
                echo json_encode($data);
                exit;
            }

            $deleted_Tacgia = $tacgiaModel->deleteTacgia($id); // Xóa tác giả
            if ($deleted_Tacgia) {
                http_response_code(200);
                $data = [
                    'status' => 200,
                    'message' => 'Xóa tác giả thành công!',
                ];
                echo json_encode($data);
                exit;
            }
        } else {
            http_response_code(400);
            $data = [
                'status' => 400,
                'message' => 'Thiếu ID tác giả!',
            ];
            echo json_encode($data);
        }
        break;
}
?>
