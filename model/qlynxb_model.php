<?php
class Nhaxuatban {
    private $conn;
    private $table = "nhaxuatban";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAllNhaxuatban() {
        $query = "SELECT * FROM nhaxuatban";
        $result = mysqli_query($this->conn, $query);

        // Kiểm tra kết quả và trả về dữ liệu dạng mảng
        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC); // Trả về kết quả dạng mảng liên kết
        } else {
            return [];
        }
    }

    public function readNhaxuatbanById($id) {
        $query = "SELECT * FROM nhaxuatban WHERE nxb_id = $id";
        $result = mysqli_query($this->conn, $query);

        // Kiểm tra kết quả và trả về dữ liệu dạng mảng
        if ($result) {
            return mysqli_fetch_assoc($result); // Trả về kết quả dạng mảng kết hợp
        } else {
            return null;
        }
    }

    public function addNhaxuatban($name, $info) {
        $query = "INSERT INTO nhaxuatban (ten_nxb, thongtin_nxb) 
        VALUES (n'$name', n'$info')";
        return mysqli_query($this->conn, $query);
    }

    public function updateNhaxuatban($id, $name, $info) {
        $query = "UPDATE nhaxuatban SET ten_nxb = n'$name', thongtin_nxb = n'$info' WHERE nxb_id = $id";
        return mysqli_query($this->conn, $query);
    }

    public function deleteNhaxuatban($id) {
        $query = "DELETE FROM nhaxuatban WHERE nxb_id = $id";
        return mysqli_query($this->conn, $query);
    }
}

function readAllNhaxuatban($nxbModel) {
    $nhaxuatban = $nxbModel->readAllNhaxuatban();
    if (count($nhaxuatban) > 0) {
        echo json_encode($nhaxuatban); // Trả về danh sách nhà xuất bản
    } else {
        echo json_encode(["message" => "Không tồn tại nhà xuất bản nào!"]);
    }
}

function readNhaxuatbanById($nxbModel) {
    $nxb_id = $_GET['id']; // Lấy ID từ URL
    $nhaxuatban = $nxbModel->readNhaxuatbanById($nxb_id);
    if ($nhaxuatban) {
        echo json_encode($nhaxuatban); // Trả về dữ liệu nhà xuất bản theo ID
    } else {
        echo json_encode(["message" => "Không tìm thấy nhà xuất bản nào với ID: $nxb_id"]);
    }
}

function addNhaxuatban($nxbModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    if (!isset($data['ten_nxb']) || !isset($data['thongtin_nxb'])) {
        echo json_encode(["message" => "Thiếu dữ liệu!"]);
        return;
    }

    $name = $data["ten_nxb"];
    $info = $data["thongtin_nxb"];

    if ($nxbModel->addNhaxuatban($name, $info)) {
        echo json_encode(["message" => "Thêm nhà xuất bản thành công!"]);
    } else {
        echo json_encode(["message" => "Thêm nhà xuất bản thất bại!"]);
    }
}

function updateNhaxuatban($nxbModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    if (!isset($data['nxb_id']) || !isset($data['ten_nxb']) || !isset($data['thongtin_nxb'])) {
        echo json_encode(["message" => "Thiếu dữ liệu"]);
        return;
    }

    $id = $data["nxb_id"];
    $name = $data["ten_nxb"];
    $info = $data["thongtin_nxb"];

    if ($nxbModel->updateNhaxuatban($id, $name, $info)) {
        echo json_encode(["message" => "Cập nhật thông tin nhà xuất bản thành công!"]);
    } else {
        echo json_encode(["message" => "Cập nhật thông tin nhà xuất bản thất bại!"]);
    }
}

function deleteNhaxuatban($nxbModel) {
    if (isset($_GET['nxb_id'])) {
        $id = intval($_GET['nxb_id']);
        if ($nxbModel->deleteNhaxuatban($id)) {
            echo json_encode(["message" => "Xoá nhà xuất bản thành công!"]);
        } else {
            echo json_encode(["message" => "Xóa nhà xuất bản thất bại!"]);
        }
    } else {
        echo json_encode(["message" => "Thiếu ID nhà xuất bản!"]);
    }
}
?>