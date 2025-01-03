<?php require_once '../config/db.php';?>
<?php
        if(isset($_GET['id'])){
            $id =$_GET['id'];
        
                $query="SELECT* FROM cosovatchat WHERE csvc_id= '$id'";

                $result= mysqli_query($conn, $query);
                if(!$result){
                    echo "Không có dữ liệu";
                }else{
                    $row= mysqli_fetch_assoc($result);   
                }       
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
    <link rel="stylesheet" href="../view/style.css">
</head>
<body>
    <div class="edit">
    <div class="container" style="justify-content: center;" >
    <form method="POST">
        <h3 class="text-center mt-2 mb-3">Sửa thông tin cơ sở vật chất</h3>
        <div class="mt-2 mb-3">
            <label>ID</label>
            <input type="number" name="id_csvc" placeholder="Enter ID" class="form-control" value="<?php echo isset($row['csvc_id']) ? $row['csvc_id'] : ''; ?>" disabled>
        </div>
        <div class=" mt-2 mb-3">
            <label>Tên CSVC</label>
            <input type="text" name="ten_csvc" placeholder="Enter Name" class="form-control" value="<?php echo isset($row['ten_csvc']) ? $row['ten_csvc'] : ''; ?>" required>
        </div>
        <div class=" mt-2 mb-3">
            <label>Số Lượng</label>
            <input type="number" name="sl_csvc" placeholder="Enter number" class="form-control" value="<?php echo isset($row['soluong_csvc']) ? $row['soluong_csvc'] : ''; ?>" required>
        </div>
        <div class=" mt-2 mb-3">
            <label>Tình Trạng</label>
            <div class="radio">
                <label style="margin-left: 10px;"><input type="radio" name="tt_csvc" checked="checked" value="1">Mới</label>
                <label style="margin: 10px;"><input type="radio" name="tt_csvc" value="0">Cũ</label>
            </div>
        </div>
        <div class="text-center mb-2">
            <a href="index.php" class="btn btn-secondary" style="margin-right: 200px;">HỦY</a>
            <input type="submit" class="btn btn-success" name="sua_csvc" value="UPDATE">
        </div>
            
    </form>
    </div>
    </div>
    
</body>
</html>

<?php    
        if(isset($_POST['sua_csvc'])){
            $ten=$_POST['ten_csvc'];
            $sl=$_POST['sl_csvc'];
            $tinhtrang=$_POST['tt_csvc'];
            $query="UPDATE cosovatchat SET ten_csvc = '$ten', soluong_csvc ='$sl', tinhtrang_csvc= '$tinhtrang' WHERE csvc_id= '$id' ";
            $result= mysqli_query($conn, $query);
                if(!$result){
                    echo "Lỗi cập nhật thông tin";
                }else{
                    echo "<script type='text/javascript'>
                        alert('Cập nhật dữ liệu thành công!');
                        window.location.href='index.php';
                        </script>";
                }
        }
    ?>
    
    