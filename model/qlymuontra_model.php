<?php
class Muontra{
    private $conn;
    private $table = "muontra";

    public function __construct($db) {
        $this->conn = $db;
    }
    public function readAllMuontra() {
        $query = "SELECT 
        muontra_id, d.ten_docgia, s.ten_sach,
        soluong, ngaymuon, hantra, ngaytra, trang_thai
    FROM 
        muon_tra mt
    JOIN 
        docgia d ON mt.docgia_id = d.docgia_id
    JOIN 
        sach s ON mt.sach_id = s.sach_id";
        $result = mysqli_query($this->conn, $query);

        // Kiểm tra kết quả và trả về dữ liệu dạng mảng
        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC); // Trả về kết quả dạng mảng liên kết
        } else {
            return [];
        }
    }
    public function readMuontraById($id) {
        $query = "SELECT 
        muontra_id, d.ten_docgia, s.ten_sach,
        soluong, ngaymuon, hantra, ngaytra, trang_thai
    FROM 
        muon_tra mt
    JOIN 
        docgia d ON mt.docgia_id = d.docgia_id
    JOIN 
        sach s ON mt.sach_id = s.sach_id
    WHERE 
        muontra_id=$id";
        $result = mysqli_query($this->conn, $query);

        // Kiểm tra kết quả và trả về dữ liệu dạng mảng
        if ($result) {
            return mysqli_fetch_assoc($result); // Trả về kết quả dạng mảng kết hợp
        } else {
            return null;
        }
    }
    public function addMuontra($docgia_id, $ngaymuon, $hantra, $sach_id, $soluong ) {
        $trang_thai = 'Đang mượn';
        $query = "INSERT INTO muon_tra (docgia_id, ngaymuon, hantra, sach_id, soluong, trang_thai) 
        VALUES (n'$docgia_id', n'$ngaymuon', n'$hantra', n'$sach_id',n'$soluong',n'$trang_thai')";
        // Thực hiện truy vấn thêm phiếu mượn
        if (mysqli_query($this->conn, $query)) {
            // Cập nhật số lượng tồn kho
            $update_query = "UPDATE sach SET soluong_tonkho = soluong_tonkho - ? WHERE sach_id = ?";
            if ($stmt = $this->conn->prepare($update_query)) {
                $stmt->bind_param("ii", $soluong, $sach_id);
                $stmt->execute();
                $stmt->close();
            }
            return true; // Trả về true nếu thành công
        } else {
            return false; // Trả về false nếu thất bại
        }
    }
    public function updateMuontra($muontra_id, $ngaytra) {
        //Lấy hạn trả
        $sqlcheck= "SELECT hantra FROM muon_tra WHERE muontra_id= '$muontra_id'";
        $result= mysqli_query($this->conn, $sqlcheck);
        // Kiểm tra xem có bản ghi nào không
        if (!$result || mysqli_num_rows($result) === 0) {
            throw new Exception('Không tìm thấy phiếu mượn trả với ID: ' . $muontra_id);
        }

        $row = mysqli_fetch_assoc($result);
        $hantra = $row['hantra']; // Lấy hạn trả từ kết quả
        $trang_thai = $this->getTrangThai($hantra, $ngaytra);
        $query = "UPDATE muon_tra SET  ngaytra='$ngaytra', trang_thai=n'$trang_thai' WHERE muontra_id=$muontra_id";
        return mysqli_query($this->conn, $query);
    }
    private function getTrangThai($hantra, $ngaytra) {
        $hantraDate = DateTime::createFromFormat('Y-m-d', $hantra);
        $ngaytraDate = DateTime::createFromFormat('Y-m-d', $ngaytra);
        $today = new DateTime();
        // Kiểm tra trạng thái dựa trên ngày trả và hạn trả
        if ($ngaytraDate <= $hantraDate) {
            return 'Đã trả'; // Nếu ngày trả không null và <= hạn trả
            } 
        else if ($ngaytraDate === null) {
            // Nếu ngày trả là null, kiểm tra hạn trả
            $today = date('Y-m-d');
                if ($hantra < $today) {
                    return 'Quá hạn'; // Nếu hạn trả đã qua thời điểm hiện tại
            }   else {
                    return 'Chưa trả'; // Nếu hạn trả chưa qua
                }
            }
        else {
            // Nếu ngày trả không null nhưng lớn hơn hạn trả
                    return 'Quá hạn';
            }
    }
    public function deleteMuontra($muontra_id) {
        $query = "DELETE FROM muon_tra WHERE muontra_id=$muontra_id";
        return mysqli_query($this->conn, $query);
    }
    }
    function readAllMuontra($muontraModel) {
        $muontra = $muontraModel->readAllMuontra();
        if (count($muontra) > 0) {
            echo json_encode($muontra); // Trả về danh sách độc giả
        } else {
            echo json_encode(["message" => "Không tồn tại phiếu mượn trả nào!"]);
        }
    }

function readMuontraById($muontraModel) {
    $muontra_id = $_GET['id']; // Lấy ID từ URL
    $muontra = $muontraModel->readMuontraById($muontra_id);
    if ($muontra) {
        echo json_encode($muontra); // Trả về dữ liệu độc giả theo ID
    } else {
        echo json_encode(["message" => "Không tìm thấy hiếu mượn trả nào với ID: $muontra_id"]);
    }
}
function addMuontra($muontraModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    if (!isset($data['docgia_id']) || !isset($data['ngaymuon']) || !isset($data['hantra']) || !isset($data['sach_id'])
    || !isset($data['soluong'])) {
        echo json_encode(["message" => "Thiếu dữ liệu!"]);
        return;
    }
        $docgia_id = $data["docgia_id"];
        $ngaymuon = $data["ngaymuon"];
        $hantra = $data["hantra"];
        $sach_id = $data["sach_id"];
        $soluong= $data["soluong"];


    if ($muontraModel->addMuontra($docgia_id, $ngaymuon, $hantra, $sach_id, $soluong)) {
        echo json_encode(["message" => "Thêm phiếu mượn thành công!"]);
    } else {
        echo json_encode(["message" => "Thêm phiêú mượn thất bại!"]);
    }
}
function updateMuontra($muontraModel) {
    $data = json_decode(file_get_contents("php://input"), true); // Lấy dữ liệu JSON từ Postman
    $muontra_id= $data["muontra_id"];
    $ngaytra= $data["ngaytra"];

    if ($muontraModel->updateMuontra($muontra_id, $ngaytra)) {
        echo json_encode(["message" => "Cập nhập thông tin phiếu thành công!"]);
    } else {
        echo json_encode(["message" => "Cập nhật thông tin phiếu thất bại!"]);
    }
}
function deleteMuontra($muontraModel) {
   
    if ($muontraModel->deleteMuontra($muontraModel)) {
        echo json_encode(["message" => "Xoá phiếu thành công!"]);
    } else {
        echo json_encode(["message" => "Xóa phiếu thất bại!"]);
    }
}
?>
