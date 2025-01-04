<?php
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
    
        // case 'PUT':
        //     // Lấy dữ liệu JSON từ Postman
        //     $data = json_decode(file_get_contents("php://input"), true);
        
        //     // Kiểm tra xem có đủ dữ liệu đầu vào không
        //     if (!isset($data['csvc_id']) || !isset($data['ten_csvc']) || !isset($data['soluong_csvc']) || !isset($data['tinhtrang_csvc'])) {
        //         http_response_code(422);
        //         $data = [
        //             'status' => 422,
        //             'message' => 'Thiếu hoặc sai dữ liệu đầu vào',
        //         ];
        //         echo json_encode($data);
        //         break;
        //     }
        
        //     $csvc_id = $data['csvc_id'];
        //     $ten_csvc = $data['ten_csvc'];
        //     $soluong_csvc = $data['soluong_csvc'];
        //     $tinhtrang_csvc = $data['tinhtrang_csvc'];
        
        //     // Kiểm tra tính hợp lệ của số lượng
        //     if (!is_numeric($soluong_csvc) || $soluong_csvc < 0) {
        //         http_response_code(422);
        //         $data = [
        //             'status' => 422,
        //             'message' => 'Số lượng không hợp lệ',
        //         ];
        //         echo json_encode($data);
        //         break;
        //     }
        
        //     // Kiểm tra tính hợp lệ của tình trạng (0 hoặc 1)
        //     if ($tinhtrang_csvc !== "0" && $tinhtrang_csvc !== "1") {
        //         http_response_code(422);
        //         $data = [
        //             'status' => 422,
        //             'message' => 'Tình trạng không hợp lệ',
        //         ];
        //         echo json_encode($data);
        //         break;
        //     }
        
        //     // Nếu tất cả dữ liệu hợp lệ, thêm cơ sở vật chất vào cơ sở dữ liệu
        //     if ($csvModel->add_csvc($ten_csvc, $soluong_csvc, $tinhtrang_csvc)) {
        //         http_response_code(200);
        //         $data = [
        //             'status' => 200,
        //             'message' => 'Cơ sở vật chất đã được cập nhật thành công',
        //         ];
        //         echo json_encode($data);
        //     } else {
        //         http_response_code(500);
        //         $data = [
        //             'status' => 500,
        //             'message' => 'Cập nhật cơ sở vật chất thất bại',
        //         ];
        //         echo json_encode($data);
        //     }
        //     break;

        // Đảm bảo rằng bạn xử lý PUT request đúng
case 'PUT':
    $data = json_decode(file_get_contents("php://input"), true);

    // Kiểm tra dữ liệu đầu vào
    if (!isset($data['csvc_id']) || !isset($data['ten_csvc']) || !isset($data['soluong_csvc']) || !isset($data['tinhtrang_csvc'])) {
        http_response_code(400); // Bad request
        echo json_encode(["message" => "Thiếu hoặc sai dữ liệu đầu vào"]);
        break;
    }

    $csvc_id = $data['csvc_id'];
    $ten_csvc = $data['ten_csvc'];
    $soluong_csvc = $data['soluong_csvc'];
    $tinhtrang_csvc = $data['tinhtrang_csvc'];

    // Kiểm tra tính hợp lệ của số lượng
    if (!is_numeric($soluong_csvc) || $soluong_csvc < 0) {
        http_response_code(422); // Unprocessable Entity
        echo json_encode(["message" => "Số lượng không hợp lệ"]);
        break;
    }

    // Kiểm tra tính hợp lệ của tình trạng (0 hoặc 1)
    if ($tinhtrang_csvc !== "0" && $tinhtrang_csvc !== "1") {
        http_response_code(422); // Unprocessable Entity
        echo json_encode(["message" => "Tình trạng không hợp lệ"]);
        break;
    }


    // Thực hiện cập nhật cơ sở vật chất
    if ($csvModel->update_csvc($csvc_id, $ten_csvc, $soluong_csvc, $tinhtrang_csvc)) {
        http_response_code(200); // OK
        echo json_encode(["message" => "Cơ sở vật chất đã được cập nhật"]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["message" => "Cập nhật cơ sở vật chất thất bại"]);
    }
    break;

        
// case 'DELETE':
//     // Lấy csvc_id từ URL
//     if (isset($_GET['csvc_id'])) {
//         $id = $_GET['csvc_id'];
        
//         // Kiểm tra ID hợp lệ
//         if (!is_numeric($id) || $id <= 0) {
//             http_response_code(400);
//             $data = [
//                 'status' => 400,
//                 'message' => 'ID cơ sở vật chất không hợp lệ',
//             ];
//             echo json_encode($data);
//             exit;
//         }
     
//         $deleted_csvc = $csvModel->delete_csvc($id);// Xóa cơ sở vật chất
//         if($deleted_csvc){
//             http_response_code(200);
//             $data = [
//                 'status' => 200,
//                 'message' => 'Xoá thành công',
//             ];
//             echo json_encode($data);
//             exit;
//         }  
//     } else {
//         // Nếu thiếu 'csvc_id', trả về lỗi
//         http_response_code(400);
//         $data = [
//             'status' => 400,
//             'message' => 'Thiếu ID cơ sở vật chất',
//         ];
//         echo json_encode($data);
//     }
//     break;
          

//             default:
//         echo json_encode(["message" => "Method not allowed"]);
//         break;
// }

case 'DELETE':
    // Lấy csvc_id từ body
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['csvc_id'])) {
        $id = $data['csvc_id'];
        
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
     
        $deleted_csvc = $csvModel->delete_csvc($id); // Xóa cơ sở vật chất
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
}
?>

