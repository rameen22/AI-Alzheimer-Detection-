<?php
include 'connect2.php';
if(isset($_GET['deleteid'])){
    $id=$_GET['deleteid'];

    $sql="DELETE from reports where id=$id";
    $result=mysqli_query($con,$sql);
    if($result){
        header('location:patientinbox.php');
    }
    else{
        die(mysqli_error($con));
    }
}



?>
