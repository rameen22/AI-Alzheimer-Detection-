<?php
include 'connect2.php';
if(isset($_GET['deleteid'])){
    $id=$_GET['deleteid'];

    $sql="delete from prescriptions where id=$id";
    $result=mysqli_query($con,$sql);
    if($result){
        header('location:viewrecord.php');
    }
    else{
        die(mysqli_error($con));
    }
}



?>
