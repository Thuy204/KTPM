<?php
include('../model/qlysach_model.php');

header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST, PUT, DELETE, GET");
header("Access-Control-Allow-Origin: *");

$conn = new mysqli('localhost', 'root', '', 'qly_thuvien');
$sachModel = new Sach($conn);

$request_method = $_SERVER['REQUEST_METHOD'];
switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            readSachById($sachModel); // Lấy sách theo ID
        } else if (isset($_GET['timkiem'])) {
            searchSach($sachModel); // Tìm sách theo ID hoặc tên
        } else {
            readAllSach($sachModel); // Lấy tất cả sách
        }
        break;
       
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['sach_id'], $data['tacgia_id'], $data['theloai_id'], $data['nxb_id'], $data['mota_sach'], $data['ten_sach'], $data['soluong_tonkho'])) {
            http_response_code(422);
            echo json_encode(["message" => "Thiếu dữ liệu đầu vào!"]);
            break;
        }

        $sachId = intval($data['sach_id']);
        $tacgiaId = intval($data['tacgia_id']);
        $theloaiId = intval($data['theloai_id']);
        $nxbId = intval($data['nxb_id']);
        $mota = $data['mota_sach'];
        $tenSach = $data['ten_sach'];
        $soluong = intval($data['soluong_tonkho']);
        // Kiểm tra xem sach_id có tồn tại hay không
        $query = "SELECT EXISTS(SELECT 1 FROM sach WHERE sach_id = ?)";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("i", $sachId);
            $stmt->execute();
            $stmt->bind_result($exists);
            $stmt->fetch();
            $stmt->close();

            if ($exists) { // Nếu sach_id đã tồn tại
                http_response_code(409); // Mã lỗi 409: Conflict
                $data = [
                    'status' => 409,
                    'message' => 'Mã sách đã tồn tại!',
                ];
                echo json_encode($data);
                exit; // Dừng thực thi đoạn mã tiếp theo
            }
        } else {
            http_response_code(500); // Lỗi server
            $data = [
                'status' => 500,
                'message' => 'Lỗi khi kiểm tra trùng mã sách!',
            ];
            echo json_encode($data);
            exit; // Dừng thực thi đoạn mã tiếp theo
        }
        // Kiểm tra xem tác giả có tồn tại không
        $query = "SELECT COUNT(*) FROM tacgia WHERE tacgia_id = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("i", $tacgiaId);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count == 0) {
                http_response_code(404);
                $data = [
                    'status' => 404,
                    'message' => 'Tác giả không tồn tại!',
                ];
                echo json_encode($data);
                break;
            }
        } else {
            http_response_code(500);
            $data = [
                'status' => 500,
                'message' => 'Lỗi khi kiểm tra tác giả!',
            ];
            echo json_encode($data);
            break;
        }
        // Kiểm tra xem thể loại có tồn tại không
        $query = "SELECT COUNT(*) FROM theloai WHERE theloai_id = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("i", $theloaiId);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count == 0) {
                http_response_code(404);
                $data = [
                    'status' => 404,
                    'message' => 'Thể loại không tồn tại!',
                ];
                echo json_encode($data);
                break;
            }
        } else {
            http_response_code(500);
            $data = [
                'status' => 500,
                'message' => 'Lỗi khi kiểm tra thể loại!',
            ];
            echo json_encode($data);
            break;
        }
        // Kiểm tra xem nhà xuất bản có tồn tại không
        $query = "SELECT COUNT(*) FROM nhaxuatban WHERE nxb_id = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("i", $nxbId);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count == 0) {
                http_response_code(404);
                $data = [
                    'status' => 404,
                    'message' => 'Nhà xuất bản không tồn tại!',
                ];
                echo json_encode($data);
                break;
            }
        } else {
            http_response_code(500);
            $data = [
                'status' => 500,
                'message' => 'Lỗi khi kiểm tra nhà xuất bản!',
            ];
            echo json_encode($data);
            break;
        }
        // Kiểm tra số lượng nhập phải lớn hơn 0
        if ($soluong <= 0) {
            http_response_code(400); // Mã lỗi 400: Bad Request
            $response = [
                'status' => 400,
                'message' => 'Số lượng nhập phải lớn hơn 0!',
            ];
            echo json_encode($response);
            exit; // Dừng thực thi đoạn mã tiếp theo
        }
         
        if ($sachModel->addSach($sachId, $tacgiaId, $theloaiId, $nxbId, $mota, $tenSach, $soluong)) {
            http_response_code(201);
            echo json_encode(["message" => "Thêm sách thành công!"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Thêm sách thất bại!"]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['sach_id'], $data['tacgia_id'], $data['theloai_id'], $data['nxb_id'], $data['mota_sach'], $data['ten_sach'], $data['soluong_tonkho'])) {
            http_response_code(422);
            echo json_encode(["message" => "Thiếu dữ liệu đầu vào!"]);
            break;
        }

        $id = intval($data['sach_id']);
        $tacgiaId = intval($data['tacgia_id']);
        $theloaiId = intval($data['theloai_id']);
        $nxbId = intval($data['nxb_id']);
        $mota = $data['mota_sach'];
        $tenSach = $data['ten_sach'];
        $soluong = intval($data['soluong_tonkho']);
        // Kiểm tra số lượng nhập phải lớn hơn 0
        if ($soluong <= 0) {
            http_response_code(400); // Mã lỗi 400: Bad Request
            $response = [
                'status' => 400,
                'message' => 'Số lượng nhập phải lớn hơn 0!',
            ];
            echo json_encode($response);
            exit; // Dừng thực thi đoạn mã tiếp theo
        }

        if ($sachModel->updateSach($id, $tacgiaId, $theloaiId, $nxbId, $mota, $tenSach, $soluong)) {
            http_response_code(200);
            echo json_encode(["message" => "Cập nhật thông tin sách thành công!"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Cập nhật thông tin sách thất bại!"]);
        }
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) {
            http_response_code(422);
            echo json_encode(["message" => "Thiếu ID sách!"]);
            break;
        }

        $id = intval($_GET['id']);
        if ($sachModel->deleteSach($id)) {
            http_response_code(200);
            echo json_encode(["message" => "Xóa sách thành công!"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Xóa sách thất bại!"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Phương thức không được hỗ trợ!"]);
        break;
}
?>