<?php
class CSVModel {
     private $conn;
    private $table = "csvc";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function add_csvc($ten_csvc, $soluong_csvc, $tinhtrang_csvc) {
        $query = "INSERT INTO cosovatchat (ten_csvc, soluong_csvc, tinhtrang_csvc) VALUES ('$ten_csvc', $soluong_csvc, $tinhtrang_csvc)";
        return mysqli_query($this->conn, $query);
    }

    public function update_csvc($csvc_id, $ten_csvc, $soluong_csvc, $tinhtrang_csvc) {
        $query = "UPDATE cosovatchat SET ten_csvc='$ten_csvc', soluong_csvc=$soluong_csvc, tinhtrang_csvc=$tinhtrang_csvc WHERE csvc_id=$csvc_id";
        return mysqli_query($this->conn, $query);
    }

    public function delete_csvc($csvc_id) {
        $query = "DELETE FROM cosovatchat WHERE csvc_id=$csvc_id";
        return mysqli_query($this->conn, $query);
    }

    // Thêm phương thức lấy tất cả cơ sở vật chất
    public function get_all_csvc() {
        $query = "SELECT * FROM cosovatchat";
        $result = mysqli_query($this->conn, $query);

        // Kiểm tra kết quả và trả về dữ liệu dạng mảng
        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC); // Trả về kết quả dạng mảng liên kết
        } else {
            return [];
        }
    }

    // Thêm phương thức lấy cơ sở vật chất theo ID
    public function get_csvc_by_id($csvc_id) {
        $query = "SELECT * FROM cosovatchat WHERE csvc_id = $csvc_id";
        $result = mysqli_query($this->conn, $query);

        // Kiểm tra kết quả và trả về dữ liệu dạng mảng
        if ($result) {
            return mysqli_fetch_assoc($result); // Trả về kết quả dạng mảng kết hợp
        } else {
            return null;
        }
    }
}
// Hàm thêm cơ sở vật chất
function add_csvc($csvModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    if (!isset($data['ten_csvc']) || !isset($data['soluong_csvc']) || !isset($data['tinhtrang_csvc'])) {
        echo json_encode(["message" => "Invalid input"]);
        return;
    }

    $ten_csvc = $data['ten_csvc'];
    $soluong_csvc = $data['soluong_csvc'];
    $tinhtrang_csvc = $data['tinhtrang_csvc'];

    if ($csvModel->add_csvc($ten_csvc, $soluong_csvc, $tinhtrang_csvc)) {
        echo json_encode(["message" => "Cơ sở vật chất đã được thêm"]);
    } else {
        echo json_encode(["message" => "Thêm cơ sở vật chất thất bại"]);
    }
}

// Hàm cập nhật cơ sở vật chất
function update_csvc($csvModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    if (!isset($data['csvc_id']) || !isset($data['ten_csvc']) || !isset($data['soluong_csvc']) || !isset($data['tinhtrang_csvc'])) {
        echo json_encode(["message" => "Invalid input"]);
        return;
    }

    $csvc_id = $data['csvc_id'];
    $ten_csvc = $data['ten_csvc'];
    $soluong_csvc = $data['soluong_csvc'];
    $tinhtrang_csvc = $data['tinhtrang_csvc'];

    if ($csvModel->update_csvc($csvc_id, $ten_csvc, $soluong_csvc, $tinhtrang_csvc)) {
        echo json_encode(["message" => "Cơ sở vật chất đã được cập nhật"]);
    } else {
        echo json_encode(["message" => "Cập nhật cơ sở vật chất thất bại"]);
    }
}


// Hàm xóa cơ sở vật chất
function delete_csvc($csvModel) {
   
    if ($csvModel->delete_csvc($csvModel)) {
        echo json_encode(["message" => "Cơ sở vật chất đã được xóa"]);
    } else {
        echo json_encode(["message" => "Xóa cơ sở vật chất thất bại"]);
    }
}

// Hàm lấy tất cả cơ sở vật chất
function get_all_csvc($csvModel) {
    $csvcs = $csvModel->get_all_csvc();
    if (count($csvcs) > 0) {
        echo json_encode($csvcs); // Trả về danh sách cơ sở vật chất
    } else {
        echo json_encode(["message" => "Không tìm thấy cơ sở vật chất nào"]);
    }
}

// Hàm lấy cơ sở vật chất theo ID
function get_csvc_by_id($csvModel) {
    $csvc_id = $_GET['id']; // Lấy ID từ URL
    $csvc = $csvModel->get_csvc_by_id($csvc_id);
    if ($csvc) {
        echo json_encode($csvc); // Trả về dữ liệu cơ sở vật chất theo ID
    } else {
        echo json_encode(["message" => "Không tìm thấy cơ sở vật chất với ID: $csvc_id"]);
    }
}
?>
