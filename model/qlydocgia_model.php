<?php
class Docgia {
    private $conn;
    private $table = "docgia";

    public function __construct($db) {
        $this->conn = $db;
    }
    public function readAllDocgia() {
        $query = "SELECT * FROM docgia";
        $result = mysqli_query($this->conn, $query);

        // Kiểm tra kết quả và trả về dữ liệu dạng mảng
        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC); // Trả về kết quả dạng mảng liên kết
        } else {
            return [];
        }
    }
    public function readDocgiaById($id) {
        $query = "SELECT * FROM docgia WHERE docgia_id = $id";
        $result = mysqli_query($this->conn, $query);

        // Kiểm tra kết quả và trả về dữ liệu dạng mảng
        if ($result) {
            return mysqli_fetch_assoc($result); // Trả về kết quả dạng mảng kết hợp
        } else {
            return null;
        }
    }
    public function addDocgia($name, $age, $gender, $phone) {
        $query = "INSERT INTO docgia (ten_docgia, tuoi_docgia, gioitinh_docgia, sdt_docgia) 
        VALUES (n'$name', n'$age', n'$gender', n'$phone')";
        return mysqli_query($this->conn, $query);
    }
    public function updateDocgia($id, $name, $age, $gender, $phone) {
        $query = "UPDATE docgia SET ten_docgia=n'$name', tuoi_docgia= n'$age', 
        gioitinh_docgia= n'$gender', sdt_docgia= n'$phone' WHERE docgia_id=$id";
        return mysqli_query($this->conn, $query);
    }
    public function deleteDocgia($id) {
        $query = "DELETE FROM docgia WHERE docgia_id=$id";
        return mysqli_query($this->conn, $query);
    }
}
function readAllDocgia($docgiaModel) {
    $docgia = $docgiaModel->readAllDocgia();
    if (count($docgia) > 0) {
        echo json_encode($docgia); // Trả về danh sách độc giả
    } else {
        echo json_encode(["message" => "Không tồn tại độc giả nào!"]);
    }
}

function readDocgiaById($docgiaModel) {
    $docgia_id = $_GET['id']; // Lấy ID từ URL
    $docgia = $docgiaModel->readDocgiaById($docgia_id);
    if ($docgia) {
        echo json_encode($docgia); // Trả về dữ liệu độc giả theo ID
    } else {
        echo json_encode(["message" => "Không tìm thấy độc giả nào với ID: $docgia_id"]);
    }
}
function addDocgia($docgiaModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    if (!isset($data['ten_docgia']) || !isset($data['tuoi_docgia']) || !isset($data['gioitinh_docgia']) || !isset($data['sdt_docgia'])) {
        echo json_encode(["message" => "Thiếu dữ liệu!"]);
        return;
    }
        $name = $data["ten_docgia"];
        $age = $data["tuoi_docgia"];
        $gender = $data["gioitinh_docgia"];
        $phone = $data["sdt_docgia"];
        // $image = $docgiaModel["hinhanh_docgia"];


    if ($docgiaModel->addDocgia($name, $age, $gender, $phone)) {
        echo json_encode(["message" => "Thêm độc giả thành công!"]);
    } else {
        echo json_encode(["message" => "Thêm độc giả thất bại!"]);
    }
}
function updateDocgia($docgiaModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    if (!isset($data['ten_docgia']) || !isset($data['tuoi_docgia']) || !isset($data['gioitinh_docgia']) || !isset($data['sdt_docgia'])) {
        echo json_encode(["message" => "Thiếu dữ liệu"]);
        return;
    }
        $id= $data["docgia_id"];
        $name = $data["ten_docgia"];
        $age = $data["tuoi_docgia"];
        $gender = $data["gioitinh_docgia"];
        $phone = $data["sdt_docgia"];
        $image = $data["hinhanh_docgia"];

    if ($docgiaModel->updateDocgia($id,$name, $age, $gender, $phone, $image)) {
        echo json_encode(["message" => "Cập nhập thông tin độc giả thành công!"]);
    } else {
        echo json_encode(["message" => "Cập nhật thông tin độc giả thất bại!"]);
    }
}
function deleteDocgia($docgiaModel) {
   
    if ($docgiaModel->deleteDocgia($docgiaModel)) {
        echo json_encode(["message" => "Xoá độc giả thành công!"]);
    } else {
        echo json_encode(["message" => "Xóa độc giả thất bại!"]);
    }
}
?>