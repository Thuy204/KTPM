<?php
class Tacgia {
    private $conn;
    private $table = "tacgia";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy tất cả tác giả
    public function readAllTacgia() {
        $query = "SELECT * FROM tacgia";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    // Lấy tác giả theo ID
    public function readTacgiaById($id) {
        $query = "SELECT * FROM tacgia WHERE tacgia_id = $id";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return mysqli_fetch_assoc($result);
        } else {
            return null;
        }
    }

    // Thêm tác giả mới
    public function addTacgia($ten_tacgia, $gioitinh_tacgia, $thongtin_tacgia) {
        $query = "INSERT INTO tacgia (ten_tacgia, gioitinh_tacgia, thongtin_tacgia) 
        VALUES (n'$ten_tacgia', n'$gioitinh_tacgia', n'$thongtin_tacgia')";
        return mysqli_query($this->conn, $query);
    }

    // Cập nhật thông tin tác giả
    public function updateTacgia($id, $ten_tacgia, $gioitinh_tacgia, $thongtin_tacgia) {
        $query = "UPDATE tacgia SET ten_tacgia=n'$ten_tacgia', gioitinh_tacgia=n'$gioitinh_tacgia', 
        thongtin_tacgia=n'$thongtin_tacgia' WHERE tacgia_id=$id";
        return mysqli_query($this->conn, $query);
    }

    // Xóa tác giả
    public function deleteTacgia($id) {
        $query = "DELETE FROM tacgia WHERE tacgia_id=$id";
        return mysqli_query($this->conn, $query);
    }
}

// Hàm xử lý API tương tự
function readAllTacgia($tacgiaModel) {
    $tacgia = $tacgiaModel->readAllTacgia();
    if (count($tacgia) > 0) {
        echo json_encode($tacgia);
    } else {
        echo json_encode(["message" => "Không tồn tại tác giả nào!"]);
    }
}

function readTacgiaById($tacgiaModel) {
    $tacgia_id = $_GET['id'];
    $tacgia = $tacgiaModel->readTacgiaById($tacgia_id);
    if ($tacgia) {
        echo json_encode($tacgia);
    } else {
        echo json_encode(["message" => "Không tìm thấy tác giả với ID: $tacgia_id"]);
    }
}

function addTacgia($tacgiaModel) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['ten_tacgia']) || !isset($data['gioitinh_tacgia']) || !isset($data['thongtin_tacgia'])) {
        echo json_encode(["message" => "Thiếu dữ liệu!"]);
        return;
    }

    $ten_tacgia = $data['ten_tacgia'];
    $gioitinh_tacgia = $data['gioitinh_tacgia'];
    $thongtin_tacgia = $data['thongtin_tacgia'];

    if ($tacgiaModel->addTacgia($ten_tacgia, $gioitinh_tacgia, $thongtin_tacgia)) {
        echo json_encode(["message" => "Thêm tác giả thành công!"]);
    } else {
        echo json_encode(["message" => "Thêm tác giả thất bại!"]);
    }
}

function updateTacgia($tacgiaModel) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['tacgia_id']) || !isset($data['ten_tacgia']) || !isset($data['gioitinh_tacgia']) || !isset($data['thongtin_tacgia'])) {
        echo json_encode(["message" => "Thiếu dữ liệu!"]);
        return;
    }

    $id = $data['tacgia_id'];
    $ten_tacgia = $data['ten_tacgia'];
    $gioitinh_tacgia = $data['gioitinh_tacgia'];
    $thongtin_tacgia = $data['thongtin_tacgia'];

    if ($tacgiaModel->updateTacgia($id, $ten_tacgia, $gioitinh_tacgia, $thongtin_tacgia)) {
        echo json_encode(["message" => "Cập nhật tác giả thành công!"]);
    } else {
        echo json_encode(["message" => "Cập nhật tác giả thất bại!"]);
    }
}

function deleteTacgia($tacgiaModel) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['tacgia_id'])) {
        echo json_encode(["message" => "Thiếu ID tác giả!"]);
        return;
    }

    $id = $data['tacgia_id'];

    if ($tacgiaModel->deleteTacgia($id)) {
        echo json_encode(["message" => "Xóa tác giả thành công!"]);
    } else {
        echo json_encode(["message" => "Xóa tác giả thất bại!"]);
    }
}
?>
