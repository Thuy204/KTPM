<?php
class Theloai {
    private $conn;
    private $table = "theloai";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy tất cả thể loại
    public function readAllTheloai() {
        $query = "SELECT * FROM " . $this->table;
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    // Lấy thông tin thể loại theo ID
    public function readTheloaiById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE theloai_id = $id";
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return mysqli_fetch_assoc($result);
        } else {
            return null;
        }
    }

    // Thêm thể loại mới
    public function addTheloai($name, $info) {
        $query = "INSERT INTO " . $this->table . " (ten_theloai, thongtin_theloai) 
                  VALUES (n'$name', n'$info')";
        return mysqli_query($this->conn, $query);
    }

    // Cập nhật thông tin thể loại
    public function updateTheloai($id, $name, $info) {
        $query = "UPDATE " . $this->table . " SET ten_theloai=n'$name', thongtin_theloai=n'$info' WHERE theloai_id=$id";
        return mysqli_query($this->conn, $query);
    }

    // Xóa thể loại theo ID
    public function deleteTheloai($id) {
        $query = "DELETE FROM " . $this->table . " WHERE theloai_id=$id";
        return mysqli_query($this->conn, $query);
    }
    public function searchTheloai($timkiem) {
        $query = "SELECT * FROM theloai
                  WHERE theloai_id = '$timkiem' OR ten_theloai LIKE n'%$timkiem%'";
        $result = mysqli_query($this->conn, $query);
    
        // Kiểm tra kết quả và trả về dữ liệu dạng mảng
        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC); // Trả về kết quả dạng mảng liên kết
        } else {
            return [];
        }
    }
}


function readAllTheloai($theloaiModel) {
    $theloai = $theloaiModel->readAllTheloai();
    if (count($theloai) > 0) {
        echo json_encode($theloai); // Trả về danh sách thể loại
    } else {
        echo json_encode(["message" => "Không tồn tại thể loại nào!"]);
    }
}

function readTheloaiById($theloaiModel) {
    $theloai_id = $_GET['id']; // Lấy ID từ URL
    $theloai = $theloaiModel->readTheloaiById($theloai_id);
    if ($theloai) {
        echo json_encode($theloai); // Trả về dữ liệu thể loại theo ID
    } else {
        echo json_encode(["message" => "Không tìm thấy thể loại nào với ID: $theloai_id"]);
    }
}

function addTheloai($theloaiModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    if (!isset($data['ten_theloai']) || !isset($data['thongtin_theloai'])) {
        echo json_encode(["message" => "Thiếu dữ liệu!"]);
        return;
    }
    $name = $data["ten_theloai"];
    $info = $data["thongtin_theloai"];

    if ($theloaiModel->addTheloai($name, $info)) {
        echo json_encode(["message" => "Thêm thể loại thành công!"]);
    } else {
        echo json_encode(["message" => "Thêm thể loại thất bại!"]);
    }
}

function updateTheloai($theloaiModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    if (!isset($data['theloai_id']) || !isset($data['ten_theloai']) || !isset($data['thongtin_theloai'])) {
        echo json_encode(["message" => "Thiếu dữ liệu"]);
        return;
    }
    $id = $data["theloai_id"];
    $name = $data["ten_theloai"];
    $info = $data["thongtin_theloai"];

    if ($theloaiModel->updateTheloai($id, $name, $info)) {
        echo json_encode(["message" => "Cập nhật thông tin thể loại thành công!"]);
    } else {
        echo json_encode(["message" => "Cập nhật thông tin thể loại thất bại!"]);
    }
}

function deleteTheloai($theloaiModel) {
    $theloai_id = $_GET['theloai_id'];
    if (!isset($theloai_id) || !is_numeric($theloai_id)) {
        echo json_encode(["message" => "ID thể loại không hợp lệ"]);
        return;
    }

    if ($theloaiModel->deleteTheloai($theloai_id)) {
        echo json_encode(["message" => "Xóa thể loại thành công!"]);
    } else {
        echo json_encode(["message" => "Xóa thể loại thất bại!"]);
    }
}

function searchTheloai($theloaiModel) {
    $timkiem = $_GET['timkiem']; // Lấy từ khóa tìm kiếm từ URL
    $theloai = $theloaiModel->searchTheloai($timkiem);
    if ($theloai) {
        echo json_encode($theloai); // Trả về danh sách theloai dưới dạng JSON
    } else {
        echo json_encode(["message" => "Không tìm thấy thể loại nào!"]);
    }
}

?>