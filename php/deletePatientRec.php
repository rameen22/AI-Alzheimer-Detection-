<?php
include 'connect2.php';
if(isset($_GET['deleteid'])){
    $id=$_GET['deleteid'];

    $sql="delete from newpatient where id=$id";
    $result=mysqli_query($con,$sql);
    if($result){
        header('location:AddPatientInfo.php');
    }
    else{
        die(mysqli_error($con));
    }
}



?>
