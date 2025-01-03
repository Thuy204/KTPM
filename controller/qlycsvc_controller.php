<?php
// include('../config/db.php');
// include('../model/qlycsvc_model.php');

// header('Content-Type: application/json');
// header("Access-Control-Allow-Methods: POST, PUT, DELETE, GET");
// header("Access-Control-Allow-Origin: *");

// $request_method = $_SERVER['REQUEST_METHOD'];
// $csvc = new Csvc($conn);

// switch ($request_method) {
//     case 'GET':
//         // Lấy danh sách hoặc chi tiết cơ sở vật chất
//         if (isset($_GET['id'])) {
//             echo $csvc->getServiceById($_GET['id']);
//         } else {
//             echo $csvc->readServiceList();
//         }
//         break;

//     case 'POST':
//         // Thêm cơ sở vật chất mới
//         if (isset($_POST['ten_csvc']) && isset($_POST['soluong_csvc']) && isset($_POST['tinhtrang_csvc'])) {
//             $ten = $_POST['ten_csvc'];
//             $quantity = $_POST['soluong_csvc'];
//             $status = $_POST['tinhtrang_csvc'];

//             // Kiểm tra tính hợp lệ của số lượng
//             if (!is_numeric($quantity) || $quantity < 0) {
//                 $data = [
//                     'status' => 422,
//                     'message' => 'Số lượng không hợp lệ',
//                 ];
//                 echo json_encode($data);
//                 exit;
//             }

//             // Kiểm tra tính hợp lệ của tình trạng
//             if ($status !== "0" && $status !== "1") {
//                 $data = [
//                     'status' => 422,
//                     'message' => 'Tình trạng không hợp lệ',
//                 ];
//                 echo json_encode($data);
//                 exit;
//             }

//             $inputdata = [
//                 'ten_csvc' => $ten,
//                 'soluong_csvc' => $quantity,
//                 'tinhtrang_csvc' => $status,
//             ];
//             echo $csvc->insertService($inputdata);
//         } else {
//             $data = [
//                 'status' => 422,
//                 'message' => 'Thiếu dữ liệu đầu vào',
//             ];
//             echo json_encode($data);
//         }
//         break;

//     case 'PUT':
//         // Cập nhật thông tin cơ sở vật chất
//         parse_str(file_get_contents("php://input"), $_PUT);
//         if (isset($_PUT['csvc_id']) && isset($_PUT['ten_csvc']) && isset($_PUT['soluong_csvc']) && isset($_PUT['tinhtrang_csvc'])) {
//             $id = $_PUT['csvc_id'];
//             $ten = $_PUT['ten_csvc'];
//             $quantity = $_PUT['soluong_csvc'];
//             $status = $_PUT['tinhtrang_csvc'];

//             // Kiểm tra tính hợp lệ của số lượng
//             if (!is_numeric($quantity) || $quantity < 0) {
//                 $data = [
//                     'status' => 422,
//                     'message' => 'Số lượng không hợp lệ',
//                 ];
//                 echo json_encode($data);
//                 exit;
//             }

//             // Kiểm tra tính hợp lệ của tình trạng
//             if ($status !== "0" && $status !== "1") {
//                 $data = [
//                     'status' => 422,
//                     'message' => 'Tình trạng không hợp lệ',
//                 ];
//                 echo json_encode($data);
//                 exit;
//             }

//             $inputdata = [
//                 'csvc_id' => $id,
//                 'ten_csvc' => $ten,
//                 'soluong_csvc' => $quantity,
//                 'tinhtrang_csvc' => $status,
//             ];
//             echo $csvc->updateService($inputdata);
//         } else {
//             $data = [
//                 'status' => 422,
//                 'message' => 'Thiếu hoặc sai dữ liệu đầu vào',
//             ];
//             echo json_encode($data);
//         }
//         break;

//     case 'DELETE':
//         // Xóa cơ sở vật chất
//         parse_str(file_get_contents("php://input"), $_DELETE);
//         if (isset($_DELETE['csvc_id'])) {
//             $id = $_DELETE['csvc_id'];
//             $inputdata = [
//                 'csvc_id' => $id,
//             ];
//             echo $csvc->deleteService($inputdata);
//         } else {
//             $data = [
//                 'status' => 422,
//                 'message' => 'Thiếu hoặc sai ID',
//             ];
//             echo json_encode($data);
//         }
//         break;

//     default:
//         $data = [
//             'status' => 405,
//             'message' => 'Method Not Allowed',
//         ];
//         echo json_encode($data);
//         break;
// }

include '../model/qlycsvc_model.php'; // Include model
header('Content-Type: application/json'); // Đảm bảo API trả về JSON

// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'qly_thuvien');
$csvModel = new CSVModel($conn); // Khởi tạo model

$request_method = $_SERVER['REQUEST_METHOD']; // Lấy phương thức yêu cầu HTTP

switch ($request_method) {

    case 'GET':
        if (isset($_GET['id'])) {
            get_csvc_by_id($csvModel); // Lấy cơ sở vật chất theo ID
        } else {
            get_all_csvc($csvModel); // Lấy tất cả cơ sở vật chất
        }
        break;

    case 'POST':
        // Lấy dữ liệu JSON từ Postman
        $data = json_decode(file_get_contents("php://input"), true);
    
        // Kiểm tra xem có đủ dữ liệu đầu vào không
        if (!isset($data['ten_csvc']) || !isset($data['soluong_csvc']) || !isset($data['tinhtrang_csvc'])) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Thiếu dữ liệu đầu vào',
            ];
            echo json_encode($data);
            break;
        }
    
        $ten_csvc = $data['ten_csvc'];
        $soluong_csvc = $data['soluong_csvc'];
        $tinhtrang_csvc = $data['tinhtrang_csvc'];
    
        // Kiểm tra tính hợp lệ của số lượng
        if (!is_numeric($soluong_csvc) || $soluong_csvc < 0) {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Số lượng không hợp lệ',
            ];
            echo json_encode($data);
            break;
        }
    
        // Kiểm tra tính hợp lệ của tình trạng (0 hoặc 1)
        if ($tinhtrang_csvc !== "0" && $tinhtrang_csvc !== "1") {
            http_response_code(422);
            $data = [
                'status' => 422,
                'message' => 'Tình trạng không hợp lệ',
            ];
            echo json_encode($data);
            break;
        }
    
        // Nếu tất cả dữ liệu hợp lệ, thêm cơ sở vật chất vào cơ sở dữ liệu
        if ($csvModel->add_csvc($ten_csvc, $soluong_csvc, $tinhtrang_csvc)) {
            http_response_code(200);
            $data = [
                'status' => 200,
                'message' => 'Cơ sở vật chất đã được thêm thành công',
            ];
            echo json_encode($data);
        } else {
            http_response_code(500);
            $data = [
                'status' => 500,
                'message' => 'Thêm cơ sở vật chất thất bại',
            ];
            echo json_encode($data);
        }
        break;
    
        case 'PUT':
            // Lấy dữ liệu JSON từ Postman
            $data = json_decode(file_get_contents("php://input"), true);
        
            // Kiểm tra xem có đủ dữ liệu đầu vào không
            if (!isset($data['csvc_id']) || !isset($data['ten_csvc']) || !isset($data['soluong_csvc']) || !isset($data['tinhtrang_csvc'])) {
                http_response_code(422);
                $data = [
                    'status' => 422,
                    'message' => 'Thiếu hoặc sai dữ liệu đầu vào',
                ];
                echo json_encode($data);
                break;
            }
        
            $csvc_id = $data['csvc_id'];
            $ten_csvc = $data['ten_csvc'];
            $soluong_csvc = $data['soluong_csvc'];
            $tinhtrang_csvc = $data['tinhtrang_csvc'];
        
            // Kiểm tra tính hợp lệ của số lượng
            if (!is_numeric($soluong_csvc) || $soluong_csvc < 0) {
                http_response_code(422);
                $data = [
                    'status' => 422,
                    'message' => 'Số lượng không hợp lệ',
                ];
                echo json_encode($data);
                break;
            }
        
            // Kiểm tra tính hợp lệ của tình trạng (0 hoặc 1)
            if ($tinhtrang_csvc !== "0" && $tinhtrang_csvc !== "1") {
                http_response_code(422);
                $data = [
                    'status' => 422,
                    'message' => 'Tình trạng không hợp lệ',
                ];
                echo json_encode($data);
                break;
            }
        
            // Nếu tất cả dữ liệu hợp lệ, thêm cơ sở vật chất vào cơ sở dữ liệu
            if ($csvModel->add_csvc($ten_csvc, $soluong_csvc, $tinhtrang_csvc)) {
                http_response_code(200);
                $data = [
                    'status' => 200,
                    'message' => 'Cơ sở vật chất đã được cập nhật thành công',
                ];
                echo json_encode($data);
            } else {
                http_response_code(500);
                $data = [
                    'status' => 500,
                    'message' => 'Cập nhật cơ sở vật chất thất bại',
                ];
                echo json_encode($data);
            }
            break;
        
        case 'DELETE':
            // Lấy csvc_id từ URL
            if (isset($_GET['csvc_id'])) {
                $id = $_GET['csvc_id'];
                
                // Kiểm tra ID hợp lệ
                if (!is_numeric($id) || $id <= 0) {
                    http_response_code(400);
                    $data = [
                        'status' => 400,
                        'message' => 'ID cơ sở vật chất không hợp lệ',
                    ];
                    echo json_encode($data);
                    exit;
                }
            
                $deleted_csvc = $csvModel->delete_csvc($id);// Xóa cơ sở vật chất
                if($deleted_csvc){
                    http_response_code(200);
                    $data = [
                        'status' => 200,
                        'message' => 'Xoá thành công',
                    ];
                    echo json_encode($data);
                    exit;
                }  
            } else {
                // Nếu thiếu 'csvc_id', trả về lỗi
                http_response_code(400);
                $data = [
                    'status' => 400,
                    'message' => 'Thiếu ID cơ sở vật chất',
                ];
                echo json_encode($data);
            }
            break;
                

                    default:
                echo json_encode(["message" => "Method not allowed"]);
                break;
}
?>
