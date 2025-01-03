<?php
        include '../view/head.php';
        include '../config/db.php';
    ?>
<?php
    if(isset($_POST['timkiem'])){
        $timcnxb= $_POST['tim_nxb'];
    }
?>
<div class="container">
    <h4>Kết quả tìm kiếm:</h4>
    <table class="table table-striped table-hover">
        <thead>
            <th>STT</th>
            <th>Mã</th>
            <th>Tên</th>
            <th>Thông tin</th>
            <th>Hình ảnh</th>
        </thead>
        <tbody>
<?php
    $query="SELECT *FROM nhaxuatban WHERE ten_nxb LIKE '$timnxb'";
    $result=mysqli_query($conn, $query);
    if(!$result){
            echo "Khong tim thay thong tin!";}
        else{
            $num=1;
            while($row=mysqli_fetch_array($result)){
                echo"
                            <tr>
                            <td>".($num++)."</td>
                            <td>".$row["nxb_id"]."</td>
                            <td>".$row["ten_nxb"]."</td>
                            <td>".$row["thongtin_nxb"]."</td>
                            <td>".$row["hinhanh_nxb"]."</td>
                            </tr>";
        }
        echo "</tbody>
            </table>";

        }
?>
<a href="index.php" class="btn btn-warning ">Quay lại</a>
</div>