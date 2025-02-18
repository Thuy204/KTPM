<?php
// include('../config/db.php');
include('../model/qlynxb_model.php');

header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST, PUT, DELETE, GET");
header("Access-Control-Allow-Origin: *");

$conn = new mysqli('localhost', 'root', '', 'qly_thuvien');
$nxbModel = new Nhaxuatban($conn);

$request_method = $_SERVER['REQUEST_METHOD'];
switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            readNhaxuatbanById($nxbModel); // Lấy nhà xuất bản theo ID
        }  else if (isset($_GET['timkiem'])) {
            searchNhaxuatban($nxbModel); // Tìm nhà xuất bảnả theo ID hoặc tên
        } else {
            readAllNhaxuatban($nxbModel); // Lấy tất cả nhà xuất bản
        }
        break;
        
    
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['ten_nxb']) || !isset($data['thongtin_nxb'])) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Thiếu dữ liệu đầu vào',
            ];
            echo json_encode($data);
            break;
        }

        $name = $data['ten_nxb'];
        $inf = $data['thongtin_nxb'];

        if ($nxbModel->addNhaxuatban($name, $inf)) {
            http_response_code(200);
            $data = [
                'status' => 200,
                'message' => 'Thêm nhà xuất bản thành công!',
            ];
            echo json_encode($data);
        } else {
            http_response_code(500);
            $data = [
                'status' => 500,
                'message' => 'Thêm nhà xuất bản thất bại!',
            ];
            echo json_encode($data);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['nxb_id']) || !isset($data['ten_nxb']) || !isset($data['thongtin_nxb'])) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Thiếu hoặc sai dữ liệu đầu vào',
            ];
            echo json_encode($data);
            break;
        }

        $id = intval($data['nxb_id']);
        $name = $data['ten_nxb'];
        $inf = $data['thongtin_nxb'];

    //     // Bắt lỗi: Không cho phép sửa `nxb_id`
    // if ($data['nxb_id'] != $id) { 
    //     http_response_code(400);
    //     $data = [
    //         'status' => 400,
    //         'message' => 'Không được phép sửa ID nhà xuất bản',
    //     ];
    //     echo json_encode($data);
    //     break;
    // }
        if ($nxbModel->updateNhaxuatban($id, $name, $inf)) {
            http_response_code(200);
            $data = [
                'status' => 200,
                'message' => 'Cập nhật thông tin nhà xuất bản thành công!',
            ];
            echo json_encode($data);
        } else {
            http_response_code(500);
            $data = [
                'status' => 500,
                'message' => 'Cập nhật thông tin nhà xuất bản thất bại!',
            ];
            echo json_encode($data);
        }
        break;

        case 'DELETE':
            if (isset($_GET['nxb_id'])) {
                $id = $_GET['nxb_id'];
    
                if (!is_numeric($id) || $id <= 0) {
                    http_response_code(400);
                    $data = [
                        'status' => 400,
                        'message' => 'ID nhà xuất bản không hợp lệ',
                    ];
                    echo json_encode($data);
                    exit;
                }
    
                $deleted_nxb = $nxbModel->deleteNhaxuatban($id); // Xóa nxb
                if ($deleted_nxb) {
                    http_response_code(200);
                    $data = [
                        'status' => 200,
                        'message' => 'Xóa nhà xuất bản thành công!',
                    ];
                    echo json_encode($data);
                    exit;
                }
            } else {
                http_response_code(400);
                $data = [
                    'status' => 400,
                    'message' => 'Thiếu ID nxb!',
                ];
                echo json_encode($data);
            }
            break;

        
}


?>