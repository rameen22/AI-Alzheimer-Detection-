<?php



//database connection
$con = new mysqli('localhost:3308','root','','website');
if(!$con){
    die(mysqli_error($con));
}

?>