<?php
        include '../view/head.php';
        include '../config/db.php';
    ?>
<?php
    if(isset($_POST['timkiem'])){
        $timcsvc= $_POST['tim_csvc'];
    }
?>
<div class="container">
    <h4>Kết quả tìm kiếm:</h4>
    <table class="table table-striped table-hover">
        <thead>
            <th>STT</th>
            <th>Mã</th>
            <th>Tên</th>
            <th>Số lượng</th>
            <th>Tình trạng</th>
        </thead>
        <tbody>
<?php
    $query="SELECT *FROM cosovatchat WHERE ten_csvc LIKE '%$timcsvc%'";
    $result=mysqli_query($conn, $query);
    if(!$result){
            echo "Khong tim thay thong tin!";}
        else{
            $num=1;
            while($row=mysqli_fetch_array($result)){
                echo"
                            <tr>
                            <td>".($num++)."</td>
                            <td>".$row["csvc_id"]."</td>
                            <td>".$row["ten_csvc"]."</td>
                            <td>".$row["soluong_csvc"]."</td>
                            <td>".($row["tinhtrang_csvc"] == 1 ? 'Mới' : 'Cũ')."</td>
                            </tr>";
        }
        echo "</tbody>
            </table>";

        }
?>
<a href="index.php" class="btn btn-warning ">Quay lại</a>
</div>