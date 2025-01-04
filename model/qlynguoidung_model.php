<?php
class NguoiDung {
    private $conn;
    private $table = "nguoidung";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAllNguoiDung() {
        $query = "SELECT * FROM " . $this->table;
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function readNguoiDungById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_nguoidung = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function addNguoiDung($name, $email, $password, $role) {
        $query = "INSERT INTO " . $this->table . " (ten_nguoidung, email_nguoidung, matkhau_nguoidung, vaitro_nguoidung) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $name, $email, $password, $role);

        return $stmt->execute();
    }

    public function updateNguoiDung($id, $name, $email, $password, $role) {
        $query = "UPDATE " . $this->table . " SET ten_nguoidung = ?, email_nguoidung = ?, matkhau_nguoidung = ?, vaitro_nguoidung = ? WHERE id_nguoidung = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssi", $name, $email, $password, $role, $id);

        return $stmt->execute();
    }

    public function deleteNguoiDung($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id_nguoidung = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

// Các hàm xử lý API
function readAllNguoiDung($nguoiDungModel) {
    $nguoidung = $nguoiDungModel->readAllNguoiDung();
    if (count($nguoidung) > 0) {
        echo json_encode($nguoidung);
    } else {
        echo json_encode(["message" => "Không tồn tại người dùng nào!"]);
    }
}

function readNguoiDungById($nguoiDungModel) {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        echo json_encode(["message" => "Thiếu ID người dùng!"]);
        return;
    }

    $nguoidung = $nguoiDungModel->readNguoiDungById($id);
    if ($nguoidung) {
        echo json_encode($nguoidung);
    } else {
        echo json_encode(["message" => "Không tìm thấy người dùng với ID: $id"]);
    }
}

function addNguoiDung($nguoiDungModel) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['ten_nguoidung'], $data['email_nguoidung'], $data['matkhau_nguoidung'], $data['vaitro_nguoidung'])) {
        echo json_encode(["message" => "Thiếu dữ liệu!"]);
        return;
    }

    $name = $data['ten_nguoidung'];
    $email = $data['email_nguoidung'];
    $password = password_hash($data['matkhau_nguoidung'], PASSWORD_BCRYPT);
    $role = $data['vaitro_nguoidung'];

    if ($nguoiDungModel->addNguoiDung($name, $email, $password, $role)) {
        echo json_encode(["message" => "Thêm người dùng thành công!"]);
    } else {
        echo json_encode(["message" => "Thêm người dùng thất bại!"]);
    }
}

function updateNguoiDung($nguoiDungModel) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id_nguoidung'], $data['ten_nguoidung'], $data['email_nguoidung'], $data['matkhau_nguoidung'], $data['vaitro_nguoidung'])) {
        echo json_encode(["message" => "Thiếu dữ liệu!"]);
        return;
    }

    $id = $data['id_nguoidung'];
    $name = $data['ten_nguoidung'];
    $email = $data['email_nguoidung'];
    $password = password_hash($data['matkhau_nguoidung'], PASSWORD_BCRYPT);
    $role = $data['vaitro_nguoidung'];

    if ($nguoiDungModel->updateNguoiDung($id, $name, $email, $password, $role)) {
        echo json_encode(["message" => "Cập nhật thông tin người dùng thành công!"]);
    } else {
        echo json_encode(["message" => "Cập nhật thông tin người dùng thất bại!"]);
    }
}

function deleteNguoiDung($nguoiDungModel) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id_nguoidung'])) {
        echo json_encode(["message" => "Thiếu ID người dùng!"]);
        return;
    }

    $id = $data['id_nguoidung'];

    if ($nguoiDungModel->deleteNguoiDung($id)) {
        echo json_encode(["message" => "Xoá người dùng thành công!"]);
    } else {
        echo json_encode(["message" => "Xoá người dùng thất bại!"]);
    }
}
?>
