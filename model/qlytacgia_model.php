<?php
class TacGia {
    private $conn;
    private $table = "tacgia";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function add_tacgia($ten_tacgia, $gioitinh_tacgia, $thongtin_tacgia, $hinhanh_tacgia) {
        $query = "INSERT INTO " . $this->table . " (ten_tacgia, gioitinh_tacgia, thongtin_tacgia, hinhanh_tacgia) VALUES ('$ten_tacgia', $gioitinh_tacgia, '$thongtin_tacgia', '$hinhanh_tacgia')";
        return mysqli_query($this->conn, $query);
    }

    public function update_tacgia($tacgia_id, $ten_tacgia, $gioitinh_tacgia, $thongtin_tacgia, $hinhanh_tacgia) {
        $query = "UPDATE " . $this->table . " SET ten_tacgia='$ten_tacgia', gioitinh_tacgia=$gioitinh_tacgia, thongtin_tacgia='$thongtin_tacgia', hinhanh_tacgia='$hinhanh_tacgia' WHERE tacgia_id=$tacgia_id";
        return mysqli_query($this->conn, $query);
    }

    public function delete_tacgia($tacgia_id) {
        $query = "DELETE FROM " . $this->table . " WHERE tacgia_id=$tacgia_id";
        return mysqli_query($this->conn, $query);
    }

    public function get_all_tacgia() {
        $query = "SELECT * FROM " . $this->table;
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function get_tacgia_by_id($tacgia_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE tacgia_id = $tacgia_id";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return mysqli_fetch_assoc($result);
        } else {
            return null;
        }
    }
}

// Hàm thêm tác giả
function add_tacgia($tacGiaModel) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['ten_tacgia']) || !isset($data['gioitinh_tacgia']) || !isset($data['thongtin_tacgia']) || !isset($data['hinhanh_tacgia'])) {
        echo json_encode(["message" => "Invalid input"]);
        return;
    }

    $ten_tacgia = $data['ten_tacgia'];
    $gioitinh_tacgia = $data['gioitinh_tacgia'];
    $thongtin_tacgia = $data['thongtin_tacgia'];
    $hinhanh_tacgia = $data['hinhanh_tacgia'];

    if ($tacGiaModel->add_tacgia($ten_tacgia, $gioitinh_tacgia, $thongtin_tacgia, $hinhanh_tacgia)) {
        echo json_encode(["message" => "Tác giả đã được thêm"]);
    } else {
        echo json_encode(["message" => "Thêm tác giả thất bại"]);
    }
}

// Hàm cập nhật tác giả
function update_tacgia($tacGiaModel) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['tacgia_id']) || !isset($data['ten_tacgia']) || !isset($data['gioitinh_tacgia']) || !isset($data['thongtin_tacgia']) || !isset($data['hinhanh_tacgia'])) {
        echo json_encode(["message" => "Invalid input"]);
        return;
    }

    $tacgia_id = $data['tacgia_id'];
    $ten_tacgia = $data['ten_tacgia'];
    $gioitinh_tacgia = $data['gioitinh_tacgia'];
    $thongtin_tacgia = $data['thongtin_tacgia'];
    $hinhanh_tacgia = $data['hinhanh_tacgia'];

    if ($tacGiaModel->update_tacgia($tacgia_id, $ten_tacgia, $gioitinh_tacgia, $thongtin_tacgia, $hinhanh_tacgia)) {
        echo json_encode(["message" => "Tác giả đã được cập nhật"]);
    } else {
        echo json_encode(["message" => "Cập nhật tác giả thất bại"]);
    }
}

// Hàm xóa tác giả
function delete_tacgia($tacGiaModel) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['tacgia_id'])) {
        echo json_encode(["message" => "Invalid input"]);
        return;
    }

    $tacgia_id = $data['tacgia_id'];

    if ($tacGiaModel->delete_tacgia($tacgia_id)) {
        echo json_encode(["message" => "Tác giả đã được xóa"]);
    } else {
        echo json_encode(["message" => "Xóa tác giả thất bại"]);
    }
}

// Hàm lấy tất cả tác giả
function get_all_tacgia($tacGiaModel) {
    $tacgias = $tacGiaModel->get_all_tacgia();
    if (count($tacgias) > 0) {
        echo json_encode($tacgias);
    } else {
        echo json_encode(["message" => "Không tìm thấy tác giả nào"]);
    }
}

// Hàm lấy tác giả theo ID
function get_tacgia_by_id($tacGiaModel) {
    $tacgia_id = $_GET['id'];
    $tacgia = $tacGiaModel->get_tacgia_by_id($tacgia_id);
    if ($tacgia) {
        echo json_encode($tacgia);
    } else {
        echo json_encode(["message" => "Không tìm thấy tác giả với ID: $tacgia_id"]);
    }
}
?>
