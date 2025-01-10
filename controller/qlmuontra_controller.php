<?php
// include('../config/db.php');
include('../model/qlymuontra_model.php');

header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST, PUT, DELETE, GET");
header("Access-Control-Allow-Origin: *");

$conn = new mysqli('localhost', 'root', '', 'qly_thuvien');
$muontraModel = new Muontra($conn);

$request_method = $_SERVER['REQUEST_METHOD'];
switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            readMuontraById($muontraModel); // Lấy độc giả theo ID
        } else if (isset($_GET['timkiem'])) {
            searchMuontra($muontraModel); // Lấy độc giả theo ID
        }
        else{
            readAllMuontra($muontraModel); // Lấy tất cả độc giả 
        }
        break;
    
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['docgia_id']) || !isset($data['ngaymuon']) || !isset($data['hantra'])|| !isset($data['sach_id'])|| !isset($data['soluong'])) {
                http_response_code(422);
                $data = [
                    'status' => 422,
                    'message' => 'Thiếu dữ liệu đầu vào',
                ];
                echo json_encode($data);
                break;
            }
            
            $docgia_id = $data["docgia_id"];
            $ngaymuon = $data["ngaymuon"];
            $hantra = $data["hantra"];
            $sach_id = $data["sach_id"];
            $soluong= $data["soluong"];
            // Kiểm tra hạn trả
            $hantraDate = DateTime::createFromFormat('Y-m-d', $hantra);
            $today = new DateTime(); // Ngày hiện tại

            // Kiểm tra xem việc chuyển đổi có thành công không
            if (!$hantraDate) {
                http_response_code(400);
                $data = [
                    'status' => 400,
                    'message' => 'Ngày không hợp lệ!',
                ];
                echo json_encode($data);
                break;
            }

            // Kiểm tra hạn trả phải lớn hơn ngày hôm nay
            if ($hantraDate <= $today) {
                http_response_code(400);
                $data = [
                    'status' => 400,
                    'message' => 'Hạn trả không hợp lệ. Vui lòng nhập lại!',
                ];
                echo json_encode($data);
                break;
            }
            

            // Kiểm tra số lượng tồn kho
            $query = "SELECT soluong_tonkho FROM sach WHERE sach_id = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("i", $sach_id);
                $stmt->execute();
                $stmt->bind_result($so_luong_ton);
                $stmt->fetch();
                $stmt->close();

                // Kiểm tra số lượng tồn kho
                if ($so_luong_ton === null) {
                    http_response_code(404);
                    $data = [
                        'status' => 404,
                        'message' => 'Mã sách không tồn tại!',
                    ];
                    echo json_encode($data);
                    return;
                }

                if ($so_luong_ton == 0) {
                    http_response_code(400);
                    $data = [
                        'status' => 400,
                        'message' => 'Đã hết sách ở trong kho!',
                    ];
                    echo json_encode($data);
                    return;
                } else if ($so_luong_ton < $soluong) {
                    http_response_code(400);
                    $data = [
                        'status' => 400,
                        'message' => 'Không đủ số lượng sách cho mượn!',
                    ];
                    echo json_encode($data);
                    return;
                }
            } else {
                http_response_code(500);
                $data = [
                    'status' => 500,
                    'message' => 'Lỗi khi kiểm tra số lượng tồn kho!',
                ];
                echo json_encode($data);
                return; // Sử dụng return ở đây
            }
            // Kiểm tra xem độc giả có tồn tại không
            $query = "SELECT COUNT(*) FROM docgia WHERE docgia_id = ?";
            if ($stmt = $conn->prepare($query)) {
                $stmt->bind_param("i", $docgia_id);
                $stmt->execute();
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();

                if ($count == 0) {
                    http_response_code(404);
                    $data = [
                        'status' => 404,
                        'message' => 'Độc giả không tồn tại!',
                    ];
                    echo json_encode($data);
                    break;
                }
            } else {
                http_response_code(500);
                $data = [
                    'status' => 500,
                    'message' => 'Lỗi khi kiểm tra độc giả!',
                ];
                echo json_encode($data);
                break;
            }
            if($soluong<=0){
                http_response_code(500);
                $data = [
                    'status' => 404,
                    'message' => 'Số lượng mượn phải lớn hơn không!',
                ];
                echo json_encode($data);
                return;
            }
            
            // Nếu tất cả dữ liệu hợp lệ, thêm cơ sở vật chất vào cơ sở dữ liệu
        if ($muontraModel->addMuontra($docgia_id, $ngaymuon, $hantra, $sach_id, $soluong)) {
            http_response_code(200);
            $data = [
                'status' => 200,
                'message' => 'Thêm phiếu mượn thành công!',
            ];
            echo json_encode($data);
        } else {
            http_response_code(500);
            $data = [
                'status' => 500,
                'message' => 'Thêm phiếu mượn thất bại!',
            ];
            echo json_encode($data);
        }
        break;
    
            case 'PUT':
            // Lấy dữ liệu JSON từ Postman
            $data = json_decode(file_get_contents("php://input"), true);
                $muontra_id= $data["muontra_id"];
                $ngaytra= $data["ngaytra"];
            
                if ($muontraModel->updateMuontra( $muontra_id, $ngaytra)) {
                http_response_code(200);
                $data = [
                    'status' => 200,
                    'message' => 'Cập nhật thông tin phiếu thành công!',
                ];
                echo json_encode($data);
            } else {
                http_response_code(500);
                $data = [
                    'status' => 500,
                    'message' => 'Cập nhật thông tin phiếu thất bại!',
                ];
                echo json_encode($data);
            }
            break;
        
            case 'DELETE':
                if (isset($_GET['muontra_id'])) {
                    $id = $_GET['muontra_id'];
                    
                    // Kiểm tra ID hợp lệ
                    if (!is_numeric($id) || $id <= 0) {
                        http_response_code(400);
                        $data = [
                            'status' => 400,
                            'message' => 'Mã phiếu không hợp lệ',
                        ];
                        echo json_encode($data);
                        exit;
                    }
                 
                    $deleted_PhieuMT = $muontraModel->deleteMuontra($id);// Xóa phiếu
                    if($deleted_PhieuMT){
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
                        'message' => 'Thiếu ID phiếu mượn trả!',
                    ];
                    echo json_encode($data);
                }
                break;
    }
?>