<?php
class Sach {
    private $conn;
    private $table = "sach";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy danh sách tất cả sách
    public function readAllSach() {
        $query = "SELECT * FROM " . $this->table;
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC); // Trả về mảng liên kết
        } else {
            return [];
        }
    }

    // Lấy thông tin sách theo ID
    public function readSachById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE sach_id = $id";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return mysqli_fetch_assoc($result); // Trả về một mảng liên kết
        } else {
            return null;
        }
    }

    // Thêm sách mới
    public function addSach($sachId, $tacgiaId, $theloaiId, $nxbId, $motaSach, $tenSach, $soLuongTonKho) {
        $query = "INSERT INTO " . $this->table . " 
            (sach_id, tacgia_id, theloai_id, nxb_id, mota_sach, ten_sach, soluong_tonkho) 
            VALUES ($sachId, $tacgiaId, $theloaiId, $nxbId, n'$motaSach', n'$tenSach', $soLuongTonKho)";

        return mysqli_query($this->conn, $query);
    }

    // Cập nhật thông tin sách
    public function updateSach($sachId, $tacgiaId, $theloaiId, $nxbId, $motaSach, $tenSach, $soLuongTonKho) {
        $query = "UPDATE " . $this->table . " 
            SET tacgia_id = $tacgiaId, theloai_id = $theloaiId, nxb_id = $nxbId, 
                mota_sach = n'$motaSach', ten_sach = n'$tenSach', soluong_tonkho = $soLuongTonKho 
            WHERE sach_id = $sachId";

        return mysqli_query($this->conn, $query);
    }

    // Xóa sách theo ID
    public function deleteSach($sachId) {
        $query = "DELETE FROM " . $this->table . " WHERE sach_id = $sachId";
        return mysqli_query($this->conn, $query);
    }
}

// Các hàm xử lý dữ liệu
function readAllSach($sachModel) {
    $sach = $sachModel->readAllSach();
    if (count($sach) > 0) {
        echo json_encode($sach); // Trả về danh sách sách
    } else {
        echo json_encode(["message" => "Không tồn tại sách nào!"]);
    }
}

function readSachById($sachModel) {
    $sach_id = $_GET['id']; // Lấy ID từ URL
    $sach = $sachModel->readSachById($sach_id);
    if ($sach) {
        echo json_encode($sach); // Trả về dữ liệu sách theo ID
    } else {
        echo json_encode(["message" => "Không tìm thấy sách nào với ID: $sach_id"]);
    }
}

function addSach($sachModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    if (!isset($data['sach_id']) || !isset($data['tacgia_id']) || !isset($data['theloai_id']) || !isset($data['nxb_id']) || !isset($data['mota_sach']) || !isset($data['ten_sach']) || !isset($data['soluong_tonkho'])) {
        echo json_encode(["message" => "Thiếu dữ liệu!"]);
        return;
    }

    $sachId = $data["sach_id"];
    $tacgiaId = $data["tacgia_id"];
    $theloaiId = $data["theloai_id"];
    $nxbId = $data["nxb_id"];
    $motaSach = $data["mota_sach"];
    $tenSach = $data["ten_sach"];
    $soLuongTonKho = $data["soluong_tonkho"];

    if ($sachModel->addSach($sachId, $tacgiaId, $theloaiId, $nxbId, $motaSach, $tenSach, $soLuongTonKho)) {
        echo json_encode(["message" => "Thêm sách thành công!"]);
    } else {
        echo json_encode(["message" => "Thêm sách thất bại!"]);
    }
}

function updateSach($sachModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    if (!isset($data['sach_id']) || !isset($data['tacgia_id']) || !isset($data['theloai_id']) || !isset($data['nxb_id']) || !isset($data['mota_sach']) || !isset($data['ten_sach']) || !isset($data['soluong_tonkho'])) {
        echo json_encode(["message" => "Thiếu dữ liệu!"]);
        return;
    }

    $sachId = $data["sach_id"];
    $tacgiaId = $data["tacgia_id"];
    $theloaiId = $data["theloai_id"];
    $nxbId = $data["nxb_id"];
    $motaSach = $data["mota_sach"];
    $tenSach = $data["ten_sach"];
    $soLuongTonKho = $data["soluong_tonkho"];

    if ($sachModel->updateSach($sachId, $tacgiaId, $theloaiId, $nxbId, $motaSach, $tenSach, $soLuongTonKho)) {
        echo json_encode(["message" => "Cập nhật thông tin sách thành công!"]);
    } else {
        echo json_encode(["message" => "Cập nhật thông tin sách thất bại!"]);
    }
}

function deleteSach($sachModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    if (!isset($data['sach_id'])) {
        echo json_encode(["message" => "Thiếu ID sách!"]);
        return;
    }

    $sachId = $data["sach_id"];
    if ($sachModel->deleteSach($sachId)) {
        echo json_encode(["message" => "Xóa sách thành công!"]);
    } else {
        echo json_encode(["message" => "Xóa sách thất bại!"]);
    }
}
?>
