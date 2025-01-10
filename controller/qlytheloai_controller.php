<?php
include('../model/qlytheloai_model.php');

header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Origin: *");

$conn = new mysqli('localhost', 'root', '', 'qly_thuvien');
$theloaiModel = new Theloai($conn);

$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            readTheloaiById($theloaiModel);
        } else if (isset($_GET['timkiem'])) {
            searchTheloai($theloaiModel); // Tìm theloai theo ID hoặc tên
        } else {
            readAllTheloai($theloaiModel); // Lấy tất cả theloai
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['ten_theloai']) || !isset($data['thongtin_theloai'])) {
            http_response_code(422);
            echo json_encode(["message" => "Thiếu dữ liệu đầu vào!"]);
            exit;
        }
        $name = $data['ten_theloai'];
        $info = $data['thongtin_theloai'];
        if ($theloaiModel->addTheloai($name, $info)) {
            http_response_code(201);
            echo json_encode(["message" => "Thêm thể loại thành công!"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Thêm thể loại thất bại!"]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['theloai_id']) || !isset($data['ten_theloai']) || !isset($data['thongtin_theloai'])) {
            http_response_code(422);
            echo json_encode(["message" => "Thiếu dữ liệu đầu vào!"]);
            exit;
        }
        $id = $data['theloai_id'];
        $name = $data['ten_theloai'];
        $info = $data['thongtin_theloai'];
        if ($theloaiModel->updateTheloai($id, $name, $info)) {
            http_response_code(200);
            echo json_encode(["message" => "Cập nhật thể loại thành công!"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Cập nhật thể loại thất bại!"]);
        }
        break;

    case 'DELETE':
        if (!isset($_GET['theloai_id'])) {
            http_response_code(422);
            echo json_encode(["message" => "Thiếu ID thể loại!"]);
            exit;
        }
        $id = $_GET['theloai_id'];
        if ($theloaiModel->deleteTheloai($id)) {
            http_response_code(200);
            echo json_encode(["message" => "Xóa thể loại thành công!"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Xóa thể loại thất bại!"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Phương thức không được hỗ trợ!"]);
        break;
}
?>
