<?php
class Nhaxuatban {
    private $conn;
    private $table = "nhaxuatban";

    // Constructor để nhận kết nối cơ sở dữ liệu
    public function __construct($db) {
        $this->conn = $db;
    }

      // Lấy tất cả các nhà xuất bả
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

    // Lấy thông tin nhà xuất bản theo ID
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

    // Thêm nhà xuất bản mới
    public function addNhaxuatban($name, $info) {
        $query = "INSERT INTO nhaxuatban (ten_nxb, thongtin_nxb) 
        VALUES (n'$name', n'$info')";
        return mysqli_query($this->conn, $query);
    }

    // Cập nhật thông tin nhà xuất bản
    public function updateNhaxuatban($id, $name, $info) {
        $query = "UPDATE nhaxuatban SET ten_nxb = n'$name', thongtin_nxb = n'$info' WHERE nxb_id = $id";
        return mysqli_query($this->conn, $query);
    }

       // Xóa nhà xuất bản
       public function deleteNhaxuatban($id) {
        $query = "DELETE FROM nhaxuatban WHERE nxb_id=$id";
        return mysqli_query($this->conn, $query);
    }

    // Tìm kiếm nhà xuất bản theo từ khóa
    public function searchNhaxuatban($timkiem) {
        $query = "SELECT * FROM nhaxuatban 
                  WHERE nxb_id = '$timkiem' OR ten_nxb LIKE n'%$timkiem%'";
        $result = mysqli_query($this->conn, $query);
    
        // Kiểm tra kết quả và trả về dữ liệu dạng mảng
        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC); // Trả về kết quả dạng mảng liên kết
        } else {
            return [];
        }
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
        echo json_encode(["message" => "Thiếu dữ liệu nhà xuất bản!"]);
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
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['nxb_id'])) {
        echo json_encode(["message" => "Thiếu ID nhà xuất bản!"]);
        return;
    }

    $id = $data['nxb_id'];

    if ($nxbModel->deleteNhaxuatban($id)) {
        echo json_encode(["message" => "Xóa nhà xuất bản thành công!"]);
    } else {
        echo json_encode(["message" => "Xóa nhà xuất bản thất bại!"]);
    }
}

function searchNhaxuatban($nxbModel) {
    $timkiem = $_GET['timkiem']; // Lấy từ khóa tìm kiếm từ URL
    $nxb = $nxbModel->searchNhaxuatban($timkiem);
    if ($nxb) {
        echo json_encode($nxb); // Trả về danh sách nxb dưới dạng JSON
    } else {
        echo json_encode(["message" => "Không tìm thấy nhà xuất bản nào!"]);
    }
}
?>