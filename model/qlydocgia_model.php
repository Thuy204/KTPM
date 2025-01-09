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
    public function addSach($tenSach, $tacgiaId, $theloaiId, $nxbId, $mota, $soluong) {
        $query = "INSERT INTO " . $this->table . " 
            (ten_sach, tacgia_id, theloai_id, nxb_id, mota_sach, soluong_tonkho) 
            VALUES (n'$tenSach', $tacgiaId, $theloaiId, $nxbId, n'$mota', $soluong)";

        return mysqli_query($this->conn, $query);
    }

    // Cập nhật thông tin sách
    public function updateSach($id, $tenSach, $tacgiaId, $theloaiId, $nxbId, $mota, $soluong) {
        $query = "UPDATE " . $this->table . " 
            SET ten_sach = n'$tenSach', tacgia_id = $tacgiaId, theloai_id = $theloaiId, 
                nxb_id = $nxbId, mota_sach = n'$mota', soluong_tonkho = $soluong 
            WHERE sach_id = $id";

        return mysqli_query($this->conn, $query);
    }

    // Xóa sách theo ID
    public function deleteSach($id) {
        $query = "DELETE FROM " . $this->table . " WHERE sach_id = $id";
        return mysqli_query($this->conn, $query);
    }
}
function addSach($sachModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    if (!isset($data['ten_sach']) || !isset($data['tacgia_id']) || !isset($data['theloai_id']) || !isset($data['nxb_id']) || !isset($data['mota_sach']) || !isset($data['soluong_tonkho'])) {
        echo json_encode(["message" => "Thiếu dữ liệu!"]);
        return;
    }

    $tenSach = $data["ten_sach"];
    $tacgiaId = $data["tacgia_id"];
    $theloaiId = $data["theloai_id"];
    $nxbId = $data["nxb_id"];
    $mota = $data["mota_sach"];
    $soluong = $data["soluong_tonkho"];

    if ($sachModel->addSach($tenSach, $tacgiaId, $theloaiId, $nxbId, $mota, $soluong)) {
        echo json_encode(["message" => "Thêm sách thành công!"]);
    } else {
        echo json_encode(["message" => "Thêm sách thất bại!"]);
    }
}

function updateDocgia($docgiaModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    if (!isset($data['ten_docgia']) || !isset($data['tuoi_docgia']) || !isset($data['gioitinh_docgia']) || !isset($data['sdt_docgia']) || !isset($data['email'])) {
        echo json_encode(["message" => "Thiếu dữ liệu"]);
        return;
    }
        $id= $data["docgia_id"];
        $name = $data["ten_docgia"];
        $age = $data["tuoi_docgia"];
        $gender = $data["gioitinh_docgia"];
        $phone = $data["sdt_docgia"];
        $email = $data["email"];

    if ($docgiaModel->updateDocgia($id,$name, $age, $gender, $phone, $email)) {
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