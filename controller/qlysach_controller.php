<?php
include('../model/qlysach_model.php');

header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST, PUT, DELETE, GET");
header("Access-Control-Allow-Origin: *");

$conn = new mysqli('localhost', 'root', '', 'qly_thuvien');
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$sachModel = new Sach($conn);

$request_method = $_SERVER['REQUEST_METHOD'];
switch ($request_method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $query = "
                SELECT 
                    sach.sach_id, 
                    sach.ten_sach, 
                    tacgia.ten_tacgia, 
                    theloai.ten_theloai, 
                    nhaxuatban.ten_nxb, 
                    sach.mota_sach, 
                    sach.soluong_tonkho 
                FROM sach
                LEFT JOIN tacgia ON sach.tacgia_id = tacgia.tacgia_id
                LEFT JOIN theloai ON sach.theloai_id = theloai.theloai_id
                LEFT JOIN nhaxuatban ON sach.nxb_id = nhaxuatban.nxb_id
                WHERE sach.sach_id = $id
            ";
            $result = mysqli_query($conn, $query);
            $data = mysqli_fetch_assoc($result);
            if ($data) {
                echo json_encode($data);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Không tìm thấy sách với ID này!"]);
            }
        } else {
            $query = "
                SELECT 
                    sach.sach_id, 
                    sach.ten_sach, 
                    tacgia.ten_tacgia, 
                    theloai.ten_theloai, 
                    nhaxuatban.ten_nxb, 
                    sach.mota_sach, 
                    sach.soluong_tonkho 
                FROM sach
                LEFT JOIN tacgia ON sach.tacgia_id = tacgia.tacgia_id
                LEFT JOIN theloai ON sach.theloai_id = theloai.theloai_id
                LEFT JOIN nhaxuatban ON sach.nxb_id = nhaxuatban.nxb_id
            ";
            $result = mysqli_query($conn, $query);
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            echo json_encode($data);
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
