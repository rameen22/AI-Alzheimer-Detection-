<?php
session_start();
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$usertype = $_POST['usertype'];



//database connection
$conn = new mysqli('localhost:3308','root','','website');
if($conn->connect_error){
    die('connection failed :'.$conn->connect_error);
}
else{
    $sql="SELECT * from registration where email='$email'";
    $result=mysqli_query($conn, $sql);
    $present=mysqli_num_rows($result);
    if($present>0){
        $_SESSION['email_alert']='1';
        echo "Email Already Exists!!...";
        //header("location:home.php");

    }
    else{
        
        header("location:home.php");
        //echo "registeration Successfully...";
    
    $stmt= $conn->prepare("insert into registration(username, email, password, usertype)
    values(?,?,?,?)");
    $stmt->bind_param("ssss", $username, $email, $password, $usertype);
    
    $stmt->execute();
    //echo "registeration Successfully...";
    $stmt->close();
    $conn->close();
}
}
?>