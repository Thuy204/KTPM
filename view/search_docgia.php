<?php
        include '../frontend/head.php';
        include '../config/db.php';
    ?>
<?php
    if(isset($_POST['timkiem'])){
        $timdocgia= $_POST['tim_docgia'];
    }
?>
<div class="container">
    <h4>Kết quả tìm kiếm:</h4>
    <table class="table table-striped table-hover">
        <thead>
        <th>STT</th>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Gender</th>
            <th>SĐT</th>
        </thead>
        <tbody>
<?php
    $query="SELECT *FROM docgia WHERE ten_docgia LIKE '%$timdocgia%'";
    $result=mysqli_query($conn, $query);
    if(!$result){
            echo "Không tìm thấy thông tin!";}
        else{
            $num=1;
            while($row=mysqli_fetch_array($result)){
                echo"
                    <tr>
                        <td>".($num++)."</td>
                        <td>".$row["docgia_id"]."</td>
                        <td>".$row["ten_docgia"]."</td>
                        <td>".$row["tuoi_docgia"]."</td>
                        <td>".($row["gioitinh_docgia"] == 1 ? 'Nam' : 'Nữ')."</td>
                        <td>".$row["sdt_docgia"]."</td>
                    </tr>";
        }
        echo "</tbody>
            </table>";

        }
?>
<a href="index.php" class="btn btn-warning ">Quay lại</a>
</div>