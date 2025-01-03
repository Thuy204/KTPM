<?php include'../config/db.php'; ?>
<?php
    if(isset($_GET['id'])){
        $id=$_GET['id'];
    }
    $query= "DELETE FROM tacgia WHERE tacgia_id='$id'";
    $result=mysqli_query($conn, $query);
    if(!$query){
        echo" Lỗi xóa ";
    }
    else{
        header('Location:index.php');
    }
?>