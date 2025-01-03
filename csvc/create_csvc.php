<?php
    require_once '../config/db.php';
    if(isset($_POST['them_csvc'])){
        $id= $_POST['id_csvc'];
        $ten= $_POST['ten_csvc'];
        $sl= $_POST['sl_csvc'];
        $tinhtrang= $_POST['tt_csvc'];
        if($id==""|| empty($id)){
            header('Location:index.php');
            exit();
        }
        else{
            $query= "INSERT INTO cosovatchat (csvc_id, ten_csvc, soluong_csvc, tinhtrang_csvc) VALUES ('$id', '$ten', '$sl', '$tinhtrang')";
            $result=mysqli_query($conn, $query);
            if(!$result){
                echo'DL khong hop le';
            }
            else{
                header('Location: index.php');           
            }
        }
    }
?>