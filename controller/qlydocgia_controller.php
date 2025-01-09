<?php
// include('../config/db.php');
include('../model/qlydocgia_model.php');

header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST, PUT, DELETE, GET");
header("Access-Control-Allow-Origin: *");

$conn = new mysqli('localhost', 'root', '', 'qly_thuvien');
$docgiaModel = new Docgia($conn);

$request_method = $_SERVER['REQUEST_METHOD'];
switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            readDocgiaById($docgiaModel); // Lấy độc giả theo ID
        } else {
            readAllDocgia($docgiaModel); // Lấy tất cả độc giả 
        }
        break;
    
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['ten_docgia']) || !isset($data['tuoi_docgia']) || !isset($data['gioitinh_docgia'])|| !isset($data['sdt_docgia']) || !isset($data['email'])) {
                http_response_code(422);
                $data = [
                    'status' => 422,
                    'message' => 'Thiếu dữ liệu đầu vào',
                ];
                echo json_encode($data);
                break;
            }
                $name = $data['ten_docgia'];
                $age = $data['tuoi_docgia'];
                $gender = $data['gioitinh_docgia'];
                $phone = $data['sdt_docgia'];
                $email = $data["email"];
                // Kiểm tra giá trị của gioitinh_docgia
                if ($gender !== "0" && $gender !== "1") {
                    $data = [
                        'status' => 422,
                        'message' => 'Dữ liệu giới tính không hợp lệ',
                    ];
                    echo json_encode($data);
                    exit;
                }
            // Nếu tất cả dữ liệu hợp lệ, thêm cơ sở vật chất vào cơ sở dữ liệu
        if ($docgiaModel->addDocgia($name, $age, $gender, $phone, $email)) {
            http_response_code(200);
            $data = [
                'status' => 200,
                'message' => 'Thêm độc giả thành công!',
            ];
            echo json_encode($data);
        } else {
            http_response_code(500);
            $data = [
                'status' => 500,
                'message' => 'Thêm độc giả thất bại!',
            ];
            echo json_encode($data);
        }
        break;
    
            case 'PUT':
            // Lấy dữ liệu JSON từ Postman
            $data = json_decode(file_get_contents("php://input"), true);
        
            // Kiểm tra xem có đủ dữ liệu đầu vào không
            if (!isset($data['ten_docgia']) || !isset($data['tuoi_docgia']) || !isset($data['gioitinh_docgia'])|| !isset($data['sdt_docgia']) || !isset($data['email'])) {
                http_response_code(422);
                $data = [
                    'status' => 422,
                    'message' => 'Thiếu hoặc sai dữ liệu đầu vào',
                ];
                echo json_encode($data);
                break;
            }
                $id= $data['docgia_id'];
                $name = $data['ten_docgia'];
                $age = $data['tuoi_docgia'];
                $gender = $data['gioitinh_docgia'];
                $phone = $data['sdt_docgia'];
                $email = $data["email"];
            // Kiểm tra giá trị của gioitinh_docgia
            if ($gender !== "0" && $gender !== "1") {
                $data = [
                    'status' => 422,
                    'message' => 'Dữ liệu giới tính không hợp lệ',
                ];
                echo json_encode($data);
                exit;
            }
            
            if ($docgiaModel->updateDocgia($id, $name, $age, $gender, $phone, $email)) {
                http_response_code(200);
                $data = [
                    'status' => 200,
                    'message' => 'Cập nhật thông tin độc giả thành công!',
                ];
                echo json_encode($data);
            } else {
                http_response_code(500);
                $data = [
                    'status' => 500,
                    'message' => 'Cập nhật thông tin độc giả thất bại!',
                ];
                echo json_encode($data);
            }
            break;
        
            case 'DELETE':
                if (isset($_GET['docgia_id'])) {
                    $id = $_GET['docgia_id'];
                    
                    // Kiểm tra ID hợp lệ
                    if (!is_numeric($id) || $id <= 0) {
                        http_response_code(400);
                        $data = [
                            'status' => 400,
                            'message' => 'ID độc giả không hợp lệ',
                        ];
                        echo json_encode($data);
                        exit;
                    }
                 
                    $deleted_Docgia = $docgiaModel->deleteDocgia($id);// Xóa độc giả
                    if($deleted_Docgia){
                        http_response_code(200);
                        $data = [
                            'status' => 200,
                            'message' => 'Xoá thành công!',
                        ];
                        echo json_encode($data);
                        exit;
                    }  
                } else {
                    http_response_code(400);
                    $data = [
                        'status' => 400,
                        'message' => 'Thiếu ID độc giả!',
                    ];
                    echo json_encode($data);
                }
                break;
    }
?>