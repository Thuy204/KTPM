<?php
class NXBModel {
    private $conn;
    private $table = "nhaxuatban";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function add_nxb($ten_nxb, $thongtin_nxb, $hinhanh_nxb) {
        $query = "INSERT INTO nhaxuatban (ten_nxb, thongtin_nxb, hinhanh_nxb) VALUES ('$ten_nxb', '$thongtin_nxb', '$hinhanh_nxb')";
        return mysqli_query($this->conn, $query);
    }

    public function update_nxb($nxb_id, $ten_nxb, $thongtin_nxb, $hinhanh_nxb) {
        $query = "UPDATE nhaxuatban SET ten_nxb='$ten_nxb', thongtin_nxb='$thongtin_nxb', hinhanh_nxb='$hinhanh_nxb' WHERE nxb_id=$nxb_id";
        return mysqli_query($this->conn, $query);
    }

    public function delete_nxb($nxb_id) {
        $query = "DELETE FROM nhaxuatban WHERE nxb_id=$nxb_id";
        return mysqli_query($this->conn, $query);
    }

    // Thêm phương thức lấy tất cả nxb
    public function get_all_nxb() {
        $query = "SELECT * FROM nhaxuatban";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC); 
        } else {
            return [];
        }
    }

    // Thêm phương thức lấy nxb theo ID
    public function get_nxb_by_id($nxb_id) {
        $query = "SELECT * FROM nhaxuatban WHERE nxb_id = $nxb_id";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return mysqli_fetch_assoc($result); 
        } else {
            return null;
        }
    }
}

// Hàm thêm nxb
function add_nxb($csvModel) {
    $data = json_decode(file_get_contents("php://input"), true); 
    if (!isset($data['ten_nxb']) || !isset($data['thongtin_nxb']) || !isset($data['hinhanh_nxb'])) {
        echo json_encode(["message" => "Dữ liệu không hợp lệ"]);
        return;
    }

    $ten_nxb = $data['ten_nxb'];
    $thongtin_nxb = $data['thongtin_nxb'];
    $hinhanh_nxb = $data['hinhanh_nxb'];

    if ($csvModel->add_nxb($ten_nxb, $thongtin_nxb, $hinhanh_nxb)) {
        echo json_encode(["message" => "NXB đã được thêm"]);
    } else {
        echo json_encode(["message" => "Thêm NXB thất bại"]);
    }
}

// Hàm cập nhật nxb
function update_nxb($csvModel) {
    $data = json_decode(file_get_contents("php://input"), true); 
    if (!isset($data['nxb_id']) || !isset($data['ten_nxb']) || !isset($data['thongtin_nxb']) || !isset($data['hinhanh_nxb'])) {
        echo json_encode(["message" => "Dữ liệu không hợp lệ"]);
        return;
    }

    $nxb_id = $data['nxb_id'];
    $ten_nxb = $data['ten_nxb'];
    $thongtin_nxb = $data['thongtin_nxb'];
    $hinhanh_nxb = $data['hinhanh_nxb'];

    if ($csvModel->update_nxb($nxb_id, $ten_nxb, $thongtin_nxb, $hinhanh_nxb)) {
        echo json_encode(["message" => "NXB đã được cập nhật"]);
    } else {
        echo json_encode(["message" => "Cập nhật NXB thất bại"]);
    }
}

// Hàm xóa nxb
function delete_nxb($csvModel) {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['nxb_id'])) {
        echo json_encode(["message" => "Dữ liệu không hợp lệ"]);
        return;
    }

    $nxb_id = $data['nxb_id'];

    if ($csvModel->delete_nxb($nxb_id)) {
        echo json_encode(["message" => "NXB đã được xóa"]);
    } else {
        echo json_encode(["message" => "Xóa NXB thất bại"]);
    }
}

// Hàm lấy tất cả nxb
function get_all_nxb($csvModel) {
    $nxb = $csvModel->get_all_nxb();
    if (count($nxb) > 0) {
        echo json_encode($nxb);
    } else {
        echo json_encode(["message" => "Không tìm thấy NXB nào"]);
    }
}

// Hàm lấy nxb theo ID
function get_nxb_by_id($csvModel) {
    $nxb_id = $_GET['id']; 
    $nxb = $csvModel->get_nxb_by_id($nxb_id);
    if ($nxb) {
        echo json_encode($nxb); 
    } else {
        echo json_encode(["message" => "Không tìm thấy NXB với ID: $nxb_id"]);
    }
}
?>
