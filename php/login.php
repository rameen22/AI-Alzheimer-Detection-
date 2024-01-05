<?php
session_start();

$email = $_POST["email"];
$password = $_POST["password"];
$usertype = $_POST["usertype"];

$conn = new mysqli('localhost:3308', 'root', '', 'website');
if ($conn->connect_error) {
    die('connection failed: ' . $conn->connect_error);
} else {
    $select = "SELECT * FROM registration WHERE email = '$email' && password = '$password' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        if ($row['usertype'] == 'doctor') {
            // Save doctor ID in session
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
             // Assuming 'id' is the column name for the doctor's ID
            header('location:index.html');
        } elseif ($row['usertype'] == 'patient') {
            // Redirect to patient page
            $_SESSION['email'] = $row['email'];

            header('location:index2.php');
        }
    } else {
        $error[] = 'incorrect email or password!';
    }
}
?>
